@extends('admin.layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Profil Saya</h1>
            <p class="text-gray-600">Perbarui informasi akun dan password Anda.</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-red-500 focus:border-red-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" readonly title="Email tidak dapat diubah sembarangan">
                    <p class="text-xs text-gray-500 mt-1">*Email dikunci demi keamanan.</p>
                </div>

                <hr class="my-6 border-gray-200">
                
                <h3 class="text-lg font-bold text-gray-800 mb-4">Ganti Password</h3>
                <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengganti password.</p>

                {{-- Password Baru --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Password Baru</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-red-500 focus:border-red-500">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-red-500 focus:border-red-500">
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-600 bg-gray-100 rounded hover:bg-gray-200 transition">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white font-bold rounded hover:bg-red-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection