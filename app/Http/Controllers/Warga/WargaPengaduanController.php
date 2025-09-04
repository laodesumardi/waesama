<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WargaPengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get pengaduan list for current user
        $pengaduanList = Pengaduan::where('email_pengadu', $user->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get statistics
        $stats = [
            'total_pengaduan' => Pengaduan::where('email_pengadu', $user->email)->count(),
            'pengaduan_baru' => Pengaduan::where('email_pengadu', $user->email)
                ->where('status', 'Baru')->count(),
            'pengaduan_proses' => Pengaduan::where('email_pengadu', $user->email)
                ->where('status', 'Sedang Diproses')->count(),
            'pengaduan_selesai' => Pengaduan::where('email_pengadu', $user->email)
                ->where('status', 'Selesai')->count(),
        ];
        
        return view('warga.pengaduan.index', compact('pengaduanList', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'kategori' => 'required|in:Infrastruktur,Pelayanan Publik,Keamanan,Kebersihan,Administrasi,Lainnya',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Mendesak',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $validated = $validator->validated();
        
        // Handle file upload
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('pengaduan', 'public');
        }
        
        // Generate nomor pengaduan
        $nomorPengaduan = $this->generateNomorPengaduan();
        
        // Create pengaduan
        $pengaduan = Pengaduan::create([
            'nomor_pengaduan' => $nomorPengaduan,
            'nama_pengadu' => $user->name,
            'email_pengadu' => $user->email,
            'phone_pengadu' => $user->phone ?? '',
            'alamat_pengadu' => $user->alamat ?? '',
            'judul_pengaduan' => $validated['judul_pengaduan'],
            'isi_pengaduan' => $validated['isi_pengaduan'],
            'kategori' => $validated['kategori'],
            'prioritas' => $validated['prioritas'],
            'status' => 'Baru',
            'lampiran' => $lampiranPath,
        ]);
        
        return redirect()->route('warga.pengaduan.index')
            ->with('success', 'Pengaduan berhasil diajukan dengan nomor: ' . $nomorPengaduan);
    }

    /**
     * Generate nomor pengaduan
     */
    private function generateNomorPengaduan()
    {
        $date = Carbon::now()->format('Ymd');
        $count = Pengaduan::whereDate('created_at', today())->count() + 1;
        
        return 'P' . $date . sprintf('%03d', $count);
    }
}