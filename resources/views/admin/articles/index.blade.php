@extends('admin.layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Artikel</h1>
        <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 transition">
            + Tambah Artikel
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        {{-- Tabel Artikel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 uppercase font-bold border-b">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $article->title }}
                                @if($article->is_featured)
                                    <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-0.5 rounded">Hot News</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $article->category->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($article->status === 'published')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        Published
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-semibold">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500">
                                {{ optional($article->published_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <span class="text-gray-300">|</span>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada artikel. Silakan tambah artikel baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links (Tombol Next/Prev) --}}
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $articles->links() }}
        </div>
    </div>
@endsection