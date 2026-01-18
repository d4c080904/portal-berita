<?php

use Illuminate\Support\Facades\Route;

// ================== PUBLIC CONTROLLERS ==================
// Controller yang diakses oleh user umum (pengunjung website)
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Auth\UserAuthController; // [NEW] Auth User (Login/Register User)
use App\Http\Controllers\BookmarkController;      // [NEW] Bookmark (Fitur Simpan Artikel)
use App\Http\Controllers\UserProfileController;   // [NEW] User Profile

// ================== ADMIN CONTROLLERS ==================
// Controller khusus untuk halaman admin panel
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController; // <--- Controller Profil (Target Minggu 11)

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Halaman User)
|--------------------------------------------------------------------------
| Route di bawah ini bisa diakses oleh siapa saja (Guest).
| Konsep: Route::request_method('url', [Controller::class, 'nama_fungsi'])
*/

// 1. Beranda: Halaman utama yang menampilkan daftar artikel terbaru
Route::get('/', [ArticleController::class, 'index'])->name('home');

// 2. Detail Artikel: Menampilkan isi lengkap berita berdasarkan slug (judul yang di-url-kan)
Route::get('/articles/{slug}', [ArticleController::class, 'show'])
    ->name('articles.detail');

// 3. Kirim Komentar: Logic POST untuk menyimpan komentar user ke database
Route::post('/articles/{slug}/comment', [CommentController::class, 'store'])
    ->name('articles.comment');

// 4. Halaman Pencarian Tag: Menampilkan artikel yang memiliki tag tertentu
Route::get('/tag/{slug}', [TagController::class, 'show'])
    ->name('tags.show');

// 5. Halaman Kategori: Menampilkan artikel dalam kategori tertentu (misal: Politik, Olahraga)
Route::get('/kategori/{categorySlug}', [CategoryController::class, 'show'])
    ->name('categories.show');

// 6. Pencarian Global: Fitur search bar di navbar
Route::get('/search', [SearchController::class, 'index'])->name('search');

// ================== USER AUTH ROUTES (Front End) ==================
// Grouping Middleware Guest: Hanya bisa diakses jika user BELUM login
Route::middleware('guest')->group(function () {
    // Form Login & Proses Login
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);

    // Form Register & Proses Register
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);
});

// Grouping Middleware Auth: Hanya bisa diakses jika user SUDAH login
Route::middleware('auth')->group(function () {
    // Proses Logout
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    // Bookmarks: Fitur menyimpan artikel favorit
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index'); // List bookmark
    Route::post('/articles/{article}/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle'); // Tambah/Hapus bookmark

    // User Profile: Edit Profil (Nama, Avatar, Password)
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Halaman Dashboard)
|--------------------------------------------------------------------------
| Route khusus admin. Menggunakan prefix 'admin' (contoh: website.com/admin/login)
*/

// Redirect otomatis: jika akses /admin maka lempar ke /admin/login
Route::redirect('/admin', '/admin/login');

// Grouping Route Admin
Route::prefix('admin')->name('admin.')->group(function () {

    // ========== GUEST ADMIN (Belum Login) ==========
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [AdminLoginController::class, 'login'])
            ->name('login.attempt');
    });

    // ========== AUTH ADMIN (Sudah Login) ==========
    Route::middleware('auth:admin')->group(function () {

        // Dashboard Utama
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Edit Profil Admin (Target Minggu 11)
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Logout Admin
        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('logout');

        // Manajemen Artikel (CRUD - Create, Read, Update, Delete)
        // Route::resource otomatis membuat route lengkap untuk index, create, store, edit, update, destroy
        Route::resource('articles', AdminArticleController::class);
    });
});