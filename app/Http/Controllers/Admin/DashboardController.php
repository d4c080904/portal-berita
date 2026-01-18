<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Import Model yang mau dihitung
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment; // Pastikan model Comment sudah ada (kan sudah buat di minggu 9)

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung-hitungan data
        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $totalCategories = Category::count();
        $totalComments = Comment::count();

        // Kirim data ke view
        return view('admin.dashboard', compact(
            'totalArticles',
            'publishedArticles',
            'draftArticles',
            'totalCategories',
            'totalComments'
        ));
    }
}