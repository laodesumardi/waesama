<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Antrian::with('server');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_antrian', 'like', "%{$search}%")
                  ->orWhere('nama_pengunjung', 'like', "%{$search}%")
                  ->orWhere('nik_pengunjung', 'like', "%{$search}%")
                  ->orWhere('phone_pengunjung', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jenis layanan
        if ($request->filled('jenis_layanan')) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        // Filter by tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }

        $antrians = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get filter options
        $statusOptions = ['Menunggu', 'Dipanggil', 'Dilayani', 'Selesai', 'Batal'];
        $jenisLayananOptions = ['Surat Domisili', 'SKTM', 'Surat Usaha', 'Surat Pengantar', 'Konsultasi', 'Lainnya'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();

        return view('admin.antrian.index', compact('antrians', 'statusOptions', 'jenisLayananOptions', 'pegawaiUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisLayananOptions = ['Surat Domisili', 'SKTM', 'Surat Usaha', 'Surat Pengantar', 'Konsultasi', 'Lainnya'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();
        
        return view('admin.antrian.create', compact('jenisLayananOptions', 'pegawaiUsers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengunjung' => 'required|string|max:255',
            'nik_pengunjung' => 'nullable|string|size:16',
            'phone_pengunjung' => 'required|string|max:20',
            'jenis_layanan' => 'required|in:Surat Domisili,SKTM,Surat Usaha,Surat Pengantar,Konsultasi,Lainnya',
            'keperluan' => 'nullable|string',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
            'estimasi_waktu' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            'dilayani_oleh' => 'nullable|exists:users,id'
        ]);

        // Generate nomor antrian
        $validated['nomor_antrian'] = $this->generateNomorAntrian();
        $validated['status'] = 'Menunggu';

        $antrian = Antrian::create($validated);
        
        // Send notification to user if email exists
        $user = User::where('email', $antrian->email)->first();
        if ($user) {
            NotificationHelper::sendToUser(
                $user->id,
                auth()->id(),
                'antrian_created',
                'medium',
                'Antrian Baru Dibuat',
                "Antrian Anda nomor {$antrian->nomor_antrian} untuk layanan '{$antrian->jenis_layanan}' telah dibuat oleh admin.",
                [
                    'antrian_id' => $antrian->id,
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'jenis_layanan' => $antrian->jenis_layanan,
                    'tanggal_kunjungan' => $antrian->tanggal_kunjungan,
                    'jam_kunjungan' => $antrian->jam_kunjungan
                ],
                route('warga.antrian.show', $antrian->id)
            );
        }

        return redirect()->route('admin.antrian.index')
                        ->with('success', 'Antrian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Antrian $antrian)
    {
        $antrian->load('server');
        
        return view('admin.antrian.show', compact('antrian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Antrian $antrian)
    {
        $jenisLayananOptions = ['Surat Domisili', 'SKTM', 'Surat Usaha', 'Surat Pengantar', 'Konsultasi', 'Lainnya'];
        $statusOptions = ['Menunggu', 'Dipanggil', 'Dilayani', 'Selesai', 'Batal'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();
        
        return view('admin.antrian.edit', compact('antrian', 'jenisLayananOptions', 'statusOptions', 'pegawaiUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Antrian $antrian)
    {
        $validated = $request->validate([
            'nama_pengunjung' => 'required|string|max:255',
            'nik_pengunjung' => 'nullable|string|size:16',
            'phone_pengunjung' => 'required|string|max:20',
            'jenis_layanan' => 'required|in:Surat Domisili,SKTM,Surat Usaha,Surat Pengantar,Konsultasi,Lainnya',
            'keperluan' => 'nullable|string',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
            'status' => 'required|in:Menunggu,Dipanggil,Dilayani,Selesai,Batal',
            'estimasi_waktu' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            'dilayani_oleh' => 'nullable|exists:users,id'
        ]);

        // Capture old status for notification
        $oldStatus = $antrian->status;
        
        // Handle status changes
        if ($validated['status'] === 'Dilayani' && $antrian->status !== 'Dilayani') {
            $validated['waktu_mulai_layanan'] = now();
        }
        
        if ($validated['status'] === 'Selesai' && $antrian->status !== 'Selesai') {
            $validated['waktu_selesai_layanan'] = now();
            if (!$antrian->waktu_mulai_layanan) {
                $validated['waktu_mulai_layanan'] = now();
            }
        }

        $antrian->update($validated);
        
        // Send notification if status changed
        if ($oldStatus !== $validated['status']) {
            $this->sendAntrianStatusNotification($antrian, $validated['status']);
        }

        return redirect()->route('admin.antrian.index')
                        ->with('success', 'Antrian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Antrian $antrian)
    {
        $antrian->delete();

        return redirect()->route('admin.antrian.index')
                        ->with('success', 'Antrian berhasil dihapus.');
    }

    /**
     * Call the next antrian (change status to Dipanggil)
     */
    public function call(Antrian $antrian)
    {
        if ($antrian->status === 'Menunggu') {
            $antrian->update([
                'status' => 'Dipanggil',
                'dilayani_oleh' => Auth::id()
            ]);
            
            // Send notification
            $this->sendAntrianStatusNotification($antrian, 'Dipanggil');
            
            return redirect()->back()->with('success', 'Antrian berhasil dipanggil.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat dipanggil.');
    }

    /**
     * Start serving the antrian (change status to Dilayani)
     */
    public function serve(Antrian $antrian)
    {
        if (in_array($antrian->status, ['Menunggu', 'Dipanggil'])) {
            $antrian->update([
                'status' => 'Dilayani',
                'dilayani_oleh' => Auth::id(),
                'waktu_mulai_layanan' => now()
            ]);
            
            // Send notification
            $this->sendAntrianStatusNotification($antrian, 'Dilayani');
            
            return redirect()->back()->with('success', 'Antrian mulai dilayani.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat dilayani.');
    }

    /**
     * Complete the antrian (change status to Selesai)
     */
    public function complete(Antrian $antrian)
    {
        if ($antrian->status === 'Dilayani') {
            $antrian->update([
                'status' => 'Selesai',
                'waktu_selesai_layanan' => now()
            ]);
            
            // Send notification
            $this->sendAntrianStatusNotification($antrian, 'Selesai');
            
            return redirect()->back()->with('success', 'Antrian berhasil diselesaikan.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat diselesaikan.');
    }

    /**
     * Cancel the antrian (change status to Batal)
     */
    public function cancel(Antrian $antrian)
    {
        if (in_array($antrian->status, ['Menunggu', 'Dipanggil'])) {
            $antrian->update(['status' => 'Batal']);
            
            // Send notification
            $this->sendAntrianStatusNotification($antrian, 'Batal');
            
            return redirect()->back()->with('success', 'Antrian berhasil dibatalkan.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat dibatalkan.');
    }

    /**
     * Generate unique nomor antrian
     */
    private function generateNomorAntrian()
    {
        $today = Carbon::today();
        $prefix = 'A' . $today->format('ymd');
        
        $lastAntrian = Antrian::where('nomor_antrian', 'like', $prefix . '%')
                             ->orderBy('nomor_antrian', 'desc')
                             ->first();
        
        if ($lastAntrian) {
            $lastNumber = (int) substr($lastAntrian->nomor_antrian, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Display antrian dashboard
     */
    public function dashboard()
    {
        $today = Carbon::today();
        
        $stats = [
            'total_antrian_today' => Antrian::whereDate('tanggal_kunjungan', $today)->count(),
            'menunggu' => Antrian::whereDate('tanggal_kunjungan', $today)->where('status', 'Menunggu')->count(),
            'dipanggil' => Antrian::whereDate('tanggal_kunjungan', $today)->where('status', 'Dipanggil')->count(),
            'dilayani' => Antrian::whereDate('tanggal_kunjungan', $today)->where('status', 'Dilayani')->count(),
            'selesai' => Antrian::whereDate('tanggal_kunjungan', $today)->where('status', 'Selesai')->count(),
            'batal' => Antrian::whereDate('tanggal_kunjungan', $today)->where('status', 'Batal')->count(),
            'total_antrian_all' => Antrian::count(),
            'active_servers' => User::where('role_id', 2)->where('is_active', true)->count(),
        ];

        // Get recent antrians
        $recentAntrians = Antrian::with('server')
            ->whereDate('tanggal_kunjungan', $today)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get antrian by jenis layanan today
        $layananStats = Antrian::whereDate('tanggal_kunjungan', $today)
            ->selectRaw('jenis_layanan, count(*) as total')
            ->groupBy('jenis_layanan')
            ->get();

        return view('admin.antrian.dashboard', compact('stats', 'recentAntrians', 'layananStats'));
    }
    
    /**
     * Send notification when antrian status changes
     */
    private function sendAntrianStatusNotification($antrian, $status)
    {
        // Find user by email if exists
        $user = User::where('email', $antrian->email)->first();
        
        if ($user) {
            $statusMessages = [
                'Dipanggil' => 'dipanggil',
                'Dilayani' => 'sedang dilayani',
                'Selesai' => 'telah diselesaikan',
                'Batal' => 'dibatalkan',
                'Menunggu' => 'dalam status menunggu'
            ];
            
            NotificationHelper::sendToUser(
                $user->id,
                auth()->id(),
                'antrian_status',
                $status === 'Selesai' ? 'high' : 'medium',
                'Update Status Antrian',
                "Antrian Anda nomor {$antrian->nomor_antrian} untuk layanan '{$antrian->jenis_layanan}' {$statusMessages[$status]} oleh admin.",
                [
                    'antrian_id' => $antrian->id,
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'jenis_layanan' => $antrian->jenis_layanan,
                    'status' => $status,
                    'waktu_selesai' => $antrian->waktu_selesai_layanan
                ],
                route('warga.antrian.show', $antrian->id)
            );
        }
    }
}