<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class PublicKontakController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'kategori' => 'nullable|string|max:100',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|max:2000',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'nomor_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'kategori.max' => 'Kategori maksimal 100 karakter.',
            'subjek.required' => 'Subjek wajib diisi.',
            'subjek.max' => 'Subjek maksimal 255 karakter.',
            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil semua admin untuk notifikasi
            $adminUsers = User::whereHas('role', function($query) {
                $query->where('name', 'admin');
            })->get();

            // Buat notifikasi untuk setiap admin
            foreach ($adminUsers as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pesan Baru dari Kontak',
                    'message' => "Pesan baru dari {$request->nama_lengkap} dengan subjek: {$request->subjek}",
                    'type' => 'kontak',
                    'data' => json_encode([
                        'nama_lengkap' => $request->nama_lengkap,
                        'email' => $request->email,
                        'nomor_hp' => $request->nomor_hp,
                        'kategori' => $request->kategori,
                        'subjek' => $request->subjek,
                        'pesan' => $request->pesan,
                        'tanggal' => now()->format('d/m/Y H:i'),
                    ]),
                ]);
            }

            return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera merespons.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.')
                ->withInput();
        }
    }
}