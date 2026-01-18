<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * UserAuthController
 * Controller untuk menangani Otentikasi User (Login, Register, Logout).
 * Menggunakan Facade 'Auth' bawaan Laravel.
 */
class UserAuthController extends Controller
{
    /**
     * Tampilkan form login
     * Method untuk menampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     * Menerima input dari form login (POST)
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // LOGIC MULTI-AUTH (Admin & User)

        // 2. Cek apakah yang login adalah Admin?
        // Menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate(); // Regenerate session ID (Security fix session fixation)
            return redirect()->route('admin.dashboard');
        }

        // 3. Cek apakah yang login adalah User Biasa?
        // Menggunakan guard 'web' (default)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect ke halaman yang tadinya mau dibuka (intended), atau ke home
            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // 4. Jika gagal login (Password/Email salah)
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email'); // Kembalikan input email agar user tidak perlu ketik ulang
    }

    /**
     * Tampilkan form register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses register user baru
     */
    public function register(Request $request)
    {
        // 1. Validasi Input Register
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class], // Email harus unik di tabel users
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // Confirmed: harus cocok dengan field password_confirmation
        ]);

        // 2. Simpan Data User Baru ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-HASH (enkripsi)
        ]);

        // 3. Auto Login setelah register (opsional, biar user gak perlu login manual lagi)
        Auth::login($user);

        // 4. Redirect ke Home
        return redirect(route('home'))->with('success', 'Akun berhasil dibuat! Selamat datang.');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        // 1. Hapus sesi login
        Auth::logout();

        // 2. Invalidate session (Security best practice)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Kembalikan ke halaman utama
        return redirect('/')->with('success', 'Berhasil logout.');
    }
}
