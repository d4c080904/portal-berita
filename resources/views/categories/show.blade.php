@extends('layouts.app')

@section('title', $categoryName . ' | Seputar.Bola')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    {{-- Header kategori --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $categoryName }}</h1>
        <p class="text-gray-600 mt-2">Berita terbaru seputar {{ strtolower($categoryName) }}.</p>
    </div>

    @if(count($articles))
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <article class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                    {{-- Gambar --}}
                    <div class="h-48 overflow-hidden bg-gray-100">
                        <img
                            src="{{ $article['image'] }}"
                            alt="{{ $article['title'] }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-gray-400 bg-gray-100\'>Gambar tidak tersedia</div>';"
                        />
                    </div>

                    {{-- Konten --}}
                    <div class="p-5">
                        @if(!empty($article['date']))
                            <div class="text-xs text-gray-500 mb-2">{{ $article['date'] }}</div>
                        @endif

                        <h2 class="text-xl font-semibold mb-3 line-clamp-2 group-hover:text-red-600 transition">
                            {{ $article['title'] }}
                        </h2>

                        @if(!empty($article['excerpt']))
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $article['excerpt'] }}
                            </p>
                        @endif

                        <a href="{{ route('articles.detail', ['slug' => $article['slug']]) }}"
                           class="text-red-600 text-sm font-medium hover:underline">
                            Baca selengkapnya →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 text-gray-600">
            Belum ada berita untuk kategori ini.
        </div>
    @endif
</div>
@endsection
