<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    {{-- SEO Title --}}
    <title>@yield('title', 'Seputar.Bola Admin')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    
    {{-- TOP NAVBAR --}}
    <nav class="bg-white border-b shadow-sm relative z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            
            {{-- LOGO --}}
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg flex items-center gap-1">
                <span class="text-red-600">Seputar</span><span>.Bola Admin</span>
            </a>

            {{-- USER DROPDOWN (Kanan) --}}
            <div class="flex items-center gap-3">
                @php($admin = Auth::guard('admin')->user())
                
                {{-- Container Dropdown (Gunakan 'group' untuk hover effect) --}}
                <div class="relative group">
                    
                    {{-- Pemicu Dropdown (Avatar + Nama) --}}
                    <button class="flex items-center gap-2 focus:outline-none py-2">
                        <div class="w-8 h-8 rounded-full bg-red-600 text-white grid place-items-center text-sm font-semibold">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-red-600 transition">
                            {{ $admin->name }}
                        </span>
                        {{-- Icon Panah Bawah --}}
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    {{-- Isi Dropdown (Muncul saat di-hover) --}}
                    <div class="absolute right-0 top-full mt-1 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 hidden group-hover:block">
                        
                        {{-- 1. Link Edit Profil (Yang kamu minta) --}}
                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Edit Profil
                        </a>

                        <hr class="border-gray-100 my-1">

                        {{-- 2. Tombol Logout (Dipindah ke dalam dropdown) --}}
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </nav>

    {{-- MAIN WRAPPER --}}
    <main class="max-w-7xl mx-auto px-4 py-8">
        {{-- FLASH SUCCESS --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="bg-green-50 border border-green-200 text-green-800 rounded px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>