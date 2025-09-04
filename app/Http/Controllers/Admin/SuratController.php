<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\NotificationHelper;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Surat::with('processor');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('nik_pemohon', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }
        
        // Filter by jenis surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $surat = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.surat.index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Domisili,SKTM,Usaha,Pengantar,Kematian,Kelahiran,Pindah',
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => 'required|string|size:16|regex:/^[0-9]+$/',
            'alamat_pemohon' => 'required|string',
            'phone_pemohon' => 'nullable|string|max:20',
            'keperluan' => 'required|string',
            'data_tambahan' => 'nullable|array',
            'status' => 'required|in:Pending,Diproses,Selesai,Ditolak',
            'catatan' => 'nullable|string',
        ]);
        
        // Generate nomor surat
        $validated['nomor_surat'] = $this->generateNomorSurat($validated['jenis_surat']);
        
        $surat = Surat::create($validated);
        
        // Send notification to admins about new surat
        NotificationHelper::notifyAdmins(
            auth()->id(),
            'surat_baru',
            'high',
            'Pengajuan Surat Baru',
            "Pengajuan surat {$validated['jenis_surat']} dari {$validated['nama_pemohon']} telah dibuat.",
            [
                'surat_id' => $surat->id,
                'jenis_surat' => $validated['jenis_surat'],
                'nama_pemohon' => $validated['nama_pemohon']
            ],
            route('admin.surat.show', $surat)
        );
        
        return redirect()->route('admin.surat.show', $surat)
                        ->with('success', 'Data surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        $surat->load('processor');
        return view('admin.surat.show', compact('surat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        $users = User::whereHas('role', function($query) {
            $query->whereIn('name', ['Admin', 'Pegawai']);
        })->get();
        
        return view('admin.surat.edit', compact('surat', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Domisili,SKTM,Usaha,Pengantar,Kematian,Kelahiran,Pindah',
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]+$/',
                Rule::unique('surat', 'nik_pemohon')->ignore($surat->id)
            ],
            'alamat_pemohon' => 'required|string',
            'phone_pemohon' => 'nullable|string|max:20',
            'keperluan' => 'required|string',
            'data_tambahan' => 'nullable|array',
            'status' => 'required|in:Pending,Diproses,Selesai,Ditolak',
            'catatan' => 'nullable|string',
            'diproses_oleh' => 'nullable|exists:users,id',
        ]);
        
        // Set tanggal selesai jika status berubah menjadi Selesai
        if ($validated['status'] === 'Selesai' && $surat->status !== 'Selesai') {
            $validated['tanggal_selesai'] = now();
        }
        
        $oldStatus = $surat->status;
        $surat->update($validated);
        
        // Send notification if status changed
        if ($oldStatus !== $validated['status']) {
            $this->sendStatusNotification($surat, $oldStatus, $validated['status']);
        }
        
        return redirect()->route('admin.surat.show', $surat)
                        ->with('success', 'Data surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        // Delete file if exists
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }
        
        $surat->delete();
        
        return redirect()->route('admin.surat.index')
                        ->with('success', 'Data surat berhasil dihapus.');
    }
    
    /**
     * Process surat (assign to user and change status)
     */
    public function process(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'diproses_oleh' => 'required|exists:users,id',
            'catatan' => 'nullable|string',
        ]);
        
        $surat->update([
            'status' => 'Diproses',
            'diproses_oleh' => $validated['diproses_oleh'],
            'catatan' => $validated['catatan'] ?? $surat->catatan,
        ]);
        
        return redirect()->route('admin.surat.show', $surat)
                        ->with('success', 'Surat berhasil diproses.');
    }
    
    /**
     * Complete surat processing
     */
    public function complete(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
            'catatan' => 'nullable|string',
        ]);
        
        $updateData = [
            'status' => 'Selesai',
            'tanggal_selesai' => now(),
            'catatan' => $validated['catatan'] ?? $surat->catatan,
        ];
        
        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }
            
            $file = $request->file('file_surat');
            $filename = 'surat_' . $surat->nomor_surat . '_' . time() . '.pdf';
            $path = $file->storeAs('surat', $filename, 'public');
            $updateData['file_surat'] = $path;
        }
        
        $oldStatus = $surat->status;
        $surat->update($updateData);
        
        // Send notification for completion
        $this->sendStatusNotification($surat, $oldStatus, 'Selesai');
        
        return redirect()->route('admin.surat.show', $surat)
                        ->with('success', 'Surat berhasil diselesaikan.');
    }
    
    /**
     * Download surat file
     */
    public function download(Surat $surat)
    {
        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($surat->file_surat, $surat->nomor_surat . '.pdf');
    }
    
    /**
     * Send notification when surat status changes
     */
    private function sendStatusNotification(Surat $surat, $oldStatus, $newStatus)
    {
        // Find the user who submitted the surat
        $warga = User::where('role_id', 3) // Warga role
                    ->where(function($query) use ($surat) {
                        $query->where('name', $surat->nama_pemohon)
                              ->orWhere('nik', $surat->nik_pemohon);
                    })
                    ->first();
        
        if ($warga) {
            $statusMessages = [
                'Pending' => 'menunggu verifikasi',
                'Diproses' => 'sedang diproses',
                'Selesai' => 'telah selesai diproses',
                'Ditolak' => 'ditolak'
            ];
            
            $message = "Surat {$surat->jenis_surat} dengan nomor {$surat->nomor_surat} {$statusMessages[$newStatus]}.";
            
            NotificationHelper::sendToUser(
                $warga->id,
                auth()->id(),
                'surat_status',
                $newStatus === 'Selesai' ? 'high' : 'medium',
                'Update Status Surat',
                $message,
                ['surat_id' => $surat->id, 'old_status' => $oldStatus, 'new_status' => $newStatus],
                route('warga.surat.show', $surat->id)
            );
        }
        
        // Notify admin if processed by pegawai
        if (auth()->user()->role_id === 2 && in_array($newStatus, ['Diproses', 'Selesai'])) { // Pegawai role
            NotificationHelper::notifyAdmins(
                auth()->id(),
                'surat_update',
                'medium',
                'Update Surat oleh Pegawai',
                "Surat {$surat->jenis_surat} dengan nomor {$surat->nomor_surat} telah diupdate oleh pegawai menjadi status {$newStatus}.",
                ['surat_id' => $surat->id, 'old_status' => $oldStatus, 'new_status' => $newStatus],
                route('admin.surat.show', $surat->id)
            );
        }
    }
    
    /**
     * Generate nomor surat
     */
    private function generateNomorSurat($jenisSurat)
    {
        $prefix = match($jenisSurat) {
            'Domisili' => 'DOM',
            'SKTM' => 'SKTM',
            'Usaha' => 'USH',
            'Pengantar' => 'PNG',
            'Kematian' => 'KMT',
            'Kelahiran' => 'KLH',
            'Pindah' => 'PND',
            default => 'SRT'
        };
        
        $year = date('Y');
        $month = date('m');
        
        // Get last number for this month and year
        $lastSurat = Surat::where('nomor_surat', 'like', "{$prefix}/{$month}/{$year}/%")
                          ->orderBy('nomor_surat', 'desc')
                          ->first();
        
        $number = 1;
        if ($lastSurat) {
            $parts = explode('/', $lastSurat->nomor_surat);
            $number = (int)end($parts) + 1;
        }
        
        return sprintf('%s/%s/%s/%04d', $prefix, $month, $year, $number);
    }

    /**
     * Export surat to PDF
     */
    public function exportPdf(Surat $surat)
    {
        // Load the surat with processor relationship
        $surat->load('processor');
        
        // Generate PDF
        $pdf = Pdf::loadView('pdf.surat', compact('surat'));
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'Surat_' . str_replace('/', '_', $surat->nomor_surat) . '.pdf';
        
        // Return PDF download
        return $pdf->download($filename);
    }
}