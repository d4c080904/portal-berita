<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

/**
 * CommentController
 * Menangani logika pengiriman komentar pada artikel.
 */
class CommentController extends Controller
{
    /**
     * Menyimpan komentar dari user (Guest/Member)
     * URL: POST /articles/{slug}/comment
     */
    public function store(Request $request, $slug)
    {
        // 1. Cari artikel berdasarkan slug
        $article = Article::where('slug', $slug)->firstOrFail();

        // 2. Tentukan Rule Validasi
        $rules = [
            'body'  => 'required|string|min:5|max:1000',
        ];

        // Jika Guest (belum login), wajib isi Nama & Email
        if (!auth()->check()) {
            $rules['name'] = 'required|string|min:3|max:50';
            $rules['email'] = 'required|email:dns|max:100';
        }

        $request->validate($rules, [
            'name.required'  => 'Nama wajib diisi.',
            'name.min'       => 'Nama terlalu pendek.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'body.required'  => 'Komentar tidak boleh kosong.',
            'body.min'       => 'Komentar terlalu pendek.',
        ]);

        // 3. Siapkan Data Komentar
        if (auth()->check()) {
            // Jika User Login: Pakai data akunnya
            $data = [
                'name'  => auth()->user()->name,
                'email' => auth()->user()->email,
                'body'  => $request->body,
            ];
        } else {
            // Jika Guest: Pakai data inputan form
            $data = [
                'name'  => $request->name,
                'email' => $request->email,
                'body'  => $request->body,
            ];
        }

        // 4. Simpan ke Database
        $article->comments()->create($data);

        // 5. Redirect kembali
        return back()->with('success', 'Komentar berhasil dikirim! Menunggu moderasi.');
    }
}