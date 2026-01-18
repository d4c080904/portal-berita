<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Article
 * Representasi tabel 'articles' di database.
 * Digunakan untuk berinteraksi dengan data artikel (CRUD).
 */
class Article extends Model
{
    use HasFactory;

    // Mass Assignment Protection
    // Properti apa saja yang BOLEH diisi secara massal (create/update)
    protected $fillable = [
        'title',        // Judul Artikel
        'slug',         // URL friendly title
        'content',      // Isi Artikel
        'image',        // Path gambar cover
        'category_id',  // FK ke tabel categories
        'author',       // Nama penulis
        'status',       // draft / published
        'published_at', // Waktu publish
        'is_featured'   // Apakah artikel unggulan?
    ];

    // Casting Tipe Data
    // Mengubah data mentah database menjadi tipe data PHP yang sesuai
    protected $casts = [
        'published_at' => 'datetime', // String tanggal jadi objek Carbon
        'is_featured' => 'boolean',   // 0/1 jadi true/false
    ];

    /**
     * Local Scope: Published
     * Cara pakai: Article::published()->get()
     * Fungsinya menyaring hanya artikel yang statusnya 'published'
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * RELASI (Relationships)
     * Menghubungkan tabel articles dengan tabel lain
     */

    // Relasi ke Kategori (Many to One)
    // Satu artikel memiliki Satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Tag (Many to Many)
    // Satu artikel bisa punya Banyak tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relasi ke Komentar (One to Many)
    // Satu artikel bisa punya Banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Relasi ke User (Bookmark)
    // Siapa saja user yang memfavoritkan artikel ini?
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }
}