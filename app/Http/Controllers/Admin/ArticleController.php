<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    // Inject Service ke dalam Controller
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = Article::with(['category', 'tags'])
            ->latest('created_at')
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(StoreArticleRequest $request)
    {
        // Request otomatis udah divalidasi di Form Request
        $this->articleService->createArticle($request->validated(), $request);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->articleService->updateArticle($article, $request->validated(), $request);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->articleService->deleteArticle($article);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}