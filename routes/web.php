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
Route::get('/pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
Route::put('/pendaftaran/{id}', [PendaftaranController::class, 'update'])->name('pendaftaran.update');
Route::delete('/pendaftaran/destroy', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

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
use App\Http\Controllers\JadwalDokterController;
Route::resource('dokter', DokterController::class);
    Route::delete('jadwal/destroyBulk', [JadwalDokterController::class, 'destroyBulk'])->name('jadwal.destroyBulk');
    Route::resource('jadwal', JadwalDokterController::class);

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






use App\Http\Controllers\PengaturanBpjsController;
// Pengaturan Bridging BPJS
Route::get('/pengaturan/bpjs', [PengaturanBpjsController::class, 'index'])->name('pengaturan.bpjs.index');
Route::post('/pengaturan/bpjs', [PengaturanBpjsController::class, 'store'])->name('pengaturan.bpjs.store');


use App\Http\Controllers\MappingBpjsController;
// Mapping BPJS
Route::get('/mapping/poli', [MappingBpjsController::class, 'mappingPoli'])->name('mapping.poli');
Route::get('/mapping/poli/create', [MappingBpjsController::class, 'createMappingPoli'])->name('mapping.poli.create');
Route::get('/mapping/poli/search-bpjs', [MappingBpjsController::class, 'searchBpjsPoli'])->name('mapping.poli.search');
    Route::post('/mapping/poli', [MappingBpjsController::class, 'storeMappingPoli'])->name('mapping.poli.store');
Route::get('/mapping/poli/{kode_poli}/edit', [MappingBpjsController::class, 'editMappingPoli'])->name('mapping.poli.edit');
Route::delete('/mapping/poli', [MappingBpjsController::class, 'destroyMappingPoli'])->name('mapping.poli.destroy');

Route::get('/mapping/dokter', [MappingBpjsController::class, 'mappingDokter'])->name('mapping.dokter');
Route::get('/mapping/dokter/create', [MappingBpjsController::class, 'createMappingDokter'])->name('mapping.dokter.create');
Route::get('/mapping/dokter/search-bpjs', [MappingBpjsController::class, 'searchBpjsDokter'])->name('mapping.dokter.search');
    Route::post('/mapping/dokter', [MappingBpjsController::class, 'storeMappingDokter'])->name('mapping.dokter.store');
Route::get('/mapping/dokter/{id_dokter}/edit', [MappingBpjsController::class, 'editMappingDokter'])->name('mapping.dokter.edit');
Route::delete('/mapping/dokter', [MappingBpjsController::class, 'destroyMappingDokter'])->name('mapping.dokter.destroy');











// Penjamin
use App\Http\Controllers\PenjaminController;
Route::delete('penjamin/bulk', [PenjaminController::class, 'destroyBulk'])->name('penjamin.destroyBulk');
Route::resource('penjamin', PenjaminController::class)->parameters([
    'penjamin' => 'penjamin'
]);


