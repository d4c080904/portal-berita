<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO: Judul Dinamis --}}
    <title>@yield('title', 'Portal Berita Terkini') | Seputar.Bola</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    {{-- ALPINE.JS (Untuk Interaktivitas Sidebar) --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @stack('head') {{-- opsional per-halaman --}}
</head>
<body class="bg-gray-50 text-gray-900 leading-normal font-sans antialiased">
    
    {{-- LAYOUT WRAPPER (Alpine State) --}}
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col">
        
        {{-- SIDEBAR COMPONENT --}}
        @include('components.sidebar')

        {{-- HEADER COMPONENT --}}
        @include('components.header')

        {{-- Flash Message --}}
        @if(session('status'))
            <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
                <div class="bg-green-50 border border-green-200 text-green-800 rounded px-4 py-3 shadow-sm">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        {{-- MAIN CONTENT --}}
        <main class="flex-1 w-full max-w-7xl mx-auto px-4 py-6">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-white py-6 mt-auto border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-600 text-sm">
                &copy; {{ date('Y') }} Seputar.Bola. <span class="hidden md:inline">All rights reserved.</span>
            </div>
        </footer>

    </div>

    @stack('scripts')
</body>
</html>