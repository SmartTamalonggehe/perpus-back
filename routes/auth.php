<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AUTH\AdminAuthController;

Route::post('login', [AdminAuthController::class, 'login']);
Route::middleware(['jwt_costume', 'ip_throttle'])->group(function () {
    Route::post('cek-token', [AdminAuthController::class, 'cekToken']);
    Route::post('logout', [AdminAuthController::class, 'logout']);
});
