<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag; // Jangan lupa import Model Tag
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel
     */
    public function index()
    {
        $articles = Article::with(['category', 'tags']) // Eager load tags juga biar optimal
            ->latest('created_at')
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Menampilkan form tambah artikel
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Menyimpan artikel baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'content'     => ['required', 'string'],
            'status'      => ['required', 'in:draft,published'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'tags'        => ['nullable', 'string'], // Validasi input tags (string dipisah koma)
        ]);

        // 2. Generate Data Dasar
        $data['slug'] = Str::slug($data['title']);
        $data['author'] = auth('admin')->user()->name ?? 'Administrator';
        
        // Logic Hot News (Minggu 9)
        $data['is_featured'] = $request->boolean('is_featured');

        // Logic Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        // Logic Tanggal Publish
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        // 3. Simpan Artikel Utama
        $article = Article::create($data);

        // 4. Logic Penyimpanan Tags (Minggu 9)
        // Memecah string "bola, transfer, pemain" menjadi array dan menyimpannya
        if ($request->filled('tags')) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagsArray as $tagName) {
                if ($tagName) {
                    // Cari tag kalau ada, kalau belum ada buat baru
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => ucwords($tagName)]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            // Hubungkan artikel dengan tag-tag tersebut
            $article->tags()->sync($tagIds);
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit artikel
     */
    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Memperbarui artikel yang sudah ada
     */
    public function update(Request $request, Article $article)
    {
        // 1. Validasi Input
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'content'     => ['required', 'string'],
            'status'      => ['required', 'in:draft,published'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'tags'        => ['nullable', 'string'],
        ]);

        // 2. Update Data Dasar
        $data['slug'] = Str::slug($data['title']);
        
        // Logic Hot News
        $data['is_featured'] = $request->boolean('is_featured');

        // Logic Ganti Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        // Logic Update Tanggal Publish
        if ($article->status !== 'published' && $data['status'] === 'published') {
            $data['published_at'] = now();
        } elseif ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        // 3. Update Artikel Utama
        $article->update($data);

        // 4. Logic Update Tags
        // Jika input kosong, array kosong (artinya semua tag dihapus)
        $tagsArray = $request->filled('tags') 
            ? array_map('trim', explode(',', $request->tags)) 
            : [];
            
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
        // Sync: Hapus relasi lama, masukkan relasi baru yang sesuai input
        $article->tags()->sync($tagIds);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel
     */
    public function destroy(Article $article)
    {
        // Hapus file gambar dari storage
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        // Hapus record artikel (relasi tags & comments otomatis terhapus karena cascade di migration)
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}