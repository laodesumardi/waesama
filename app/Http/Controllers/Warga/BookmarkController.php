<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Toggle bookmark for a news article.
     */
    public function toggle(Request $request, $beritaId)
    {
        $user = Auth::user();
        $berita = Berita::findOrFail($beritaId);
        
        $bookmark = Bookmark::where('user_id', $user->id)
                          ->where('berita_id', $berita->id)
                          ->first();
        
        if ($bookmark) {
            // Remove bookmark
            $bookmark->delete();
            $isBookmarked = false;
            $message = 'Bookmark berhasil dihapus';
        } else {
            // Add bookmark
            Bookmark::create([
                'user_id' => $user->id,
                'berita_id' => $berita->id,
            ]);
            $isBookmarked = true;
            $message = 'Berita berhasil di-bookmark';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'is_bookmarked' => $isBookmarked,
                'message' => $message
            ]);
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Display user's bookmarked news.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $bookmarks = $user->bookmarkedBerita()
                         ->where('status', 'published')
                         ->orderBy('bookmarks.created_at', 'desc')
                         ->paginate(12);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('warga.partials.berita-grid', [
                    'berita' => $bookmarks,
                    'showBookmarkButton' => true
                ])->render(),
                'pagination' => $bookmarks->links()->render(),
                'total' => $bookmarks->total()
            ]);
        }
        
        return view('warga.bookmarks', compact('bookmarks'));
    }
}
