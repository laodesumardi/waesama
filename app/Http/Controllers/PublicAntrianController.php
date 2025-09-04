<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicAntrianController extends Controller
{
    /**
     * Store a newly created antrian from public form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_layanan' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'nik' => 'required|string|size:16',
            'keperluan' => 'nullable|string|max:500',
        ]);

        // Generate nomor antrian
        $nomorAntrian = $this->generateNomorAntrian();
        
        // Set default values
        $antrianData = [
            'nomor_antrian' => $nomorAntrian,
            'nama_pengunjung' => $validated['nama_lengkap'],
            'nik_pengunjung' => $validated['nik'],
            'phone_pengunjung' => $validated['nomor_hp'],
            'jenis_layanan' => $validated['jenis_layanan'],
            'keperluan' => $validated['keperluan'] ?? null,
            'tanggal_kunjungan' => Carbon::today()->addDay(), // Default besok
            'jam_kunjungan' => '08:00:00', // Default jam 8 pagi
            'status' => 'Menunggu',
            'estimasi_waktu' => 30, // Default 30 menit
        ];

        $antrian = Antrian::create($antrianData);

        // Create notification for admin users
        $adminUsers = User::whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->get();
        
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Antrian Baru dari Website',
                'message' => "Antrian baru dengan nomor {$nomorAntrian} dari {$validated['nama_lengkap']} untuk layanan {$validated['jenis_layanan']}",
                'type' => 'antrian',
                'data' => json_encode([
                    'antrian_id' => $antrian->id,
                    'nomor_antrian' => $nomorAntrian,
                    'nama_pengunjung' => $validated['nama_lengkap'],
                    'jenis_layanan' => $validated['jenis_layanan']
                ])
            ]);
        }

        return redirect()->back()->with('success', "Nomor antrian Anda: {$nomorAntrian}. Silakan datang besok mulai jam 08:00 WIB.");
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
}