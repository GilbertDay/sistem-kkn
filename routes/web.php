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

    Route::get('/padukuhan', [PadukuhanController::class, 'index'])->name('padukuhan');
    Route::post('/add-padukuhans', [PadukuhanController::class, 'tambahPadukuhan'])->name('addPadukuhans');
    Route::post('/edit-padukuhans', [PadukuhanController::class, 'editPadukuhan'])->name('editPadukuhans');
    Route::post('/hapus-padukuhans', [PadukuhanController::class, 'hapusPadukuhan'])->name('hapusPadukuhans');

    Route::get('/kelompok', [KelompokController::class, 'index'])->name('kelompok');
    Route::post('/add-kelompoks', [KelompokController::class, 'tambahKelompok'])->name('addKelompoks');
    Route::post('/edit-kelompoks', [KelompokController::class, 'editKelompok'])->name('editKelompoks');
    Route::post('/hapus-kelompoks', [KelompokController::class, 'hapusKelompok'])->name('hapusKelompoks');
    Route::get('/search-user', [KelompokController::class, 'searchSiswa'])->name('searchUsers');

});

Route::middleware(['auth:sanctum', 'user-access:1', 'verified'])->group(function () {
    Route::get('/cekLaporan', [LaporanController::class, 'cekLaporan'])->name('cekLaporan');
    Route::get('/cekLogbook', [LaporanController::class, 'cekLogbook'])->name('cekLogbook');
    Route::get('/tolakLaporan', [LaporanController::class, 'tolakLaporan'])->name('tolakLaporan');

});

Route::middleware(['auth:sanctum', 'user-access:0', 'verified'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan');
    Route::post('/uploadLaporan', [LaporanController::class, 'uploadLaporan'])->name('uploadLaporan');
    Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook');
    Route::post('/adddLogbook', [LogbookController::class, 'adddLogbook'])->name('addLogbook');
    Route::post('/editLogbook', [LogbookController::class, 'editLogbook'])->name('editLogbook');
    Route::post('/hapusLogbook', [LogbookController::class, 'hapusLogbook'])->name('hapusLogbook');
});
Route::post('/viewLaporan', [LaporanController::class, 'viewLaporan'])->name('viewLaporan');

