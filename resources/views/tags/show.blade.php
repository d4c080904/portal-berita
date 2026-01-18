@extends('layouts.app')

@section('title', 'Tag: #' . $tag->name . ' | Seputar.Bola')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Header Judul Tag --}}
    <div class="mb-8 border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-900">
            Topik: <span class="text-red-600">#{{ $tag->name }}</span>
        </h1>
        <p class="text-gray-600 mt-2">Menampilkan berita terkini seputar "{{ $tag->name }}".</p>
    </div>

    {{-- Daftar Berita --}}
    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <article class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                    {{-- Gambar --}}
                    <div class="h-48 overflow-hidden bg-gray-100">
                        @if($article->image)
                            <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">No Image</div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-5">
                        <div class="text-xs text-gray-500 mb-2">
                            {{ optional($article->published_at)->format('d F Y') }}
                        </div>
                        <h2 class="text-xl font-semibold mb-3 line-clamp-2 group-hover:text-red-600 transition">
                            <a href="{{ route('articles.detail', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <a href="{{ route('articles.detail', $article->slug) }}" class="text-red-600 text-sm font-medium hover:underline">
                            Baca selengkapnya →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination (Halaman 1, 2, dst) --}}
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-16 text-gray-600 bg-gray-50 rounded-lg border border-dashed">
            Belum ada berita dengan tag ini.
        </div>
    @endif
</div>
@endsection