@props(['article', 'index', 'hoverColor' => 'group-hover:text-gray-600'])

@if($index === 0)
    {{-- Tampilan Berita Pertama (Besar) --}}
    <article class="group">
        <a href="{{ route('articles.detail', $article->slug) }}" class="block overflow-hidden rounded-lg mb-2 h-40 relative">
            <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        </a>
        <h4 class="font-bold text-base mb-1 leading-snug {{ $hoverColor }} transition">
            <a href="{{ route('articles.detail', $article->slug) }}">{{ $article->title }}</a>
        </h4>
        <p class="text-xs text-gray-500">{{ $article->published_at->diffForHumans() }}</p>
    </article>
@else
    {{-- Tampilan Berita List Kecil --}}
    <article class="flex gap-3 group border-b border-gray-50 pb-3 last:border-0">
        <a href="{{ route('articles.detail', $article->slug) }}" class="flex-shrink-0 w-16 h-16 rounded overflow-hidden relative bg-gray-100">
            <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://placehold.co/100x100?text=No+Img' }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition">
        </a>
        <div>
            <h4 class="font-semibold text-xs mb-1 line-clamp-2 leading-snug {{ $hoverColor }} transition">
                <a href="{{ route('articles.detail', $article->slug) }}">{{ $article->title }}</a>
            </h4>
            <span class="text-[10px] text-gray-400">{{ $article->published_at->diffForHumans() }}</span>
        </div>
    </article>
@endif