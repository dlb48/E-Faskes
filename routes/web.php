<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PasienController;

// Dashboard / Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Pendaftaran / Antrean
Route::get('/antrean', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::get('/antrean/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/antrean', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Pasien
Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
Route::get('/pasien/{id}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

// Poliklinik
use App\Http\Controllers\PoliklinikController;
Route::resource('poliklinik', PoliklinikController::class);

// Tenaga Medis
use App\Http\Controllers\TenagaMedisController;
Route::resource('tenaga-medis', TenagaMedisController::class);
