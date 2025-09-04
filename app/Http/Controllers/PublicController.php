<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the news page
     */
    public function berita(Request $request)
    {
        $query = Berita::where('status', 'Published');

        // Search berdasarkan judul atau konten
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('konten', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        // Ambil berita dengan pagination
        $berita = $query->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $featuredNews = Berita::where('status', 'Published')
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Handle AJAX request
        if ($request->ajax()) {
            $html = view('public.partials.berita-grid', compact('berita'))->render();
            $pagination = $berita->appends($request->all())->links()->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination
            ]);
        }
            
        return view('public.berita', compact('berita', 'featuredNews'));
    }
    
    /**
     * Display single news article
     */
    public function beritaDetail($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();
            
        // Increment views
        $berita->increment('views');
        
        $relatedNews = Berita::where('status', 'Published')
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();
            
        $latestNews = Berita::where('status', 'Published')
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
            
        return view('public.berita-detail-new', compact('berita', 'relatedNews', 'latestNews'));
    }
    
    /**
     * Display office profile page
     */
    public function profil()
    {
        return view('public.profil');
    }
    
    /**
     * Display contact page
     */
    public function kontak()
    {
        return view('public.kontak');
    }
    
    /**
     * Display services page
     */
    public function layanan()
    {
        return view('public.layanan');
    }
}
