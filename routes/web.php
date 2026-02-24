<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Artisan;

// Route::get('/link-storage', function () {
//     Artisan::call('storage:link');
//     return 'Link Created';
// });

Route::get('/link-storage', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    symlink($target, $link);
    return 'Symlink Storage Berhasil Dibuat!';
});

// --- Rute Publik ---
Route::get('/', function () {
    return view('Awal');
});

//
Route::resource('category', CategoryController::class);

// --- Rute Profil Pengguna ---
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
});

//
Route::middleware(['auth', 'is_active'])->group(function () {

    // --- Rute Master Kategori ---
    // Menggunakan resource agar otomatis punya index, store, edit, update, destroy
    Route::resource('categories', CategoryController::class);

    // --- Rute Surat (Tambahan untuk AJAX Nomor Otomatis) ---
    // Rute ini penting agar saat pilih kategori, nomor langsung muncul tanpa refresh
    Route::get('/get-categories/{sifat}/{jenis}', [SuratController::class, 'getCategories']);
    Route::get('/get-nomor-surat/{categoryId}', [SuratController::class, 'getNomorAjax']);

    // Rute surat yang sudah ada (pastikan sudah mengarah ke controller yang benar)
    Route::get('/surat/input', [SuratController::class, 'input'])->name('surat.input');
    Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');
});

// --- Rute Autentikasi ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Rute Terproteksi (Harus Login & Active) ---
Route::get('/waiting-verification', function () {
    $user = Auth::user();
    if ($user && $user->status === 'active') {
        return redirect()->route('dashboard');
    }
    return view('auth.waiting-verification');
})->middleware('auth')->name('waiting.verification');

// Halaman Akun Nonaktif
Route::get('/account-inactive', function () {
    if (Auth::user()->status !== 'inactive') {
        return redirect('/dashboard');
    }
    return view('auth.inactive');
})->middleware('auth')->name('account.inactive');

// --- Rute Terproteksi (Harus Login & Active) ---
Route::middleware(['auth', 'is_active'])->group(function () {

    // Utama
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // Modul Surat (Grup dengan Prefix 'surat')
    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/input', [SuratController::class, 'input'])->name('input');
        Route::post('/store', [SuratController::class, 'store'])->name('store');


        Route::get('/masuk', [SuratController::class, 'masuk'])->name('masuk');
        Route::get('/keluar', [SuratController::class, 'keluar'])->name('keluar');


        Route::get('/edit/{id}', [SuratController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SuratController::class, 'update'])->name('update');

        Route::get('/download/{id}', [SuratController::class, 'download'])->name('download');
        Route::delete('/{id}', [SuratController::class, 'destroy'])->name('destroy');

        Route::get('/{surat}', [SuratController::class, 'show'])->name('show');
    });

    // --- MODUL LAPORAN / REKAP ---
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [SuratController::class, 'laporanForm'])->name('index');
        Route::post('/cetak', [SuratController::class, 'laporanCetak'])->name('cetak');
    });

    // Grup Admin
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {

        // Manajemen Surat (Trash & Restore)
        Route::get('/surat/trash', [SuratController::class, 'trash'])->name('surat.trash');
        Route::post('/surat/restore/{id}', [SuratController::class, 'restore'])->name('surat.restore');

        // Aksi Force Delete (Hapus Selamanya)
        Route::delete('/surat/force-delete/{id}', [SuratController::class, 'forceDelete'])->name('surat.force_delete');

        // Manajemen User (Aktif/Nonaktif)
        Route::get('/management', [UserController::class, 'userList'])->name('users.list');
        Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

        // Aksi Aktivasi Ulang Akun (PATCH)
        Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        // Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');

        // Halaman Daftar Verifikasi (GET)
        Route::get('/users', [UserController::class, 'verifikasi'])->name('users.index');

        // Aksi Verifikasi (PATCH/DELETE) - Approve atau Reject
        Route::patch('/users/{user}/verify', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');

        // Halaman Arsip User yang ditolak/dihapus
        Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');

        // Aksi Restore (Mengembalikan User)
        Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

        // Aksi Force Delete (Hapus Selamanya)
        Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force_delete');

        // Route Log Aktivitas (Opsional jika sudah ada controllernya)
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs');
    });
});
