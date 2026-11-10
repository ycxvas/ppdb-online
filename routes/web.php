<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\PendaftarController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PendaftaranController::class, 'create'])->name('daftar');
Route::post('/daftar', [PendaftaranController::class, 'store'])->middleware('throttle:10,1')->name('daftar.store');
Route::get('/sukses', [PendaftaranController::class, 'sukses'])->name('sukses');
Route::get('/cek-status', [PendaftaranController::class, 'cekForm'])->name('cek');
Route::post('/cek-status', [PendaftaranController::class, 'cekHasil'])->middleware('throttle:20,1')->name('cek.hasil');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'form'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [PendaftarController::class, 'index'])->name('admin.index');
        Route::get('pendaftar/{pendaftar}', [PendaftarController::class, 'show'])->name('admin.show');
        Route::patch('pendaftar/{pendaftar}', [PendaftarController::class, 'update'])->name('admin.update');
        Route::get('pendaftar/{pendaftar}/dokumen', [PendaftarController::class, 'dokumen'])->name('admin.dokumen');
    });
});
