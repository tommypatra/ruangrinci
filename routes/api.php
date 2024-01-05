<?php

use Illuminate\Http\Request;
use App\Models\Pemberitahuan;
use App\Models\UploadLaporan;
use App\Models\SerahTerimaAset;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GrupController;
use App\Http\Controllers\Api\GedungController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\RuanganController;
use App\Http\Controllers\Api\DataAsetController;
use App\Http\Controllers\Api\GrupUserController;
use App\Http\Controllers\Api\PenggunaController;
use App\Http\Controllers\Api\JenisAsetController;
use App\Http\Controllers\Api\PerawatanController;
use App\Http\Controllers\Api\PinjamAsetController;
use App\Http\Controllers\Api\AsetRuanganController;
use App\Http\Controllers\Api\PenggunaAsetController;
use App\Http\Controllers\Api\PemberitahuanController;
use App\Http\Controllers\Api\PinjamRuanganController;
use App\Http\Controllers\Api\UploadLaporanController;
use App\Http\Controllers\Api\SerahTerimaAsetController;
use App\Http\Controllers\Api\UploadPerawatanController;
use App\Http\Controllers\Api\RincianPerawatanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth-login', [AuthController::class, 'login'])->name('auth-login');

Route::middleware(['auth:sanctum'])->group(function () {
    // dd(auth('sanctum'));

    Route::resource('grup', GrupController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('gedung', GedungController::class);
    Route::resource('ruangan', RuanganController::class);
    Route::resource('grup-user', GrupUserController::class);
    Route::resource('jenis-aset', JenisAsetController::class);
    Route::resource('data-aset', DataAsetController::class);
    Route::resource('aset-ruangan', AsetRuanganController::class);
    Route::resource('pengguna-aset', PenggunaAsetController::class);
    Route::resource('serah-terima-aset', SerahTerimaAsetController::class);
    Route::resource('laporan', LaporanController::class);
    Route::post('/laporan-ajukan', [LaporanController::class, 'ajukan']);
    Route::post('/pinjam-aset-ajukan', [PinjamAsetController::class, 'ajukan']);
    Route::post('/pinjam-ruangan-ajukan', [PinjamRuanganController::class, 'ajukan']);

    Route::resource('upload-laporan', UploadLaporanController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('upload', UploadController::class);
    Route::resource('perawatan', PerawatanController::class);
    Route::resource('rincian-perawatan', RincianPerawatanController::class);
    Route::resource('upload-perawatan', UploadPerawatanController::class);
    Route::resource('pinjam-aset', PinjamAsetController::class);
    Route::resource('pinjam-ruangan', PinjamRuanganController::class);
    Route::resource('pemberitahuan', PemberitahuanController::class);


    //--------------- general function diluar crud masing masing controller -------------------
    Route::get('/asetBelumTerdistribusi', [GeneralController::class, 'asetBelumTerdistribusi']);
    Route::post('/notifikasi-user', [GeneralController::class, 'notifikasiUser']);
});
