<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PadukuhanController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DaftarKknController;
use App\Http\Controllers\DosenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');
Route::get('/home', [Controller::class, 'index']);

Route::middleware(['auth:sanctum', 'user-access:2', 'verified'])->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/add-users', [UserController::class, 'tambahUser'])->name('addUsers');
    Route::post('/edit-users', [UserController::class, 'editUser'])->name('editUsers');
    Route::post('/hapus-users', [UserController::class, 'hapusUser'])->name('hapusUsers');

    Route::get('/padukuhan/{kkn_id}', [PadukuhanController::class, 'tampil'])->name('padukuhan');
    Route::post('/add-padukuhans', [PadukuhanController::class, 'tambahPadukuhan'])->name('addPadukuhans');
    Route::post('/edit-padukuhans', [PadukuhanController::class, 'editPadukuhan'])->name('editPadukuhans');
    Route::post('/hapus-padukuhans', [PadukuhanController::class, 'hapusPadukuhan'])->name('hapusPadukuhans');

    Route::get('/kelompok/{padukuhan_id}', [KelompokController::class, 'tampil'])->name('kelompok');
    Route::post('/add-kelompoks', [KelompokController::class, 'tambahKelompok'])->name('addKelompoks');
    Route::post('/edit-kelompoks', [KelompokController::class, 'editKelompok'])->name('editKelompoks');
    Route::post('/hapus-kelompoks', [KelompokController::class, 'hapusKelompok'])->name('hapusKelompoks');
    Route::get('/search-user', [KelompokController::class, 'searchSiswa'])->name('searchUsers');

    Route::get('/kkn-reguler', [DaftarKknController::class, 'indexKknReguler'])->name('kkn-reguler');
    Route::get('/kkn-tematik', [DaftarKknController::class, 'indexKknTematik'])->name('kkn-tematik');
    Route::post('/tambahKkn', [DaftarKknController::class, 'tambahKkn'])->name('tambahKkn');
    Route::get('/kkn', [DaftarKknController::class, 'index'])->name('kkn.index');
    Route::put('/kkn/{id}/update', [DaftarKknController::class, 'update'])->name('kkn.update');
    Route::delete('/kkn/{id}', [DaftarKknController::class, 'destroy'])->name('kkn.destroy');
    Route::get('/kkn/tematik/{id}/edit', [DaftarKknController::class, 'edit'])->name('editKknTematik');
    // Route to update a KKN record (for tematik or reguler)
    Route::put('/kkn/tematik/{id}/update', [DaftarKknController::class, 'update'])->name('kkn.update');
    Route::put('/kkn/tematik/{id}/update', [DaftarKknController::class, 'update'])->name('editKknTematik');
    Route::delete('/kkn/tematik/{id}/delete', [DaftarKknController::class, 'destroy'])->name('deleteKknTematik');
    Route::get('/tematik', [DaftarKknController::class, 'index'])->name('tematik.index');
    Route::delete('/kkn/{id}', [DaftarKknController::class, 'delete'])->name('kkn.destroy');


});

Route::middleware(['auth:sanctum', 'user-access:1', 'verified'])->group(function () {
    Route::get('/cekLaporan', [LaporanController::class, 'cekLaporan'])->name('cekLaporan');
    Route::get('/cekLogbook', [DosenController::class, 'logbookIndex'])->name('cekLogbook');
    Route::get('/tolakLaporan', [LaporanController::class, 'tolakLaporan'])->name('tolakLaporan');
    Route::get('/viewLogbook/{id}', [DosenController::class, 'viewLogbook'])->name('viewLogbook');
    Route::post('/logbook/{id}/accept', [DosenController::class, 'acceptLogbook'])->name('logbook.accept');
    Route::post('/logbook/{id}/reject', [DosenController::class, 'rejectLogbook'])->name('logbook.reject');

    Route::post('/laporan/accept/{id}', [LaporanController::class, 'cekLaporan'])->name('acceptLaporan');
    Route::post('/laporan/reject/{id}', [LaporanController::class, 'reject'])->name('rejectLaporan');
    Route::post('/laporan/upload', [LaporanController::class, 'store'])->name('uploadLaporan');
    Route::put('/laporan/update/{id}', [LaporanController::class, 'update'])->name('updateLaporan');
     Route::post('/laporan/{id}/reject', [LaporanController::class, 'reject'])->name('laporan.reject');
  
 
});

Route::middleware(['auth:sanctum', 'user-access:0', 'verified'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan');
    Route::post('/uploadLaporan', [LaporanController::class, 'uploadLaporan'])->name('uploadLaporan');
    Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook');
    Route::post('/addLogbook', [LogbookController::class, 'addLogbook'])->name('addLogbook');
    Route::post('/editLogbook', [LogbookController::class, 'editLogbook'])->name('editLogbook');
    Route::post('/hapusLogbook', [LogbookController::class, 'hapusLogbook'])->name('hapusLogbook');
    Route::delete('/deleteLaporan/{id}', [LaporanController::class, 'deleteLaporan'])->name('deleteLaporan');
    Route::put('/laporan/update/{id}', [LaporanController::class, 'update'])->name('updateLaporan');
   


});
Route::post('/viewLaporan', [LaporanController::class, 'viewLaporan'])->name('viewLaporan');




