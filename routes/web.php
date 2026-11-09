<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\MahasiswaController as AdminMahasiswaController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\ProdukController as MahasiswaProdukController;
use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/produk/{produk}', [KatalogController::class, 'show'])->name('katalog.show');

/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Student (Mahasiswa) routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');

        Route::get('/produk', [MahasiswaProdukController::class, 'index'])->name('produk.index');
        Route::get('/produk/create', [MahasiswaProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [MahasiswaProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{produk}', [MahasiswaProdukController::class, 'show'])->name('produk.show');
        Route::get('/produk/{produk}/edit', [MahasiswaProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{produk}', [MahasiswaProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{produk}', [MahasiswaProdukController::class, 'destroy'])->name('produk.destroy');

        Route::get('/profil', [MahasiswaProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [MahasiswaProfileController::class, 'update'])->name('profile.update');
    });

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/verifikasi', [AdminProdukController::class, 'index'])->name('verifikasi.index');
        Route::get('/verifikasi/{produk}', [AdminProdukController::class, 'show'])->name('verifikasi.show');
        Route::patch('/verifikasi/{produk}/setujui', [AdminProdukController::class, 'approve'])->name('verifikasi.approve');
        Route::patch('/verifikasi/{produk}/tolak', [AdminProdukController::class, 'reject'])->name('verifikasi.reject');

        Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{kategori}', [AdminKategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');

        Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('mahasiswa.index');
    });
