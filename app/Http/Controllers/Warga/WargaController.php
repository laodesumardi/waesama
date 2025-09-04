<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Pengaduan;
use App\Models\Berita;
use App\Models\Citizen;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class WargaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Cari data citizen berdasarkan NIK atau email user
        $citizen = null;
        if ($user->nik) {
            $citizen = Citizen::where('nik', $user->nik)->first();
        }
        if (!$citizen && $user->email) {
            $citizen = Citizen::where('email', $user->email)->first();
        }
        
        $stats = [
            'my_surat' => Surat::where('nik_pemohon', $user->nik ?? '')->count(),
            'my_antrian' => Antrian::where('nik_pengunjung', $user->nik ?? '')->count(),
            'my_pengaduan' => Pengaduan::where('email_pengadu', $user->email)->count(),
            'my_service_requests' => ServiceRequest::where('user_id', $user->id)->count(),
        ];

        $recentNews = Berita::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        // Ambil service requests terbaru
        $recentServiceRequests = ServiceRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('warga.dashboard', compact('stats', 'recentNews', 'citizen', 'recentServiceRequests'));
    }

    public function berita(Request $request)
    {
        $query = Berita::where('status', 'Published');

        // Filter berdasarkan kategori jika ada
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Search berdasarkan judul atau konten
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        // Ambil berita utama (terbaru) - hanya jika tidak ada filter
        $featuredNews = null;
        if (!$request->filled('search') && !$request->filled('kategori')) {
            $featuredNews = Berita::where('status', 'Published')
                ->orderBy('published_at', 'desc')
                ->first();
        }

        // Ambil berita lainnya dengan pagination
        $berita = $query->orderBy('published_at', 'desc')
            ->when($featuredNews, function($q) use ($featuredNews) {
                return $q->where('id', '!=', $featuredNews->id);
            })
            ->paginate(9);

        // Handle AJAX request
        if ($request->ajax()) {
            $html = view('warga.partials.berita-grid', compact('berita'))->render();
            $pagination = $berita->hasPages() ? $berita->links()->render() : '';
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'total' => $berita->total()
            ]);
        }

        return view('warga.berita', compact('berita', 'featuredNews'));
    }

    public function profil()
    {
        $user = auth()->user();
        
        // Get citizen data based on NIK or email
        $citizen = null;
        if ($user->nik) {
            $citizen = Citizen::where('nik', $user->nik)->first();
        }
        if (!$citizen && $user->email) {
            $citizen = Citizen::where('email', $user->email)->first();
        }
        
        return view('warga.profil', compact('user', 'citizen'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|string|size:16|unique:users,nik,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'religion' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'address' => 'nullable|string|max:500',
        ]);
        
        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        
        // Find or create citizen data
        $citizen = Citizen::where('nik', $request->nik)
                         ->orWhere('email', $request->email)
                         ->first();
        
        if (!$citizen) {
            $citizen = new Citizen();
        }
        
        // Update citizen data
        $citizen->fill([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'marital_status' => $request->marital_status,
            'occupation' => $request->occupation,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'address' => $request->address,
            'is_active' => true,
        ]);
        
        $citizen->save();

        return redirect()->route('warga.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('warga.profil')->with('success', 'Password berhasil diubah.');
    }
}
