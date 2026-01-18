<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 1. Tampilkan Halaman Edit Profil
    public function edit()
    {
        return view('admin.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // 2. Proses Update Data
    public function update(Request $request)
    {
        /** @var \App\Models\Admin $user */ // <--- BARIS PENTING: Supaya VS Code tau ini Model Admin
        $user = Auth::user();

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            // Email harus unik di tabel 'admins', tapi abaikan (ignore) untuk ID user ini sendiri
            'email' => 'required|email|unique:admins,email,'.$user->id, 
            'password' => 'nullable|min:6|confirmed', // Password boleh kosong
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        // Update Nama & Email
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek apakah user mengisi kolom password?
        if ($request->filled('password')) {
            // Kalau diisi, ganti password baru (dienkripsi)
            $user->password = Hash::make($request->password);
        }

        $user->save(); // <--- Error garis merah pasti hilang sekarang

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}