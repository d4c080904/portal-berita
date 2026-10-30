<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function createArticle(array $data, Request $request): Article
    {
        // Logika Dasar
        $data['slug'] = Str::slug($data['title']);
        $data['author'] = auth('admin')->user()->name ?? 'Administrator';
        $data['is_featured'] = $request->boolean('is_featured');

        // Logika Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        // Logika Tanggal Publish
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        // Simpan Artikel
        $article = Article::create($data);

        // Simpan Tags
        $this->syncTags($article, $request->tags);

        return $article;
    }

    public function updateArticle(Article $article, array $data, Request $request): Article
    {
        // Logika Dasar
        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        // Logika Ganti Gambar
        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        // Logika Update Tanggal Publish
        if ($article->status !== 'published' && $data['status'] === 'published') {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        // Update Artikel
        $article->update($data);

        // Simpan Tags
        $this->syncTags($article, $request->tags);

        return $article;
    }

    public function deleteArticle(Article $article): void
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
    }

    // Fungsi Private biar logika Tag nggak ditulis 2x
    private function syncTags(Article $article, ?string $tagsInput): void
    {
        $tagsArray = $tagsInput ? array_map('trim', explode(',', $tagsInput)) : [];
        $tagIds = [];

        foreach ($tagsArray as $tagName) {
            if ($tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => ucwords($tagName)]
                );
                $tagIds[] = $tag->id;
            }
        }

        $article->tags()->sync($tagIds);
    }
}