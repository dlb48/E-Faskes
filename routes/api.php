<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JknAntreanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint Bridging BPJS (Mobile JKN)
Route::middleware(['bpjs.auth'])->prefix('jkn/antrean')->group(function () {
    Route::get('/status/{kodepoli}/{tanggalperiksa}', [JknAntreanController::class, 'statusAntrean']);
    Route::post('/ambil', [JknAntreanController::class, 'ambilAntrean']);
    Route::post('/batal', [JknAntreanController::class, 'batalAntrean']);
});
