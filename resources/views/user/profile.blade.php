@extends('layouts.app')

@section('title', 'Edit Profil | Seputar.Bola')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-6 md:p-8 border-b border-gray-100">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h1>
            <p class="text-gray-500 text-sm mt-1">Perbarui informasi akun dan foto profil Anda.</p>
        </div>

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 border-l-4 border-green-500">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: FOTO PROFIL --}}
                <div class="md:col-span-1 text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4 group">
                        <img src="{{ Auth::user()->avatar_url }}" alt="Profile" 
                             class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg group-hover:opacity-75 transition">
                        
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </div>
                    
                    <label class="block">
                        <span class="sr-only">Upload Foto</span>
                        <input type="file" name="avatar" class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-xs file:font-semibold
                          file:bg-red-50 file:text-red-700
                          hover:file:bg-red-100 cursor-pointer
                        "/>
                    </label>
                    <p class="text-xs text-gray-400 mt-2">JPG, PNG, GIF (Max. 2MB)</p>
                    @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- KOLOM KANAN: FORM DATA --}}
                <div class="md:col-span-2 space-y-6">
                    
                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-red-500 focus:border-red-500 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-red-500 focus:border-red-500 transition">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <hr class="border-gray-100 my-6">
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-sm font-bold text-yellow-800 mb-3">Ganti Password (Opsional)</h3>
                        
                        {{-- Password Saat Ini --}}
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" placeholder="Isi hanya jika ingin ganti password"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500 bg-white">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Password Baru --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Password Baru</label>
                                <input type="password" name="new_password" 
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500 bg-white">
                                @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            {{-- Konfirmasi Password --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Ulangi Password Baru</label>
                                <input type="password" name="new_password_confirmation" 
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500 bg-white">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg hover:bg-red-600 transition font-medium shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
