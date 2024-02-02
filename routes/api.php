<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProdiAPI;
use App\Http\Controllers\API\AnggotaAPI;
use App\Http\Controllers\API\KatalogAPI;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('prodi', [ProdiAPI::class, 'index']);

Route::prefix('anggota')->group(function () {
    Route::get('/', [AnggotaAPI::class, 'index']);
    Route::get('/all', [AnggotaAPI::class, 'all']);
});

Route::prefix('katalog')->group(function () {
    Route::get('/', [KatalogAPI::class, 'index']);
    Route::get('/all', [KatalogAPI::class, 'all']);
    Route::get('/ready', [KatalogAPI::class, 'ready']);
    Route::get('/detail/{id}', [KatalogAPI::class, 'detail']);
});
