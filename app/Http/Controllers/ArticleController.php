<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * BERANDA (Halaman Utama)
     */
    public function index()
    {
        // 1. Ambil Berita Utama (Featured)
        $featured = Article::published()
            ->where('is_featured', true)
            ->with('category')
            ->latest('published_at')
            ->first();

        // Fallback jika tidak ada berita featured
        if (!$featured) {
            $featured = Article::published()
                ->with('category')
                ->latest('published_at')
                ->first();
        }

        // 2. Ambil Berita Per Liga (Kita rapihin tanpa closure)
        // Kita buat base query dulu biar gak nulis ulang "Article::published()"
        $baseQuery = Article::published()
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->latest('published_at');

        // Clone query untuk tiap liga (Efficient & Clean)
        $ligaInggris = (clone $baseQuery)->whereHas('category', fn($q) => $q->where('slug', 'liga-inggris'))->take(4)->get();
        $ligaSpanyol = (clone $baseQuery)->whereHas('category', fn($q) => $q->where('slug', 'liga-spanyol'))->take(4)->get();
        $ligaItalia  = (clone $baseQuery)->whereHas('category', fn($q) => $q->where('slug', 'liga-italia'))->take(4)->get();
        $transfer    = (clone $baseQuery)->whereHas('category', fn($q) => $q->where('slug', 'transfer'))->take(4)->get();

        return view('home', compact(
            'featured', 
            'ligaInggris', 
            'ligaSpanyol', 
            'ligaItalia', 
            'transfer'
        ));
    }

    /**
     * DETAIL ARTIKEL
     */
    public function show(string $slug)
    {
        $article = Article::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedArticles = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('articles.detail', compact('article', 'relatedArticles'));
    }

    /**
     * FITUR PENCARIAN (INI YANG BARU DIBENERIN)
     */
    public function search(Request $request)
    {
        // 1. Ambil keyword dari input form (pastikan name di form HTML-nya adalah 'q' atau 'query')
        $keyword = $request->input('q'); 

        // 2. Jika user tidak mengetik apa-apa, kembalikan ke home
        if (!$keyword) {
            return redirect()->route('home');
        }

        // 3. Cari artikel yang judul ATAU isinya mengandung keyword
        $articles = Article::published()
            ->with('category')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                      ->orWhere('content', 'like', '%' . $keyword . '%');
            })
            ->latest('published_at')
            ->paginate(10); // Pakai pagination biar gak berat kalau hasilnya banyak

        // 4. Lempar ke view hasil pencarian
        return view('articles.search', compact('articles', 'keyword'));
    }
}