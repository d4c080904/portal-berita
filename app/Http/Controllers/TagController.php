<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug)
    {
        // 1. Cari tag berdasarkan slug (misal: "transfer")
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // 2. Ambil semua artikel yang terhubung dengan tag ini
        $articles = $tag->articles()
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        // 3. Tampilkan ke halaman view
        return view('tags.show', [
            'tag' => $tag,
            'articles' => $articles
        ]);
    }
}