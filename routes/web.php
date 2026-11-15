<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SapaController;
use Illuminate\Support\Facades\Route;

// Modul 6 - 9: Halaman utama & navigasi
Route::get('/', function () {
    return view('pages.beranda');
});

Route::get('/about', function () {
    return view('pages.about', [
        'nama'   => 'Sendy Prayogo',
        'kelas'  => 'TSM-00',
        'nim'    => '0123456789',
        'status' => 'Aktif',
    ]);
});

Route::view('/contact', 'pages.contact');

// Modul 7 - 10: Product (Controller, Eloquent, Pagination, Validasi, Insert, Detail, Update, Delete)
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/addProduct', [ProductController::class, 'addProduct']);
Route::post('/product', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

// Modul 10: Resource Controller Category
Route::resource('/category', \App\Http\Controllers\CategoryController::class);

// Modul 3 & Modul 4: Route latihan dasar (/hello, /home, /profil, /profil2, /profile)
Route::get('/hello', function () {
    return 'Hello Laravel dari nim 0123456789';
});

Route::get('/home', function () {
    return view('pages.home', [
        'nim' => '0123456789',
    ]);
});

Route::get('/profil', function () {
    return view('pages.profil');
});

Route::get('/profil2', function () {
    return view('pages.profil', [
        'nama'  => 'Nama Mahasiswa',
        'nim'   => '0123456789',
        'kelas' => 'TRM-00',
        'prodi' => 'Teknologi Rekayasa Multimedia',
    ]);
});

Route::get('/profile', function () {
    return view('pages.profile', [
        'nama'   => 'Nama Mahasiswa',
        'nim'    => '0123456789',
        'kelas'  => 'TRM-00',
        'prodi'  => 'Teknologi Rekayasa Multimedia',
        'status' => 'Aktif',
    ]);
});

// Modul 6: Latihan Pemanasan Daftar Mata Kuliah
Route::get('/latihan', function () {
    $matakuliah = ['Pemrograman Web', 'Basis Data', 'UI/UX'];
    return view('pages.latihan', ['matakuliah' => $matakuliah]);
});

// Modul 7: Latihan SapaController & MahasiswaController
Route::get('/sapa', [SapaController::class, 'index']);
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
