@extends('layouts.app')

@section('title', ($article->title ?? 'Detail Berita') . ' | Seputar.Bola')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- MAIN CONTENT (SINGLE COLUMN) --}}
    <div class="w-full mb-16">
        @if($article)
            {{-- Gambar Artikel --}}
            @if($article->image)
                <img
                    src="{{ asset('storage/'.$article->image) }}"
                    alt="{{ $article->title }}"
                    class="w-full max-h-[500px] object-cover rounded-lg mb-8 shadow-sm"
                >
            @endif

            {{-- Judul Artikel --}}
            <h1 class="text-3xl md:text-5xl font-bold mb-6 leading-tight text-gray-900 flex justify-between items-start gap-4">
                <span>{{ $article->title }}</span>
                
                @auth
                    {{-- TOMBOL BOOKMARK (Hanya untuk User Login) --}}
                    @php
                        $isBookmarked = auth()->user()->bookmarks->contains($article->id);
                    @endphp
                    <form action="{{ route('bookmarks.toggle', $article->id) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" 
                            class="p-2 rounded-full border transition duration-200 {{ $isBookmarked ? 'bg-red-600 text-white border-red-600 hover:bg-red-700' : 'bg-white text-gray-400 border-gray-200 hover:text-red-600 hover:border-red-600' }}"
                            title="{{ $isBookmarked ? 'Hapus Simpanan' : 'Simpan Berita' }}">
                            
                            {{-- Icon Bookmark Filled / Outline --}}
                            @if($isBookmarked)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            @endif
                        </button>
                    </form>
                @endauth
            </h1>

            {{-- Info Meta (Penulis, Tanggal, Kategori) --}}
            <div class="flex flex-wrap items-center text-sm md:text-base text-gray-500 mb-8 gap-x-4 gap-y-2 border-b border-gray-100 pb-8">
                @if($article->author)
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-bold text-xs">
                            {{ strtoupper(substr($article->author, 0, 1)) }}
                        </div>
                        <span class="font-medium text-gray-900">{{ $article->author }}</span>
                    </div>
                    <span class="hidden md:inline">•</span>
                @endif
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ optional($article->published_at)->format('d F Y') }}</span>
                </div>
                @if($article->category)
                    <a href="{{ route('categories.show', $article->category->slug) }}" class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-sm font-semibold hover:bg-red-100 transition">
                        {{ $article->category->name }}
                    </a>
                @endif
            </div>

            {{-- Isi Konten Artikel --}}
            <div class="prose prose-lg md:prose-xl text-gray-800 max-w-none leading-relaxed space-y-6 mb-12">
                {!! $article->content !!}
            </div>
            
            {{-- Tags (Bisa diklik) --}}
            @if($article->tags && $article->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mb-12 items-center">
                    <span class="font-bold text-gray-700 mr-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a2 2 0 012-2z"></path></svg>
                        Tags:
                    </span>
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm hover:bg-gray-200 hover:text-gray-900 transition cursor-pointer decoration-0">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- ================= SISTEM KOMENTAR ================= --}}
            <div class="bg-gray-50 rounded-xl p-6 md:p-8 border border-gray-100">
                <h3 class="text-2xl font-bold mb-6 text-gray-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    Diskusi <span class="text-gray-500 text-lg font-normal">({{ $article->comments->count() }})</span>
                </h3>
                
                {{-- Form Kirim Komentar --}}
                <form action="{{ route('articles.comment', $article->slug) }}" method="POST" class="bg-white p-6 rounded-lg mb-8 shadow-sm border border-gray-200">
                    @csrf
                    <h4 class="font-semibold mb-4 text-gray-800">Tulis Komentar</h4>
                    
                    {{-- Pesan Sukses --}}
                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 p-4 rounded mb-6 text-sm border-l-4 border-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        @guest
                            {{-- Input Nama & Email (Untuk GUEST) --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama</label>
                                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" 
                                       class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition @error('name') border-red-500 @enderror" required>
                                @error('name') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Email <span class="normal-case font-normal text-gray-400">(Privasi terjaga)</span></label>
                                <input type="email" name="email" placeholder="alamat@email.com" value="{{ old('email') }}" 
                                       class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition @error('email') border-red-500 @enderror" required>
                                @error('email') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>
                        @else
                            {{-- Info User Login (Otomatis) --}}
                            <div class="col-span-1 md:col-span-2 bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-blue-200">
                                    <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm text-blue-800">Masuk sebagai <span class="font-bold">{{ Auth::user()->name }}</span></p>
                                    <p class="text-xs text-blue-600">Komentar akan diposting menggunakan identitas ini.</p>
                                </div>
                            </div>
                        @endguest
                    </div>
                    
                    {{-- Input Body --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Komentar</label>
                        <textarea name="body" rows="4" placeholder="Bagikan pendapat Anda..." 
                                  class="border border-gray-300 rounded px-4 py-2 w-full mb-2 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition @error('body') border-red-500 @enderror" required>{{ old('body') }}</textarea>
                        @error('body') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div class="mt-4 text-right">
                        <button class="bg-gray-900 text-white px-8 py-2.5 rounded hover:bg-red-600 font-medium transition duration-300 transform hover:-translate-y-0.5">
                            Kirim Komentar
                        </button>
                    </div>
                </form>

                {{-- Daftar Komentar --}}
                <div class="space-y-6">
                    @forelse($article->comments as $comment)
                        <div class="flex gap-4 p-4 hover:bg-white rounded-lg transition duration-200">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xl shadow-inner">
                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h5 class="font-bold text-gray-900">{{ $comment->name }}</h5>
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->isoFormat('D MMMM Y, HH:mm') }}</span>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-base leading-relaxed text-justify">{{ $comment->body }}</p>
                            </div>
                        </div>
                        @if(!$loop->last) <hr class="border-gray-200 border-dashed my-2"> @endif
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-gray-500 font-medium">Belum ada komentar.</p>
                            <p class="text-sm text-gray-400">Jadilah yang pertama memberikan tanggapan!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        @else
            <div class="text-center py-20">
                <h2 class="text-2xl font-bold text-gray-400">Artikel tidak ditemukan</h2>
                <a href="{{ route('home') }}" class="text-red-500 hover:underline mt-2 inline-block">Kembali ke Beranda</a>
            </div>
        @endif
    </div>

    {{-- RELATED ARTICLES (BOTTOM GRID) --}}
    @if(isset($relatedArticles) && $relatedArticles->count() > 0)
        <div class="border-t-4 border-black pt-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <span class="bg-red-600 w-2 h-8 block rounded-sm"></span>
                Baca Juga
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedArticles as $related)
                    <a href="{{ route('articles.detail', $related->slug) }}" class="group block h-full">
                        <article class="bg-white h-full flex flex-col rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100">
                            {{-- Thumbnail --}}
                            <div class="relative overflow-hidden aspect-[4/3] bg-gray-200">
                                @if($related->image)
                                    <img src="{{ asset('storage/'.$related->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded backdrop-blur-sm">
                                    {{ $related->category->name }}
                                </div>
                            </div>
                            
                            {{-- Konten Ringkas --}}
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-600 line-clamp-2 leading-snug mb-2 transition">
                                    {{ $related->title }}
                                </h3>
                                <div class="mt-auto pt-4 flex items-center text-xs text-gray-500 border-t border-gray-50">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ optional($related->published_at)->diffForHumans() }}
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection