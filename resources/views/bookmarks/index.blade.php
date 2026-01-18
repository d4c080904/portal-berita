@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                <span class="text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                </span>
                Artikel Disimpan <span class="text-gray-500 text-lg font-medium">({{ $articles->count() }})</span>
            </h2>
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        @if($articles->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="mx-auto h-12 w-12 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada artikel disimpan</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai baca berita dan simpan yang menarik untuk dibaca nanti.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cari Berita
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <div
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 overflow-hidden border border-gray-100 flex flex-col h-full group">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $article->image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                alt="{{ $article->title }}">
                            <span
                                class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-sm">
                                {{ $article->category->name }}
                            </span>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h5 class="text-xl font-bold text-gray-900 mb-2 leading-tight">
                                <a href="{{ route('articles.detail', $article->slug) }}" class="hover:text-red-600 transition">
                                    {{ Str::limit($article->title, 60) }}
                                </a>
                            </h5>
                            <p class="text-gray-600 text-sm mb-4 flex-1">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500 font-medium">
                                    {{ $article->created_at->diffForHumans() }}
                                </span>

                                <form action="{{ route('bookmarks.toggle', $article->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition"
                                        title="Hapus dari simpanan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
@endsection