<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Pengaduan;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'my_surat' => Surat::where('diproses_oleh', $user->id)->count(),
            'pending_surat' => Surat::where('status', 'Pending')->count(),
            'my_antrian' => Antrian::where('dilayani_oleh', $user->id)->count(),
            'active_antrian' => Antrian::whereIn('status', ['Menunggu', 'Dipanggil'])->count(),
            'my_pengaduan' => Pengaduan::where('ditangani_oleh', $user->id)->count(),
            'pending_pengaduan' => Pengaduan::where('status', 'Diterima')->count(),
        ];

        // Get recent service requests
        $recentServiceRequests = ServiceRequest::with('citizen')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pegawai.dashboard', compact('stats', 'recentServiceRequests'));
    }
}
