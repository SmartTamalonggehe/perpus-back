<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRUD\AnggotaController;
use App\Http\Controllers\CRUD\KatalogController;
use App\Http\Controllers\CRUD\ClassSubController;
use App\Http\Controllers\CRUD\ClassUmumController;
use App\Http\Controllers\CRUD\TransaksiController;

Route::resource('katalog', KatalogController::class);
Route::resource('anggota', AnggotaController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('classUmum', ClassUmumController::class);
Route::resource('classSub', ClassSubController::class);
