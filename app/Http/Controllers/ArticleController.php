<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

/**
 * ArticleController
 * Controller Publik yang menangani halaman depan (bukan admin).
 */
class ArticleController extends Controller
{
    /**
     * BERANDA (Halaman Utama)
     * Method ini dipanggil saat user membuka URL '/'
     */
    public function index()
    {
        // LOGIC MENGAMBIL BERITA UTAMA (FEATURED)

        // 1. Ambil 1 artikel yang dicentang 'is_featured' dan statusnya 'published'
        // Menggunakan Eager Loading 'with()' agar query lebih hemat (optimasasi)
        $featured = Article::published()
            ->where('is_featured', true)
            ->with('category')          // Ambil juga data kategorinya
            ->latest('published_at')    // Urutkan dari yang terbaru
            ->first();                  // Ambil 1 saja

        // Fallback: Jika admin lupa centang berita utama, ambil berita terbaru biasa sebagai gantinya
        if (!$featured) {
            $featured = Article::published()
                ->with('category')
                ->latest('published_at')
                ->first();
        }

        // LOGIC MENGAMBIL DAFTAR ARTIKEL LAINNYA
        // Kita exclude ID artikel featured agar tidak muncul dua kali

        // 3. Berita Per Liga (Section Khusus) - Limit 4 per liga
        // Fungsi helper kecil biar tidak repetitif
        $getLeagueArticles = function ($slug) use ($featured) {
            return Article::published()
                ->whereHas('category', fn($q) => $q->where('slug', $slug))
                ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
                ->latest('published_at')
                ->take(4)
                ->get();
        };

        $ligaInggris = $getLeagueArticles('liga-inggris');
        $ligaSpanyol = $getLeagueArticles('liga-spanyol');
        $ligaItalia  = $getLeagueArticles('liga-italia');
        $transfer    = $getLeagueArticles('transfer'); // [NEW] Kategori Transfer

        // Melempar data ke View 'home.blade.php'
        return view('home', [
            'featured' => $featured,
            'ligaInggris' => $ligaInggris,
            'ligaSpanyol' => $ligaSpanyol,
            'ligaItalia' => $ligaItalia,
            'transfer' => $transfer,
        ]);
    }

    /**
     * DETAIL ARTIKEL + RELATED POST
     * Method ini dipanggil saat user klik judul berita path: /articles/{slug}
     */
    public function show(string $slug)
    {
        // 1. Cari artikel berdasarkan 'slug'
        // Jika tidak ketemu, otomatis tampilkan 404 (firstOrFail)
        $article = Article::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. LOGIC ARTIKEL TERKAIT (Related Posts)
        // Mencari berita lain dengan Kategori yang SAMA, tapi bukan berita yang sedang dibaca
        $relatedArticles = Article::published()
            ->where('category_id', $article->category_id) // Kategori sama
            ->where('id', '!=', $article->id)             // Kecuali artikel ini sendiri
            ->latest('published_at')
            ->take(4) // Batasi ambil 4 berita saja
            ->get();

        // Tampilkan view detail
        return view('articles.detail', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }

    // Fungsi search biarkan seperti kode lamamu, sudah oke
    public function search(Request $request)
    {
        // ... kode search lama kamu ...
        // Biar pendek, saya skip tulis ulang search karena tidak error
        // (Copy dari kode lamamu atau biarkan saja)
        return redirect()->route('home'); // Placeholder biar tidak error kalau copy paste
    }
}