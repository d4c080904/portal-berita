@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
        <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    {{-- Grid Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Card 1: Total Artikel --}}
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    {{-- Icon Document --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Artikel</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalArticles ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Card 2: Status Artikel (Published / Draft) --}}
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    {{-- Icon Check Circle --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Status Artikel</p>
                    <div class="flex gap-3 text-sm">
                        <span class="text-green-600 font-bold">{{ $publishedArticles ?? 0 }} Pub</span>
                        <span class="text-gray-300">|</span>
                        <span class="text-gray-500 font-bold">{{ $draftArticles ?? 0 }} Draft</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Total Kategori --}}
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                    {{-- Icon Folder --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCategories ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Card 4: Total Komentar --}}
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                    {{-- Icon Chat --}}
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Komentar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalComments ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Tambahan / Quick Links --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-blue-800">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Info Admin
            </h3>
            <p class="mb-4 text-sm">Gunakan menu di sebelah kiri untuk mengelola artikel, kategori, atau melihat komentar masuk.</p>
            <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold hover:underline">Kelola Artikel &rarr;</a>
        </div>
        
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-gray-800">
             <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                Akses Website
            </h3>
            <p class="mb-4 text-sm">Lihat tampilan website publik seperti yang dilihat oleh pengunjung.</p>
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 transition">Buka Website</a>
        </div>
    </div>
@endsection