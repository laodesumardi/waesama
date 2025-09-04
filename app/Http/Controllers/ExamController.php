<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\ExamResult;
use App\Models\ExamSetting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $recentExams = $user->examResults()->orderBy('completed_at', 'desc')->take(5)->get();
        $totalExams = $user->examResults()->count();
        $averageScore = $user->examResults()->avg('score') ?? 0;
        $highestScore = $user->examResults()->max('score') ?? 0;
        $totalQuestions = Question::count();
        
        // Get exam settings
        $questionsPerExam = ExamSetting::getQuestionsPerExam();
        
        // Check if user can take exam (no exam taken today or last exam was more than 24 hours ago)
        $lastExam = $user->examResults()->latest('completed_at')->first();
        $canTakeExam = !$lastExam || $lastExam->completed_at->diffInHours(now()) >= 24;
        
        // Set exam message for when exam is not available
        $examMessage = 'Anda sudah mengikuti ujian hari ini. Silakan coba lagi besok.';
        if ($totalQuestions < $questionsPerExam) {
            $examMessage = "Belum cukup soal untuk memulai ujian. Diperlukan minimal {$questionsPerExam} soal.";
        }
        
        return view('siswa.dashboard', compact('recentExams', 'totalExams', 'averageScore', 'highestScore', 'totalQuestions', 'canTakeExam', 'examMessage', 'questionsPerExam'));
    }

    public function startExam()
    {
        $totalQuestions = Question::count();
        $questionsPerExam = ExamSetting::getQuestionsPerExam();
        $examDuration = ExamSetting::getExamDuration();
        
        if ($totalQuestions < $questionsPerExam) {
            return redirect()->route('student.dashboard')
                ->with('error', "Belum cukup soal untuk memulai ujian. Diperlukan minimal {$questionsPerExam} soal.");
        }
        
        // Ambil soal secara acak sesuai pengaturan
        $questions = Question::inRandomOrder()->take($questionsPerExam)->get();
        
        // Simpan ID soal dan pengaturan ujian ke session untuk konsistensi
        session([
            'exam_questions' => $questions->pluck('id')->toArray(),
            'exam_start_time' => now(),
            'exam_duration' => $examDuration,
            'questions_per_exam' => $questionsPerExam
        ]);
        
        return view('siswa.exam', compact('questions', 'examDuration'));
    }

    public function submitExam(Request $request)
    {
        $questionIds = session('exam_questions');
        $startTime = session('exam_start_time');
        $questionsPerExam = session('questions_per_exam');
        
        if (!$questionIds || !$startTime || !$questionsPerExam) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Sesi ujian tidak valid. Silakan mulai ujian kembali.');
        }
        
        $questions = Question::whereIn('id', $questionIds)->get();
        $answers = $request->input('answers', []);
        
        $score = 0;
        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer === $question->correct_answer) {
                $score++;
            }
        }
        
        // Simpan hasil ujian
        $examResult = ExamResult::create([
            'user_id' => Auth::id(),
            'score' => $score,
            'total_questions' => $questionsPerExam,
            'completed_at' => now(),
        ]);
        
        // Hapus session ujian
        session()->forget(['exam_questions', 'exam_start_time', 'exam_duration', 'questions_per_exam']);
        
        return redirect()->route('student.result', $examResult->id)
            ->with('success', 'Ujian berhasil diselesaikan!');
    }

    public function showResult($id)
    {
        $examResult = ExamResult::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        return view('siswa.result', compact('examResult'));
    }

    public function history()
    {
        $examResults = Auth::user()->examResults()
            ->orderBy('completed_at', 'desc')
            ->paginate(10);
        
        $averageScore = Auth::user()->examResults()->avg('score') ?? 0;
        $highestScore = Auth::user()->examResults()->max('score') ?? 0;
        $lowestScore = Auth::user()->examResults()->min('score') ?? 0;
            
        return view('siswa.history', compact('examResults', 'averageScore', 'highestScore', 'lowestScore'));
    }
}
