<?php

namespace App\Http\Controllers;

use App\Models\Category as CategoryModel;
use App\Models\Article;
use Illuminate\Support\Str;

/**
 * CategoryController
 * Controller untuk menangani halaman kategori (misal: /kategori/liga-inggris)
 */
class CategoryController extends Controller
{
    /**
     * Menampilkan daftar artikel berdasarkan kategori
     * URL: /kategori/{categorySlug}
     */
    public function show(string $categorySlug)
    {
        // 1. Cari Kategori di Database berdasarkan Slug
        // Menggunakan firstOrFail agar otomatis 404 jika tidak ditemukan
        $category = CategoryModel::where('slug', $categorySlug)->firstOrFail();

        // 2. Ambil artikel yang terkait dengan kategori ini
        // Menggunakan scope 'published' dari model Article
        $articles = $category->articles()
            ->published()
            ->latest('published_at')
            ->get()
            ->map(function (Article $a) {
                // Transformasi data agar view lebih bersih
                return [
                    'title' => $a->title,
                    'slug' => $a->slug,
                    'excerpt' => Str::limit(strip_tags($a->content), 150),
                    'date' => $a->published_at
                        ? $a->published_at->format('d F Y')
                        : null,
                    'image' => $a->image
                        ? asset('storage/' . $a->image)
                        : asset('images/default-thumbnail.jpg'), // Pastikan ada default image
                ];
            });

        // 3. Tampilkan View
        return view('categories.show', [
            'categoryName' => $category->name, // Ambil nama dari DB (misal: 'Liga Spanyol')
            'articles' => $articles,
        ]);
    }
}
