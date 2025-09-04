<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\ExamResult;
use App\Models\ExamSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = User::where('role', 'siswa')->count();
        $totalQuestions = Question::count();
        $totalExams = ExamResult::count();
        $averageScore = ExamResult::avg('score') ?? 0;
        
        return view('admin.dashboard', compact('totalStudents', 'totalQuestions', 'totalExams', 'averageScore'));
    }

    public function students()
    {
        $students = User::where('role', 'siswa')->paginate(10);
        return view('admin.students', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.create-student');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.students')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function questions()
    {
        $questions = Question::paginate(10);
        return view('admin.questions', compact('questions'));
    }

    public function createQuestion()
    {
        return view('admin.create-question');
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Question::create($request->all());

        return redirect()->route('admin.questions')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function scores()
    {
        $examResults = ExamResult::with('user')
            ->orderBy('completed_at', 'desc')
            ->paginate(15);
        
        $averageScore = ExamResult::avg('score') ?? 0;
        $totalExams = ExamResult::count();
        
        return view('admin.scores', compact('examResults', 'averageScore', 'totalExams'));
    }

    public function examSettings()
    {
        $examDuration = ExamSetting::getValue('exam_duration', 60);
        $questionsPerExam = ExamSetting::getValue('questions_per_exam', 10);
        $passingScore = ExamSetting::getValue('passing_score', 70);
        $showResults = ExamSetting::getValue('show_results', 'immediately');
        
        return view('admin.exam-settings', compact('examDuration', 'questionsPerExam', 'passingScore', 'showResults'));
    }

    public function updateExamSettings(Request $request)
    {
        $request->validate([
            'exam_duration' => 'required|integer|min:1|max:300',
            'questions_per_exam' => 'required|integer|min:1|max:100',
            'passing_score' => 'required|integer|min:0|max:100',
            'show_results' => 'required|in:immediately,after_all,manual',
        ]);

        ExamSetting::setValue('exam_duration', $request->exam_duration, 'Durasi ujian dalam menit');
        ExamSetting::setValue('questions_per_exam', $request->questions_per_exam, 'Jumlah soal per ujian');
        ExamSetting::setValue('passing_score', $request->passing_score, 'Nilai minimum untuk lulus (dalam persen)');
        ExamSetting::setValue('show_results', $request->show_results, 'Kapan hasil ujian ditampilkan');

        return redirect()->route('admin.exam-settings')
            ->with('success', 'Pengaturan ujian berhasil diperbarui!');
    }
}
