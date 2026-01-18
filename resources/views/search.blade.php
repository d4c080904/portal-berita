@extends('layouts.app')

@section('title', 'Hasil Pencarian | Seputar.Bola')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center gap-2 mb-6">
        @if($query)
            <h1 class="text-2xl font-bold">
                Hasil pencarian untuk: <span class="text-red-600">"{{ $query }}"</span>
            </h1>
        @else
            <h1 class="text-2xl font-bold text-gray-900 border-l-4 border-red-600 pl-3">
                Semua Berita
            </h1>
        @endif
    </div>

    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <article class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-48 overflow-hidden bg-gray-100 relative">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform hover:scale-105 transition duration-500" />
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 text-sm">No Image</div>
                        @endif
                        
                        @if($article->category)
                             <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded">
                                {{ $article->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="text-xs text-gray-500 mb-2">{{ $article->published_at->diffForHumans() }}</div>
                        <h2 class="text-xl font-bold mb-2 leading-snug hover:text-red-600 transition">
                            <a href="{{ route('articles.detail', $article->slug) }}">{{ $article->title }}</a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                        <a href="{{ route('articles.detail', $article->slug) }}" class="text-red-600 text-sm font-semibold hover:underline flex items-center gap-1">
                            Baca selengkapnya <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-block p-4 rounded-full bg-gray-100 text-gray-400 mb-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Tidak ada berita ditemukan</h3>
            <p class="text-gray-500 mt-1">
                Kami tidak menemukan hasil untuk pencarian "<strong>{{ $query }}</strong>". Coba kata kunci lain.
            </p>
            <a href="{{ route('home') }}" class="mt-6 inline-block px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection
