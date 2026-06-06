<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DaftarObatController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// sebelum login
Route::middleware('guest')->group(function () {
    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::post('/authenticate', [UserController::class,'authenticate']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout']);
    // route khusus admin_utama kecualikan yang dashboard dan yang logout
    Route::middleware('admin_utama')->group(function(){
        Route::controller(UserController::class)->group(function(){
            // sesudah login
            Route::get('/users', 'index')->name('users.index');
            Route::get('/users/create', 'create')->name('users.create');
            Route::post('/users/store', 'store')->name('users.store');
            Route::get('/users/{id}/edit', 'edit')->name('users.edit');
            Route::put('/users/{id}/update', 'update')->name('users.update');
            Route::delete('/users/{id}/destroy', 'destroy')->name('users.destroy');
        });
        Route::controller(KategoriObatController::class)->group(function(){
            Route::get('/kategori_obat', 'index')->name('kategori_obat.index');
            Route::get('/kategori_obat/create', 'create')->name('kategori_obat.create');
            Route::post('/kategori_obat/store', 'store')->name('kategori_obat.store');
            Route::get('/kategori_obat/{id}/edit', 'edit')->name('kategori_obat.edit');
            Route::put('/kategori_obat/{id}/update', 'update')->name('kategori_obat.update');
            Route::delete('/kategori_obat/{id}/destroy', 'destroy')->name('kategori_obat.destroy');
        });
    });
    
    Route::controller(DaftarObatController::class)->group(function(){
        Route::get('/daftar_obat', 'index')->name('daftar_obat.index');
        Route::get('/daftar_obat/create', 'create')->name('daftar_obat.create');
        Route::post('/daftar_obat/store', 'store')->name('daftar_obat.store');
        Route::get('/daftar_obat/{id}/edit', 'edit')->name('daftar_obat.edit');
        Route::put('/daftar_obat/{id}/update', 'update')->name('daftar_obat.update');
        Route::delete('/daftar_obat/{id}/destroy', 'destroy')->name('daftar_obat.destroy');
    });
    
    Route::controller(PageController::class)->group(function(){
        // Route Get
        Route::get('/stok-masuk', 'stokMasukIndex')->name('stok-masuk');
        Route::get('/stok-keluar', 'stokKeluarIndex')->name('stok-keluar');
        Route::get('/laporan', 'laporanIndex')->name('laporan');
        Route::get('/pengaturan', 'pengaturanIndex')->name('pengaturan');
        Route::get('/laporan/pdf', 'laporanPdf')->name('laporan.pdf');
        Route::get('/laporan/excel', 'laporanExcel')->name('laporan.excel');

        // Route Post
        Route::post('/stok-masuk/store', 'stokMasukStore')->name('stok-masuk.store');
        Route::post('/stok-keluar/store', 'stokKeluarStore')->name('stok-keluar.store');
        Route::put('/pengaturan/password', 'updatePassword')->name('pengaturan.password');
        Route::put('/pengaturan/profil', 'updateProfil')->name('pengaturan.profil');
    });     
});
