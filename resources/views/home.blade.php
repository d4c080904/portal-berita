@extends('layouts.app')

{{-- Cukup tulis 'Beranda', nanti otomatis digabung jadi 'Beranda | Seputar.Bola' --}}
@section('title', 'Beranda')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-10">

    {{-- ===================== BERITA UNGGULAN (HERO SECTION) ===================== --}}
    @if($featured)
        <section>
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1 h-6 bg-red-600 rounded-full"></span>
                <h2 class="text-2xl font-bold text-gray-900">Berita Unggulan</h2>
            </div>

            <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row hover:shadow-md transition duration-300">
                @if($featured->image)
                    <div class="md:w-7/12 h-64 md:h-auto overflow-hidden relative group">
                        <img
                            src="{{ asset('storage/'.$featured->image) }}"
                            alt="{{ $featured->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >
                        {{-- Badge Kategori di atas gambar --}}
                        @if($featured->category)
                            <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded shadow">
                                {{ $featured->category->name }}
                            </span>
                        @endif
                    </div>
                @endif
                <div class="p-6 md:p-8 flex-1 flex flex-col justify-center">
                    <div class="flex items-center text-xs text-gray-500 mb-3 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ optional($featured->published_at)->format('d F Y') }}
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold mb-4 leading-tight text-gray-900 hover:text-red-600 transition">
                        <a href="{{ route('articles.detail', $featured->slug) }}">
                            {{ $featured->title }}
                        </a>
                    </h1>

                    <p class="text-gray-600 mb-6 leading-relaxed line-clamp-3">
                        {{ Str::limit(strip_tags($featured->content), 180) }}
                    </p>

                    <div>
                        <a
                            href="{{ route('articles.detail', $featured->slug) }}"
                            class="inline-flex items-center gap-2 text-red-600 font-semibold hover:text-red-700 transition"
                        >
                            Baca Selengkapnya 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </article>
        </section>
    @endif

    {{-- SECTION: KATEGORI UTAMA (GRID 4 KOLOM) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        
        {{-- KOLOM 1: LIGA INGGRIS --}}
        <div>
            <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-lg font-bold text-gray-900 border-l-4 border-purple-600 pl-3">
                    Liga Inggris
                </h3>
            </div>
            <div class="space-y-4">
                @forelse($ligaInggris as $index => $item)
                    @if($index === 0)
                         {{-- Berita Pertama Besar --}}
                         <article class="group">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="block overflow-hidden rounded-lg mb-2 h-40 relative">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                            <h4 class="font-bold text-base mb-1 leading-snug group-hover:text-purple-600 transition">
                                <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                            </h4>
                            <p class="text-xs text-gray-500">{{ $item->published_at->diffForHumans() }}</p>
                         </article>
                    @else
                        {{-- Berita List Kecil --}}
                        <article class="flex gap-4 group border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="flex-shrink-0 w-24 h-16 rounded-md overflow-hidden relative bg-gray-100">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/400x300?text=No+Img' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition">
                            </a>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-sm mb-1 line-clamp-2 leading-snug group-hover:text-purple-600 transition">
                                    <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                                </h4>
                                <span class="text-xs text-gray-500">{{ $item->published_at->diffForHumans() }}</span>
                            </div>
                        </article>
                    @endif
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada berita.</p>
                @endforelse
            </div>
        </div>

        {{-- KOLOM 2: LIGA SPANYOL --}}
         <div>
            <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-lg font-bold text-gray-900 border-l-4 border-yellow-500 pl-3">
                    Liga Spanyol
                </h3>
            </div>
            <div class="space-y-4">
                @forelse($ligaSpanyol as $index => $item)
                    @if($index === 0)
                         <article class="group">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="block overflow-hidden rounded-lg mb-2 h-40 relative">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                            <h4 class="font-bold text-base mb-1 leading-snug group-hover:text-yellow-600 transition">
                                <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                            </h4>
                             <p class="text-xs text-gray-500">{{ $item->published_at->diffForHumans() }}</p>
                         </article>
                    @else
                        <article class="flex gap-3 group border-b border-gray-50 pb-3 last:border-0">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="flex-shrink-0 w-16 h-16 rounded overflow-hidden relative bg-gray-100">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/100x100?text=No+Img' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition">
                            </a>
                            <div>
                                <h4 class="font-semibold text-xs mb-1 line-clamp-2 leading-snug group-hover:text-yellow-600 transition">
                                    <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                                </h4>
                                <span class="text-[10px] text-gray-400">{{ $item->published_at->diffForHumans() }}</span>
                            </div>
                        </article>
                    @endif
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada berita.</p>
                @endforelse
            </div>
        </div>

        {{-- KOLOM 3: LIGA ITALIA --}}
         <div>
            <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-lg font-bold text-gray-900 border-l-4 border-green-600 pl-3">
                    Liga Italia
                </h3>
            </div>
            <div class="space-y-4">
                @forelse($ligaItalia as $index => $item)
                    @if($index === 0)
                         <article class="group">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="block overflow-hidden rounded-lg mb-2 h-40 relative">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                            <h4 class="font-bold text-base mb-1 leading-snug group-hover:text-green-600 transition">
                                <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                            </h4>
                             <p class="text-xs text-gray-500">{{ $item->published_at->diffForHumans() }}</p>
                         </article>
                    @else
                        <article class="flex gap-3 group border-b border-gray-50 pb-3 last:border-0">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="flex-shrink-0 w-16 h-16 rounded overflow-hidden relative bg-gray-100">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/100x100?text=No+Img' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition">
                            </a>
                            <div>
                                <h4 class="font-semibold text-xs mb-1 line-clamp-2 leading-snug group-hover:text-green-600 transition">
                                    <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                                </h4>
                                <span class="text-[10px] text-gray-400">{{ $item->published_at->diffForHumans() }}</span>
                            </div>
                        </article>
                    @endif
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada berita.</p>
                @endforelse
            </div>
        </div>

        {{-- KOLOM 4: TRANSFER --}}
         <div>
            <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-2">
                <h3 class="text-lg font-bold text-gray-900 border-l-4 border-blue-600 pl-3">
                    Bursa Transfer
                </h3>
            </div>
            <div class="space-y-4">
                @forelse($transfer as $index => $item)
                    @if($index === 0)
                         <article class="group">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="block overflow-hidden rounded-lg mb-2 h-40 relative">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                            <h4 class="font-bold text-base mb-1 leading-snug group-hover:text-blue-600 transition">
                                <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                            </h4>
                             <p class="text-xs text-gray-500">{{ $item->published_at->diffForHumans() }}</p>
                         </article>
                    @else
                        <article class="flex gap-3 group border-b border-gray-50 pb-3 last:border-0">
                            <a href="{{ route('articles.detail', $item->slug) }}" class="flex-shrink-0 w-16 h-16 rounded overflow-hidden relative bg-gray-100">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://placehold.co/100x100?text=No+Img' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition">
                            </a>
                            <div>
                                <h4 class="font-semibold text-xs mb-1 line-clamp-2 leading-snug group-hover:text-blue-600 transition">
                                    <a href="{{ route('articles.detail', $item->slug) }}">{{ $item->title }}</a>
                                </h4>
                                <span class="text-[10px] text-gray-400">{{ $item->published_at->diffForHumans() }}</span>
                            </div>
                        </article>
                    @endif
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada berita.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection