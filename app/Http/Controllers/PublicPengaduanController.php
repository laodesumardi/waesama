<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicPengaduanController extends Controller
{
    /**
     * Store a newly created pengaduan from public form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_pengaduan' => 'required|string|in:keluhan,saran,laporan,informasi',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_hp' => 'required|string|max:20',
            'subjek' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        // Generate nomor pengaduan
        $lastPengaduan = Pengaduan::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastPengaduan) {
            $lastNumber = (int) substr($lastPengaduan->nomor_pengaduan, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $nomorPengaduan = 'PGD/' . date('Y') . '/' . date('m') . '/' . $newNumber;

        // Handle file upload
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($validated['subjek']) . '.' . $file->getClientOriginalExtension();
            $lampiranPath = $file->storeAs('pengaduan', $filename, 'public');
        }

        // Map jenis pengaduan to kategori
        $kategoriMap = [
            'keluhan' => 'Pelayanan',
            'saran' => 'Pelayanan',
            'laporan' => 'Infrastruktur',
            'informasi' => 'Pelayanan'
        ];

        // Create pengaduan
        $pengaduan = Pengaduan::create([
            'nomor_pengaduan' => $nomorPengaduan,
            'nama_pengadu' => $validated['nama_lengkap'],
            'email_pengadu' => $validated['email'],
            'phone_pengadu' => $validated['nomor_hp'],
            'alamat_pengadu' => null, // Not collected in public form
            'judul_pengaduan' => $validated['subjek'],
            'isi_pengaduan' => $validated['isi_pengaduan'],
            'kategori' => $kategoriMap[$validated['jenis_pengaduan']],
            'prioritas' => 'Sedang', // Default priority for public submissions
            'status' => 'Diterima',
            'lampiran' => $lampiranPath,
        ]);

        // Create notification for all admin users
        $adminUsers = User::whereHas('role', function($query) {
            $query->where('name', 'Admin');
        })->get();

        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'pengaduan_publik',
                'title' => 'Pengaduan Baru dari Publik',
                'message' => "Pengaduan baru dari {$validated['nama_lengkap']}: {$validated['subjek']}",
                'data' => json_encode([
                    'pengaduan_id' => $pengaduan->id,
                    'nama_pengadu' => $validated['nama_lengkap'],
                    'judul_pengaduan' => $validated['subjek'],
                    'kategori' => $kategoriMap[$validated['jenis_pengaduan']],
                    'jenis' => $validated['jenis_pengaduan'],
                    'url' => route('admin.pengaduan.show', $pengaduan)
                ])
            ]);
        }

        return redirect()->back()
            ->with('success', 'Pengaduan Anda berhasil dikirim. Nomor pengaduan: ' . $nomorPengaduan . '. Kami akan segera menindaklanjuti pengaduan Anda.');
    }
}