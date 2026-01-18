@php
    use Illuminate\Support\Str;
    // Helper untuk menu aktif
    $isActive = fn($route) => request()->routeIs($route) ? 'text-red-600 bg-red-50 font-bold' : 'text-gray-700 hover:text-red-600 hover:bg-gray-50';
    $isCategoryActive = fn($slug) => request()->is('kategori/'.$slug) ? 'text-red-600 bg-red-50 font-bold' : 'text-gray-700 hover:text-red-600 hover:bg-gray-50';
@endphp

{{-- 
    COMPONENT SIDEBAR (Off-canvas)
    Menggunakan Alpine.js untuk state open/close (sidebarOpen) yang di-pass dari Layout
--}}
<div 
    x-show="sidebarOpen" 
    class="fixed inset-0 z-50 flex items-start justify-start" 
    style="display: none;" 
    role="dialog" 
    aria-modal="true"
>
    
    {{-- BACKDROP / OVERLAY --}}
    <div 
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm"
        @click="sidebarOpen = false"
    ></div>

    {{-- SIDEBAR PANEL --}}
    <div 
        x-show="sidebarOpen"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="relative flex flex-col w-80 max-w-xs h-full bg-white shadow-2xl overflow-y-auto"
    >
        {{-- HEADER SIDEBAR --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="bg-red-600 text-white p-1.5 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div class="text-xl font-bold tracking-tight">
                    <span class="text-gray-900">Seputar</span><span class="text-red-600">.Bola</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-red-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- MENU NAVIGASI --}}
        <nav class="flex-1 px-4 py-6 space-y-8">
            
            {{-- BAGIAN UTAMA --}}
            <div>
                <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Menu Utama</h3>
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ $isActive('home') }}">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Beranda
                    </a>
                    
                    {{-- SEARCH BAR (Mobile Friendly inside sidebar) --}}
                    <div class="mt-2 px-1">
                        <form action="{{ route('search') }}" method="GET" class="relative">
                            <input type="text" name="q" placeholder="Cari berita..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block pl-10 p-2.5" value="{{ request('q') }}">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- DAFTAR LIGA --}}
            <div>
                <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Kategori Liga</h3>
                <div class="space-y-1">
                    <a href="{{ route('categories.show', 'liga-inggris') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('liga-inggris') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span>
                        Liga Inggris
                    </a>
                    <a href="{{ route('categories.show', 'liga-spanyol') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('liga-spanyol') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-3"></span>
                        Liga Spanyol
                    </a>
                    <a href="{{ route('categories.show', 'liga-italia') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('liga-italia') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-3"></span>
                        Liga Italia
                    </a>
                    <a href="{{ route('categories.show', 'liga-jerman') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('liga-jerman') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-800 mr-3"></span>
                        Liga Jerman
                    </a>
                    <a href="{{ route('categories.show', 'liga-prancis') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('liga-prancis') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-800 mr-3"></span>
                        Liga Prancis
                    </a>
                     <a href="{{ route('categories.show', 'liga-indonesia') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('liga-indonesia') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-3"></span>
                        Liga Indonesia
                    </a>
                     <a href="{{ route('categories.show', 'champions') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('champions') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 mr-3"></span>
                        Liga Champions
                    </a>
                    <a href="{{ route('categories.show', 'transfer') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition {{ $isCategoryActive('transfer') }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-600 mr-3"></span>
                        Bursa Transfer
                    </a>
                </div>
            </div>

        </nav>

        {{-- USER PROFILE / FOOTER --}}
        <div class="border-t border-gray-100 p-4 bg-gray-50">
            @auth('web')
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full object-cover border border-white shadow-sm">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('bookmarks.index') }}" class="text-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition shadow-sm">
                        Favorit
                    </a>
                    <a href="{{ route('user.profile.edit') }}" class="text-center px-3 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition shadow-sm">
                        Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="contents col-span-2">
                        @csrf
                        <button type="submit" class="w-full text-center px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-sm">
                            Logout
                        </button>
                    </form>
                </div>
            @elseauth('admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Dashboard Admin
                </a>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full justify-center flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="w-full justify-center flex items-center px-4 py-2.5 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-md">
                        Daftar Akun
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
