<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $articles = Article::published()
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('content', 'like', "%{$q}%");
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('search', [
            'query'    => $q,
            'articles' => $articles,
        ]);
    }
}
