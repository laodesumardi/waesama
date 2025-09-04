<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper;

class PegawaiPengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Only show pengaduan assigned to this pegawai or unassigned ones
        $query = Pengaduan::with('handler')
            ->where(function($q) use ($user) {
                $q->where('ditangani_oleh', $user->id)
                  ->orWhereNull('ditangani_oleh')
                  ->orWhere('ditangani_oleh', 0);
            });

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
        
        // Sort by latest
        $pengaduan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get filter options
        $statusOptions = ['Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $kategoriOptions = ['Pelayanan', 'Infrastruktur', 'Keamanan', 'Kebersihan', 'Lainnya'];
        $prioritasOptions = ['Rendah', 'Sedang', 'Tinggi', 'Urgent'];
        
        return view('pegawai.pengaduan.index', compact(
            'pengaduan', 
            'statusOptions', 
            'kategoriOptions', 
            'prioritasOptions'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        // Check if pegawai can view this pengaduan
        $user = Auth::user();
        if ($pengaduan->ditangani_oleh && $pengaduan->ditangani_oleh != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat pengaduan ini.');
        }
        
        $pengaduan->load('handler');
        
        $statusOptions = ['Diterima', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        
        return view('pegawai.pengaduan.show', compact('pengaduan', 'statusOptions'));
    }

    /**
     * Process the pengaduan (change status to Diproses)
     */
    public function process(Pengaduan $pengaduan)
    {
        // Check if pengaduan can be processed
        if ($pengaduan->status !== 'Diterima') {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat diproses.');
        }
        
        $pengaduan->update([
            'status' => 'Diproses',
            'ditangani_oleh' => Auth::id(),
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
        $user = Auth::user();
        
        // Check if this pegawai is handling this pengaduan
        if ($pengaduan->ditangani_oleh != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menindaklanjuti pengaduan ini.');
        }
        
        $request->validate([
            'tanggapan' => 'required|string',
        ]);
        
        $pengaduan->update([
            'status' => 'Ditindaklanjuti',
            'tanggapan' => $request->tanggapan,
            'ditangani_oleh' => $user->id,
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
        $user = Auth::user();
        
        // Check if this pegawai is handling this pengaduan
        if ($pengaduan->ditangani_oleh != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menyelesaikan pengaduan ini.');
        }
        
        $request->validate([
            'tanggapan' => 'required|string',
        ]);
        
        $pengaduan->update([
            'status' => 'Selesai',
            'tanggapan' => $request->tanggapan,
            'ditangani_oleh' => $user->id,
            'tanggal_ditangani' => $pengaduan->tanggal_ditangani ?? now(),
            'tanggal_selesai' => now(),
        ]);
        
        // Send notification to pengadu and admin
        $this->sendPengaduanStatusNotification($pengaduan, 'Selesai');
        
        return redirect()->back()
            ->with('success', 'Pengaduan berhasil diselesaikan.');
    }

    /**
     * Reject the pengaduan (change status to Ditolak)
     */
    public function reject(Request $request, Pengaduan $pengaduan)
    {
        $user = Auth::user();
        
        // Check if this pegawai can reject this pengaduan
        if ($pengaduan->ditangani_oleh && $pengaduan->ditangani_oleh != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menolak pengaduan ini.');
        }
        
        $request->validate([
            'tanggapan' => 'required|string',
        ]);
        
        $pengaduan->update([
            'status' => 'Ditolak',
            'tanggapan' => $request->tanggapan,
            'ditangani_oleh' => $user->id,
            'tanggal_ditangani' => $pengaduan->tanggal_ditangani ?? now(),
            'tanggal_selesai' => now(),
        ]);
        
        // Send notification to pengadu and admin
        $this->sendPengaduanStatusNotification($pengaduan, 'Ditolak');
        
        return redirect()->back()
            ->with('success', 'Pengaduan berhasil ditolak.');
    }

    /**
     * Take responsibility for a pengaduan
     */
    public function take(Pengaduan $pengaduan)
    {
        // Check if pengaduan is available to be taken
        if ($pengaduan->ditangani_oleh && $pengaduan->ditangani_oleh != 0) {
            return redirect()->back()->with('error', 'Pengaduan ini sudah ditangani oleh pegawai lain.');
        }
        
        $pengaduan->update([
            'ditangani_oleh' => Auth::id(),
            'tanggal_ditangani' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Anda berhasil mengambil tanggung jawab pengaduan ini.');
    }

    /**
     * Get my complaint statistics
     */
    public function myStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total_my_pengaduan' => Pengaduan::where('ditangani_oleh', $user->id)->count(),
            'diproses' => Pengaduan::where('ditangani_oleh', $user->id)
                ->where('status', 'Diproses')->count(),
            'ditindaklanjuti' => Pengaduan::where('ditangani_oleh', $user->id)
                ->where('status', 'Ditindaklanjuti')->count(),
            'selesai' => Pengaduan::where('ditangani_oleh', $user->id)
                ->where('status', 'Selesai')->count(),
        ];
        
        return response()->json($stats);
    }

    /**
     * Download pengaduan attachment
     */
    public function download(Pengaduan $pengaduan)
    {
        // Check if file exists
        if (!$pengaduan->lampiran || !Storage::disk('public')->exists($pengaduan->lampiran)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($pengaduan->lampiran);
    }

    /**
      * Send notification when pengaduan status changes
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
                 "Pengaduan Anda '{$pengaduan->judul_pengaduan}' {$statusMessages[$status]} oleh pegawai.",
                 [
                     'pengaduan_id' => $pengaduan->id,
                     'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                     'status' => $status,
                     'tanggapan' => $pengaduan->tanggapan
                 ],
                 route('warga.pengaduan.show', $pengaduan->id)
             );
         }
         
         // Notify admin about pegawai action
         NotificationHelper::notifyAdmins(
             auth()->id(),
             'pengaduan_update',
             'medium',
             'Update Pengaduan oleh Pegawai',
             "Pengaduan '{$pengaduan->judul_pengaduan}' telah diupdate oleh pegawai menjadi status {$status}.",
             [
                 'pengaduan_id' => $pengaduan->id,
                 'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                 'status' => $status,
                 'pegawai' => auth()->user()->name
             ],
             route('admin.pengaduan.show', $pengaduan->id)
         );
     }
}