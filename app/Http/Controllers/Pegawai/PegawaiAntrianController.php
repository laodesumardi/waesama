<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PegawaiAntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Only show antrian assigned to this pegawai or unassigned ones
        $query = Antrian::with('server')
            ->where(function($q) use ($user) {
                $q->where('dilayani_oleh', $user->id)
                  ->orWhereNull('dilayani_oleh')
                  ->orWhere('dilayani_oleh', 0);
            });

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

        return view('pegawai.antrian.index', compact('antrians', 'statusOptions', 'jenisLayananOptions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Antrian $antrian)
    {
        // Check if pegawai can view this antrian
        $user = Auth::user();
        if ($antrian->dilayani_oleh && $antrian->dilayani_oleh != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat antrian ini.');
        }
        
        $antrian->load('server');
        
        return view('pegawai.antrian.show', compact('antrian'));
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
            
            return redirect()->back()->with('success', 'Antrian berhasil dipanggil.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat dipanggil.');
    }

    /**
     * Start serving the antrian (change status to Dilayani)
     */
    public function serve(Antrian $antrian)
    {
        $user = Auth::user();
        
        // Check if this pegawai can serve this antrian
        if ($antrian->dilayani_oleh && $antrian->dilayani_oleh != $user->id) {
            return redirect()->back()->with('error', 'Antrian ini sedang dilayani oleh pegawai lain.');
        }
        
        if (in_array($antrian->status, ['Menunggu', 'Dipanggil'])) {
            $antrian->update([
                'status' => 'Dilayani',
                'dilayani_oleh' => $user->id,
                'waktu_mulai_layanan' => now()
            ]);
            
            return redirect()->back()->with('success', 'Antrian mulai dilayani.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat dilayani.');
    }

    /**
     * Complete the antrian (change status to Selesai)
     */
    public function complete(Antrian $antrian)
    {
        $user = Auth::user();
        
        // Check if this pegawai is serving this antrian
        if ($antrian->dilayani_oleh != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menyelesaikan antrian ini.');
        }
        
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
        $user = Auth::user();
        
        // Check if this pegawai can cancel this antrian
        if ($antrian->dilayani_oleh && $antrian->dilayani_oleh != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat membatalkan antrian ini.');
        }
        
        if (in_array($antrian->status, ['Menunggu', 'Dipanggil', 'Dilayani'])) {
            $antrian->update([
                'status' => 'Batal',
                'catatan' => 'Dibatalkan oleh pegawai: ' . $user->name
            ]);
            
            // Send notification
            $this->sendAntrianStatusNotification($antrian, 'Batal');
            
            return redirect()->back()->with('success', 'Antrian berhasil dibatalkan.');
        }
        
        return redirect()->back()->with('error', 'Antrian tidak dapat dibatalkan.');
    }

    /**
     * Get my queue statistics
     */
    public function myStats()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        $stats = [
            'total_my_antrian' => Antrian::where('dilayani_oleh', $user->id)->count(),
            'today_my_antrian' => Antrian::where('dilayani_oleh', $user->id)
                ->whereDate('tanggal_kunjungan', $today)->count(),
            'completed_today' => Antrian::where('dilayani_oleh', $user->id)
                ->whereDate('tanggal_kunjungan', $today)
                ->where('status', 'Selesai')->count(),
            'in_progress' => Antrian::where('dilayani_oleh', $user->id)
                ->where('status', 'Dilayani')->count(),
        ];
        
        return response()->json($stats);
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
                 'Selesai' => 'telah diselesaikan',
                 'Batal' => 'dibatalkan',
                 'Diproses' => 'sedang diproses'
             ];
             
             NotificationHelper::sendToUser(
                 $user->id,
                 auth()->id(),
                 'antrian_status',
                 $status === 'Selesai' ? 'high' : 'medium',
                 'Update Status Antrian',
                 "Antrian Anda nomor {$antrian->nomor_antrian} untuk layanan '{$antrian->jenis_layanan}' {$statusMessages[$status]} oleh pegawai.",
                 [
                     'antrian_id' => $antrian->id,
                     'nomor_antrian' => $antrian->nomor_antrian,
                     'jenis_layanan' => $antrian->jenis_layanan,
                     'status' => $status,
                     'waktu_selesai' => $antrian->waktu_selesai
                 ],
                 route('warga.antrian.show', $antrian->id)
             );
         }
         
         // Notify admin about pegawai action
         NotificationHelper::notifyAdmins(
             auth()->id(),
             'antrian_update',
             'medium',
             'Update Antrian oleh Pegawai',
             "Antrian nomor {$antrian->nomor_antrian} untuk layanan '{$antrian->jenis_layanan}' telah diupdate oleh pegawai menjadi status {$status}.",
             [
                 'antrian_id' => $antrian->id,
                 'nomor_antrian' => $antrian->nomor_antrian,
                 'jenis_layanan' => $antrian->jenis_layanan,
                 'status' => $status,
                 'pegawai' => auth()->user()->name
             ],
             route('admin.antrian.show', $antrian->id)
         );
     }
}