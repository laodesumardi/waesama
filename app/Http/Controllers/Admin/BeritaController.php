<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Draft,Published,Archived',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);
        $data['author_id'] = Auth::id();
        $data['is_featured'] = $request->has('is_featured');
        
        if ($request->status === 'Published' && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita = Berita::create($data);
        
        // Send notification if berita is published
        if ($berita->status === 'Published') {
            NotificationHelper::notifyAll(
                'Berita Baru Dipublikasikan',
                "Berita baru '{$berita->judul}' telah dipublikasikan. Baca selengkapnya untuk mendapatkan informasi terbaru.",
                'medium',
                route('public.berita.detail', $berita->slug),
                auth()->id()
            );
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Draft,Published,Archived',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);
        $data['is_featured'] = $request->has('is_featured');
        
        // Capture old status for notification
        $oldStatus = $berita->status;
        
        // Set published_at when status changes to Published
        if ($request->status === 'Published' && $berita->status !== 'Published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);
        
        // Send notification if berita status changes to Published
        if ($oldStatus !== 'Published' && $data['status'] === 'Published') {
            NotificationHelper::notifyAll(
                'Berita Baru Dipublikasikan',
                "Berita '{$berita->judul}' telah dipublikasikan. Baca selengkapnya untuk mendapatkan informasi terbaru.",
                'medium',
                route('public.berita.detail', $berita->slug),
                auth()->id()
            );
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        // Delete image if exists
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        
        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
