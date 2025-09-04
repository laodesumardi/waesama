<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Notification;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with('handler');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pengaduan', 'like', "%{$search}%")
                  ->orWhere('nama_pengadu', 'like', "%{$search}%")
                  ->orWhere('judul_pengaduan', 'like', "%{$search}%")
                  ->orWhere('email_pengadu', 'like', "%{$search}%")
                  ->orWhere('phone_pengadu', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Filter by prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }
        
        // Filter by handler
        if ($request->filled('handler')) {
            $query->where('ditangani_oleh', $request->handler);
        }
        
        // Sort by latest
        $pengaduan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get filter options
        $statusOptions = ['Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $kategoriOptions = ['Pelayanan', 'Infrastruktur', 'Keamanan', 'Kebersihan', 'Lainnya'];
        $prioritasOptions = ['Rendah', 'Sedang', 'Tinggi', 'Urgent'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();
        
        return view('admin.pengaduan.index', compact(
            'pengaduan', 
            'statusOptions', 
            'kategoriOptions', 
            'prioritasOptions', 
            'pegawaiUsers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions = ['Pelayanan', 'Infrastruktur', 'Keamanan', 'Kebersihan', 'Lainnya'];
        $prioritasOptions = ['Rendah', 'Sedang', 'Tinggi', 'Urgent'];
        $statusOptions = ['Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();
        
        return view('admin.pengaduan.create', compact(
            'kategoriOptions', 
            'prioritasOptions', 
            'statusOptions', 
            'pegawaiUsers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengadu' => 'required|string|max:255',
            'email_pengadu' => 'nullable|email|max:255',
            'phone_pengadu' => 'required|string|max:20',
            'alamat_pengadu' => 'required|string',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'kategori' => 'required|in:Pelayanan,Infrastruktur,Keamanan,Kebersihan,Lainnya',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Urgent',
            'status' => 'required|in:Diterima,Diproses,Ditindaklanjuti,Selesai,Ditolak',
            'tanggapan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'ditangani_oleh' => 'nullable|exists:users,id',
        ]);
        
        // Generate nomor pengaduan
        $validated['nomor_pengaduan'] = $this->generateNomorPengaduan();
        
        // Handle file upload
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengaduan', $filename, 'public');
            $validated['lampiran'] = $path;
        }
        
        // Set tanggal_ditangani if status is not 'Diterima'
        if ($validated['status'] !== 'Diterima' && $request->filled('ditangani_oleh')) {
            $validated['tanggal_ditangani'] = now();
        }
        
        // Set tanggal_selesai if status is 'Selesai'
        if ($validated['status'] === 'Selesai') {
            $validated['tanggal_selesai'] = now();
        }
        
        $pengaduan = Pengaduan::create($validated);
        
        // Send notification to admins about new pengaduan
        NotificationHelper::notifyAdmins(
            auth()->id(),
            'pengaduan_baru',
            $validated['prioritas'] === 'Urgent' ? 'high' : 'medium',
            'Pengaduan Baru',
            "Pengaduan baru dari {$validated['nama_pengadu']}: {$validated['judul_pengaduan']}",
            [
                'pengaduan_id' => $pengaduan->id,
                'nama_pengadu' => $validated['nama_pengadu'],
                'judul_pengaduan' => $validated['judul_pengaduan'],
                'kategori' => $validated['kategori'],
                'prioritas' => $validated['prioritas']
            ],
            route('admin.pengaduan.show', $pengaduan)
        );
        
        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('handler');
        
        $statusOptions = ['Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();
        
        return view('admin.pengaduan.show', compact('pengaduan', 'statusOptions', 'pegawaiUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        $kategoriOptions = ['Pelayanan', 'Infrastruktur', 'Keamanan', 'Kebersihan', 'Lainnya'];
        $prioritasOptions = ['Rendah', 'Sedang', 'Tinggi', 'Urgent'];
        $statusOptions = ['Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $pegawaiUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Pegawai');
        })->get();
        
        return view('admin.pengaduan.edit', compact(
            'pengaduan', 
            'kategoriOptions', 
            'prioritasOptions', 
            'statusOptions', 
            'pegawaiUsers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'nama_pengadu' => 'required|string|max:255',
            'email_pengadu' => 'nullable|email|max:255',
            'phone_pengadu' => 'required|string|max:20',
            'alamat_pengadu' => 'required|string',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'kategori' => 'required|in:Pelayanan,Infrastruktur,Keamanan,Kebersihan,Lainnya',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Urgent',
            'status' => 'required|in:Diterima,Diproses,Ditindaklanjuti,Selesai,Ditolak',
            'tanggapan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'ditangani_oleh' => 'nullable|exists:users,id',
        ]);
        
        // Handle file upload
        if ($request->hasFile('lampiran')) {
            // Delete old file if exists
            if ($pengaduan->lampiran && Storage::disk('public')->exists($pengaduan->lampiran)) {
                Storage::disk('public')->delete($pengaduan->lampiran);
            }
            
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pengaduan', $filename, 'public');
            $validated['lampiran'] = $path;
        }
        
        // Set tanggal_ditangani if status changed from 'Diterima' to other status
        if ($pengaduan->status === 'Diterima' && $validated['status'] !== 'Diterima' && $request->filled('ditangani_oleh')) {
            $validated['tanggal_ditangani'] = now();
        }
        
        // Set tanggal_selesai if status changed to 'Selesai'
        if ($pengaduan->status !== 'Selesai' && $validated['status'] === 'Selesai') {
            $validated['tanggal_selesai'] = now();
        }
        
        // Clear tanggal_selesai if status changed from 'Selesai' to other status
        if ($pengaduan->status === 'Selesai' && $validated['status'] !== 'Selesai') {
            $validated['tanggal_selesai'] = null;
        }
        
        $pengaduan->update($validated);
        
        return redirect()->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        // Delete file if exists
        if ($pengaduan->lampiran && Storage::disk('public')->exists($pengaduan->lampiran)) {
            Storage::disk('public')->delete($pengaduan->lampiran);
        }
        
        $pengaduan->delete();
        
        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
    
    /**
     * Process the pengaduan (change status to Diproses)
     */
    public function process(Pengaduan $pengaduan)
    {
        $pengaduan->update([
            'status' => 'Diproses',
            'ditangani_oleh' => auth()->id(),
            'tanggal_ditangani' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Pengaduan berhasil diproses.');
    }
    
    /**
     * Follow up the pengaduan (change status to Ditindaklanjuti)
     */
    public function followUp(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string',
        ]);
        
        $pengaduan->update([
            'status' => 'Ditindaklanjuti',
            'tanggapan' => $request->tanggapan,
            'ditangani_oleh' => auth()->id(),
            'tanggal_ditangani' => $pengaduan->tanggal_ditangani ?? now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Pengaduan berhasil ditindaklanjuti.');
    }
    
    /**
     * Complete the pengaduan (change status to Selesai)
     */
    public function complete(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string',
        ]);
        
        $pengaduan->update([
            'status' => 'Selesai',
            'tanggapan' => $request->tanggapan,
            'ditangani_oleh' => auth()->id(),
            'tanggal_ditangani' => $pengaduan->tanggal_ditangani ?? now(),
            'tanggal_selesai' => now(),
        ]);
        
        // Send notification to pengadu
        $this->sendPengaduanStatusNotification($pengaduan, 'Selesai');
        
        return redirect()->back()
            ->with('success', 'Pengaduan berhasil diselesaikan.');
    }
    
    /**
     * Reject the pengaduan (change status to Ditolak)
     */
    public function reject(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan' => 'required|string',
        ]);
        
        $pengaduan->update([
            'status' => 'Ditolak',
            'tanggapan' => $request->tanggapan,
            'ditangani_oleh' => auth()->id(),
            'tanggal_ditangani' => $pengaduan->tanggal_ditangani ?? now(),
            'tanggal_selesai' => now(),
        ]);
        
        // Send notification to pengadu
        $this->sendPengaduanStatusNotification($pengaduan, 'Ditolak');
        
        return redirect()->back()
            ->with('success', 'Pengaduan berhasil ditolak.');
    }
    
    /**
     * Download attachment file
     */
    public function download(Pengaduan $pengaduan)
    {
        if (!$pengaduan->lampiran || !Storage::disk('public')->exists($pengaduan->lampiran)) {
            return redirect()->back()
                ->with('error', 'File lampiran tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($pengaduan->lampiran);
    }
    
    /**
     * Download attachment file (alias for download method)
     */
    public function downloadAttachment(Pengaduan $pengaduan)
    {
        return $this->download($pengaduan);
    }
    
    /**
     * Generate unique nomor pengaduan
     */
    private function generateNomorPengaduan()
    {
        $year = date('Y');
        $month = date('m');
        $romanMonth = $this->toRoman((int)$month);
        
        // Get the last pengaduan number for this month
        $lastPengaduan = Pengaduan::where('nomor_pengaduan', 'like', "ADU/%/{$romanMonth}/{$year}")
            ->orderBy('nomor_pengaduan', 'desc')
            ->first();
        
        if ($lastPengaduan) {
            // Extract the sequence number and increment
            $parts = explode('/', $lastPengaduan->nomor_pengaduan);
            $sequence = (int)$parts[1] + 1;
        } else {
            $sequence = 1;
        }
        
        return sprintf('ADU/%03d/%s/%s', $sequence, $romanMonth, $year);
    }
    
    /**
     * Convert number to Roman numeral
     */
    private function toRoman($number)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        
        return $map[$number] ?? 'I';
    }

    /**
     * Export pengaduan to PDF
     */
    public function exportPdf(Pengaduan $pengaduan)
    {
        // Load pengaduan with handler relationship
        $pengaduan->load('handler');
        
        // Generate PDF
        $pdf = Pdf::loadView('pdf.pengaduan', compact('pengaduan'));
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'pengaduan-' . $pengaduan->id . '-' . now()->format('Y-m-d') . '.pdf';
        
        // Return PDF for download
        return $pdf->download($filename);
    }
    
    /**
      * Send notification to pengadu about status change
      */
     private function sendPengaduanStatusNotification($pengaduan, $status)
     {
         // Find user by email if exists
         $user = User::where('email', $pengaduan->email_pengadu)->first();
         
         if ($user) {
             $statusMessages = [
                 'Selesai' => 'telah diselesaikan',
                 'Ditolak' => 'ditolak',
                 'Diproses' => 'sedang diproses'
             ];
             
             NotificationHelper::sendToUser(
                 $user->id,
                 auth()->id(),
                 'pengaduan_status',
                 $status === 'Selesai' ? 'high' : 'medium',
                 'Update Status Pengaduan',
                 "Pengaduan Anda '{$pengaduan->judul_pengaduan}' {$statusMessages[$status]}.",
                 [
                     'pengaduan_id' => $pengaduan->id,
                     'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                     'status' => $status,
                     'tanggapan' => $pengaduan->tanggapan
                 ],
                 route('warga.pengaduan.show', $pengaduan->id)
             );
         }
     }
}