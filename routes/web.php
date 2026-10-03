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

// Data Pegawai (HR)
use App\Http\Controllers\PegawaiController;
Route::resource('pegawai', PegawaiController::class);

// Master Dokter
use App\Http\Controllers\DokterController;
Route::resource('dokter', DokterController::class);

// Master Perawat
use App\Http\Controllers\PerawatController;
Route::resource('perawat', PerawatController::class);

// Tempat Sampah
use App\Http\Controllers\SampahController;
Route::get('/sampah', [SampahController::class, 'index'])->name('sampah.index');
Route::post('/sampah/bulk/restore', [SampahController::class, 'restoreBulk'])->name('sampah.restoreBulk');
Route::delete('/sampah/bulk/force', [SampahController::class, 'forceDeleteBulk'])->name('sampah.forceDeleteBulk');
Route::post('/sampah/{type}/{id}/restore', [SampahController::class, 'restore'])->name('sampah.restore');
Route::delete('/sampah/{type}/{id}', [SampahController::class, 'forceDelete'])->name('sampah.forceDelete');

// Departemen
use App\Http\Controllers\DepartemenController;
Route::delete('departemen/bulk', [DepartemenController::class, 'destroyBulk'])->name('departemen.destroyBulk');
Route::resource('departemen', DepartemenController::class)->parameters([
    'departemen' => 'departemen'
]);

// Jabatan
use App\Http\Controllers\JabatanController;
Route::delete('jabatan/bulk', [JabatanController::class, 'destroyBulk'])->name('jabatan.destroyBulk');
Route::resource('jabatan', JabatanController::class)->parameters([
    'jabatan' => 'jabatan'
]);



