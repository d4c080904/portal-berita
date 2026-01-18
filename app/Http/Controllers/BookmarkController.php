<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Tampilkan daftar artikel yang disimpan user
     */
    public function index()
    {
        $articles = Auth::user()->bookmarks()->latest()->paginate(9);

        return view('bookmarks.index', compact('articles'));
    }

    /**
     * Toggle bookmark (Simpan / Hapus)
     */
    public function toggle(Article $article)
    {
        $user = Auth::user();

        if ($user->bookmarks()->where('article_id', $article->id)->exists()) {
            $user->bookmarks()->detach($article->id);
            $message = 'Artikel dihapus dari simpanan.';
        } else {
            $user->bookmarks()->attach($article->id);
            $message = 'Artikel berhasil disimpan!';
        }

        return back()->with('success', $message);
    }
}
