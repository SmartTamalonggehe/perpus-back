<?php

use App\Http\Controllers\CRUD\AnggotaController;
use App\Http\Controllers\CRUD\KatalogController;
use App\Http\Controllers\CRUD\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::resource('katalog', KatalogController::class);
Route::resource('anggota', AnggotaController::class);
Route::resource('transaksi', TransaksiController::class);
