<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WargaAntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's antrian with pagination
        $antrianList = Antrian::where('nik_pengunjung', $user->nik)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get today's queue statistics
        $todayStats = [
            'total_antrian' => Antrian::whereDate('tanggal_kunjungan', today())->count(),
            'antrian_selesai' => Antrian::whereDate('tanggal_kunjungan', today())
                ->where('status', 'Selesai')->count(),
            'antrian_proses' => Antrian::whereDate('tanggal_kunjungan', today())
                ->where('status', 'Sedang Dilayani')->count(),
            'antrian_menunggu' => Antrian::whereDate('tanggal_kunjungan', today())
                ->where('status', 'Menunggu')->count(),
        ];
        
        return view('warga.antrian.index', compact('antrianList', 'todayStats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get available time slots for today and tomorrow
        $availableSlots = $this->getAvailableTimeSlots();
        
        return view('warga.antrian.create', compact('availableSlots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'jenis_layanan' => 'required|in:Surat Domisili,SKTM,Surat Usaha,Surat Pengantar,Konsultasi,Lainnya',
            'keperluan' => 'required|string|max:500',
            'slot' => 'required|string',
        ]);
        
        // Parse slot value to get date and time
        if (!isset($validated['slot']) || !str_contains($validated['slot'], '|')) {
            return back()->withErrors(['slot' => 'Silakan pilih tanggal dan waktu kunjungan.'])->withInput();
        }
        
        [$tanggal_kunjungan, $jam_kunjungan] = explode('|', $validated['slot']);
        
        // Validate parsed date and time
        $validator = \Validator::make([
            'tanggal_kunjungan' => $tanggal_kunjungan,
            'jam_kunjungan' => $jam_kunjungan,
        ], [
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required|date_format:H:i',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $validated['tanggal_kunjungan'] = $tanggal_kunjungan;
        $validated['jam_kunjungan'] = $jam_kunjungan;
        
        // Check if the time slot is still available
        $existingAntrian = Antrian::where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->where('jam_kunjungan', $validated['jam_kunjungan'])
            ->where('status', '!=', 'Batal')
            ->count();
            
        if ($existingAntrian >= 3) {
            return back()->withErrors(['jam_kunjungan' => 'Slot waktu ini sudah penuh. Silakan pilih waktu lain.'])
                ->withInput();
        }
        
        // Generate queue number
        $nomorAntrian = $this->generateNomorAntrian($validated['tanggal_kunjungan']);
        
        // Create antrian
        $antrian = Antrian::create([
            'nomor_antrian' => $nomorAntrian,
            'nama_pengunjung' => $user->name,
            'nik_pengunjung' => $user->nik,
            'phone_pengunjung' => $user->phone ?? '',
            'email' => $user->email,
            'jenis_layanan' => $validated['jenis_layanan'],
            'keperluan' => $validated['keperluan'],
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'jam_kunjungan' => $validated['jam_kunjungan'],
            'status' => 'Menunggu',
            'estimasi_waktu' => 30, // Default 30 minutes
        ]);
        
        // Notify admins about new antrian
        NotificationHelper::notifyAdmins(
            $user->id,
            'antrian_created',
            'medium',
            'Antrian Baru dari Warga',
            "Antrian baru nomor {$antrian->nomor_antrian} untuk layanan '{$antrian->jenis_layanan}' telah dibuat oleh {$user->name}.",
            [
                'antrian_id' => $antrian->id,
                'nomor_antrian' => $antrian->nomor_antrian,
                'jenis_layanan' => $antrian->jenis_layanan,
                'nama_pengunjung' => $antrian->nama_pengunjung,
                'tanggal_kunjungan' => $antrian->tanggal_kunjungan,
                'jam_kunjungan' => $antrian->jam_kunjungan
            ],
            route('admin.antrian.show', $antrian->id)
        );
        
        return redirect()->route('warga.antrian.index')
            ->with('success', 'Antrian berhasil dibuat dengan nomor: ' . $nomorAntrian);
    }

    /**
     * Cancel the specified antrian.
     */
    public function cancel($id)
    {
        $user = Auth::user();
        
        $antrian = Antrian::where('id', $id)
            ->where('nik_pengunjung', $user->nik)
            ->where('status', 'Menunggu')
            ->firstOrFail();
            
        $antrian->update([
            'status' => 'Batal',
            'catatan' => 'Dibatalkan oleh warga'
        ]);
        
        // Notify admins about cancelled antrian
        NotificationHelper::notifyAdmins(
            $user->id,
            'antrian_cancelled',
            'low',
            'Antrian Dibatalkan oleh Warga',
            "Antrian nomor {$antrian->nomor_antrian} untuk layanan '{$antrian->jenis_layanan}' telah dibatalkan oleh {$user->name}.",
            [
                'antrian_id' => $antrian->id,
                'nomor_antrian' => $antrian->nomor_antrian,
                'jenis_layanan' => $antrian->jenis_layanan,
                'nama_pengunjung' => $antrian->nama_pengunjung
            ],
            route('admin.antrian.show', $antrian->id)
        );
        
        return redirect()->route('warga.antrian.index')
            ->with('success', 'Antrian berhasil dibatalkan.');
    }

    /**
     * Generate nomor antrian
     */
    private function generateNomorAntrian($tanggal)
    {
        $date = Carbon::parse($tanggal)->format('Ymd');
        $count = Antrian::whereDate('tanggal_kunjungan', $tanggal)->count() + 1;
        
        return 'A' . $date . sprintf('%03d', $count);
    }

    /**
     * Get available time slots
     */
    private function getAvailableTimeSlots()
    {
        $slots = [];
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        
        // Office hours: 08:00 - 16:00, every 30 minutes
        $timeSlots = [
            '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
            '11:00', '11:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00'
        ];
        
        foreach ([$today, $tomorrow] as $date) {
            $dateSlots = [];
            
            foreach ($timeSlots as $time) {
                $existingCount = Antrian::where('tanggal_kunjungan', $date->format('Y-m-d'))
                    ->where('jam_kunjungan', $time)
                    ->where('status', '!=', 'Batal')
                    ->count();
                    
                $available = $existingCount < 3;
                
                // If today, check if time has passed
                if ($date->isToday()) {
                    $timeCheck = Carbon::today()->setTimeFromTimeString($time);
                    if ($timeCheck->isPast()) {
                        $available = false;
                    }
                }
                
                $dateSlots[] = [
                    'time' => $time,
                    'available' => $available,
                    'remaining' => $available ? (3 - $existingCount) : 0
                ];
            }
            
            $slots[] = [
                'date' => $date->format('Y-m-d'),
                'date_formatted' => $date->format('d M Y'),
                'slots' => $dateSlots
            ];
        }
        
        return $slots;
    }
}