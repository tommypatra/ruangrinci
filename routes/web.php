<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WebController::class, 'masuk'])->name('akun-masuk')->middleware('guest');
Route::get('/akun-daftar', [WebController::class, 'mendaftar'])->name('akun-daftar')->middleware('guest');
Route::post('/akun-set-session', [WebController::class, 'setSession'])->name('akun-set-session');



Route::group(['middleware' => 'auth'], function () {

    Route::get('/akun-dashboard', [WebController::class, 'dashboard'])->name('akun-dashboard');
    Route::get('/akun-keluar-api', [AuthController::class, 'keluar'])->name('akun-keluar-api');
    Route::get('/akun-daftar-akses', [WebController::class, 'daftarAkses'])->name('akun-daftar-akses');
    Route::get('/akun-set-akses/{grup_id}', [WebController::class, 'setAkses'])->name('akun-set-akses');

    Route::get('/detail-peminjaman-ruangan/{id}/{id_pemberitahuan}', [WebController::class, 'detailPinjamRuangan']);
    Route::get('/detail-peminjaman-barang/{id}/{id_pemberitahuan}', [WebController::class, 'detailPinjamAset']);
    Route::get('/detail-laporan-kerusakan/{id}/{id_pemberitahuan}', [WebController::class, 'detailLaporan']);

    Route::get('/profil', [WebController::class, 'profil'])->name('profil');
    Route::get('/grup', [WebController::class, 'grup'])->name('grup');
    Route::get('/pengguna', [WebController::class, 'pengguna'])->name('pengguna');
    Route::get('/gedung', [WebController::class, 'gedung'])->name('gedung');
    Route::get('/ruangan', [WebController::class, 'ruangan'])->name('ruangan');
    Route::get('/jenis-aset', [WebController::class, 'jenisAset'])->name('jenis-aset');
    Route::get('/data-aset', [WebController::class, 'dataAset'])->name('data-aset');
    Route::get('/pinjam-aset', [WebController::class, 'pinjamAset'])->name('pinjam-aset');
    Route::get('/pinjam-ruangan', [WebController::class, 'pinjamRuangan'])->name('pinjam-ruangan');
    Route::get('/pengguna-aset', [WebController::class, 'penggunaAset'])->name('pengguna-aset');
    Route::get('/pengajuan-laporan', [WebController::class, 'pengajuanLaporan'])->name('pengajuan-laporan');
    Route::get('/laporan', [WebController::class, 'laporan'])->name('laporan');
    Route::get('/perawatan', [WebController::class, 'perawatan'])->name('perawatan');
    Route::get('/pinjam-ruangan-validasi', [WebController::class, 'pinjamRuanganValidasi'])->name('pinjam-ruangan-validasi');
    Route::get('/pinjam-aset-validasi', [WebController::class, 'pinjamAsetValidasi'])->name('pinjam-aset-validasi');


    // Route::get('/send-event', function () {
    //     broadcast(new \App\Events\NotificationEvent(1, 'Tommy Patra', 'notif', 'coba cek dulu ini'));
    // });
});
