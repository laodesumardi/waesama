<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Gallery;

class WelcomeController extends Controller
{
    public function index()
    {
        $latestNews = News::published()->latest()->take(3)->get();
        $latestGallery = Gallery::active()->latest()->take(6)->get();
        
        return view('welcome', compact('latestNews', 'latestGallery'));
    }

    public function news()
    {
        $news = News::published()->latest()->paginate(9);
        return view('news.index', compact('news'));
    }

    public function newsShow($id)
    {
        $news = News::published()->findOrFail($id);
        $relatedNews = News::published()->where('id', '!=', $id)->latest()->take(3)->get();
        
        return view('news.show', compact('news', 'relatedNews'));
    }

    public function gallery()
    {
        $galleries = Gallery::active()->latest()->paginate(12);
        return view('gallery.index', compact('galleries'));
    }
}
