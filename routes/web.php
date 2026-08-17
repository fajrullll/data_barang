<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return view('welcome');
});

// Route CRUD Barang
Route::resource('barang', BarangController::class);

// Route CRUD Kategori
Route::resource('kategori', KategoriController::class);