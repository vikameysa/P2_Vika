<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\KlinikController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\AntrianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dokter/dashboard', function () {
    return view('Dokter.dashboard');
})->name('Dokter.dashboard');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Untuk Dokter
Route::get('/Dokter', [DokterController::class, 'index'])->name('Dokter.dokter');
route::get('/Dokter/create', [DokterController::class, 'create'])->name('Dokter.create');
route::get('/Dokter/edit/{id}', [DokterController::class, 'edit'])->name('Dokter.edit');
route::put('/Dokter/update/{id}', [DokterController::class, 'update'])->name('Dokter.update');
route::post('/Dokter/store', [DokterController::class, 'store'])->name('Dokter.store');
route::delete('/Dokter/{id}', [DokterController::class, 'destroy'])->name('Dokter.destroy');

// Pasien
Route::get('/Pasien', [PasienController::class, 'index'])->name('Pasien.pasien');
route::get('/Pasien/create', [PasienController::class, 'create'])->name('Pasien.create');
Route::get('/Pasien/edit/{id}', [PasienController::class, 'edit'])
    ->name('Pasien.edit');
Route::post('/pasien/antrian/{kode_pasien}', [PasienController::class, 'masukAntrian'])->name('Pasien.antrian');
route::put('/Pasien/update/{id}', [PasienController::class, 'update'])->name('Pasien.update');
route::post('/Pasien/store', [PasienController::class, 'store'])->name('Pasien.store');
route::delete('/Pasien/{id}', [PasienController::class, 'destroy'])->name('Pasien.destroy');

//untuk Obat
Route::get('/Obat', [ObatController::class, 'obat'])->name('Obat.obat');
Route::get('/Obat/create', [ObatController::class, 'create'])->name('Obat.create');
Route::get('/Obat/edit/{id}', [ObatController::class, 'show'])->name('Obat.show');
Route::post('/Obat/store', [ObatController::class, 'store'])->name('Obat.store');
Route::delete('/Obat/{id}', [ObatController::class, 'destroy'])->name('Obat.destroy');

//untuk Rumah
Route::get('/Rumah', [RumahController::class, 'rumah'])->name('Rumah.rumah');
Route::get('/Rumah/create', [RumahController::class, 'create'])->name('Rumah.create');
Route::get('/Rumah/edit/{id}', [RumahController::class, 'show'])->name('Rumah.show');
Route::post('/Rumah/store', [RumahController::class, 'store'])->name('Rumah.store');
Route::delete('/Rumah/{id}', [RumahController::class, 'destroy'])->name('Rumah.destroy');

// Untuk Farmasi
Route::get('/Farmasi', [FarmasiController::class, 'index'])->name('Farmasi.farmasi');
route::get('/Farmasi/create', [FarmasiController::class, 'create'])->name('Farmasi.create');
route::get('/Farmasi/edit/{id}', [FarmasiController::class, 'edit'])->name('Farmasi.edit');
route::put('/Farmasi/update/{id}', [FarmasiController::class, 'update'])->name('Farmasi.update');
route::post('/Farmasi/store', [FarmasiController::class, 'store'])->name('Farmasi.store');
route::delete('/Farmasi/{id}', [FarmasiController::class, 'destroy'])->name('Farmasi.destroy');

// Untuk Antrian
Route::get('/antrian', [AntrianController::class, 'index'])
    ->name('Antrian.antrian');
Route::post('/antrian/store', [AntrianController::class, 'store'])->name('Antrian.store');
Route::get('/antrian/{id}/periksa', [AntrianController::class, 'periksa'])
    ->name('antrian.periksa');
Route::get('/antrian/{id}/form', [AntrianController::class, 'form'])
    ->name('Antrian.form');

    //Untuk Poli
Route::get('/Poli', [PoliController::class, 'poli'])->name('Poli.poli');
Route::get('/Poli/create', [PoliController::class, 'create'])->name('Poli.create');
Route::post('/Poli/store', [PoliController::class, 'store'])->name('Poli.store');
Route::delete('/Poli/{id}', [PoliController::class, 'destroy'])->name('Poli.destroy');

// Untuk Klinik
Route::get('Klinik', [KlinikController::class, 'index'])->name('Klinik.klinik');
Route::get('Klinik/formklinik/{kode_pasien}', [KlinikController::class, 'form'])->name('Klinik.formklinik');
Route::post('Klinik/formklinik/{kode_pasien}', [KlinikController::class, 'simpan'])->name('Klinik.simpan');
Route::put(
    '/klinik/update-semua/{kode_pasien}',
    [KlinikController::class, 'updateSemua']
)->name('Klinik.updateSemua');
Route::post(
    '/klinik/selesai/{kode_pasien}',
    [KlinikController::class, 'selesai']
)->name('Klinik.selesai');

//Untuk Riwayat
Route::get('/Riwayat', [RiwayatController::class, 'index'])->name('Riwayat.riwayat');
Route::get('/Riwayat/detail/{id}', [RiwayatController::class, 'detail']);
Route::get('/Riwayat/print/{id}', [RiwayatController::class, 'print'])
    ->name('Riwayat.print');

require __DIR__ . '/auth.php';
