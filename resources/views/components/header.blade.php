<header class="bg-white shadow-sm sticky top-0 z-40 border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
        
        {{-- TOMBOL HAMBURGER (Kiri) --}}
        <button 
            @click="sidebarOpen = true" 
            class="p-2 -ml-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-red-600 transition focus:outline-none focus:ring-2 focus:ring-gray-200"
            aria-label="Open Menu"
        >
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </button>

        {{-- LOGO (Tengah) --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
             {{-- Icon Bola Kecil --}}
            <div class="hidden md:block bg-red-600 text-white p-1 rounded-md transform group-hover:rotate-12 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
            <div class="text-2xl font-bold tracking-tight">
                <span class="text-gray-900 group-hover:text-black transition">Seputar</span><span class="text-red-600">.Bola</span>
            </div>
        </a>

        {{-- KANAN (Search Icon / User Avatar) --}}
        <div class="flex items-center gap-2">
            
            {{-- Search Toggle (Mobile) --}}
            <a href="{{ route('search') }}" class="p-2 text-gray-500 hover:text-red-600 rounded-full hover:bg-gray-50 transition md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </a>

            {{-- User Desktop Shortcut --}}
            @auth('web')
                <a href="{{ route('bookmarks.index') }}" class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full border border-gray-200 hover:border-red-200 hover:bg-red-50 transition">
                    <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                    <span class="text-xs font-semibold text-gray-700">{{ Str::limit(Auth::user()->name, 10) }}</span>
                </a>
            @elseauth('admin')
                 {{-- Jika Admin sedang akses frontend --}}
                <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-600 text-white hover:bg-red-700 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-xs font-semibold">Admin Panel</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="hidden md:block text-sm font-semibold text-red-600 hover:text-red-700 px-3 py-1">
                    Masuk
                </a>
            @endauth
        </div>

    </div>
</header>
