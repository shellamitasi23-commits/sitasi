<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// route web

Route::get('/', function () {
    return redirect()->route('login');
});

// auth

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// protected routes

Route::middleware(['auth'])->group(function () {

   //dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    //laporan

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/export', [LaporanController::class, 'export'])
        ->name('laporan.export');

    //kelas

    Route::get('/kelas', [KelasController::class, 'index'])
        ->name('kelas.index');

    //siswa

    Route::get('/siswa', [SiswaController::class, 'index'])
        ->name('siswa.index');

    Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])
        ->name('siswa.show')
        ->whereNumber('siswa');

    //transaksi

    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('transaksi.index');

    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])
        ->name('transaksi.show')
        ->whereNumber('transaksi');

    //CRUD bendahara

    Route::middleware(['role:bendahara'])->group(function () {

        //CRUD kelas

        Route::get('/kelas/create', [KelasController::class, 'create'])
            ->name('kelas.create');

        Route::post('/kelas', [KelasController::class, 'store'])
            ->name('kelas.store');

        Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit'])
            ->name('kelas.edit');

        Route::put('/kelas/{kelas}', [KelasController::class, 'update'])
            ->name('kelas.update');

        Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])
            ->name('kelas.destroy');

        //CRUD siswa

        Route::get('/siswa/create', [SiswaController::class, 'create'])
            ->name('siswa.create');

        Route::post('/siswa', [SiswaController::class, 'store'])
            ->name('siswa.store');

        Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])
            ->name('siswa.edit');

        Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])
            ->name('siswa.update');

        Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])
            ->name('siswa.destroy');

        //CRUD transaksi

        Route::get('/transaksi/create', [TransaksiController::class, 'create'])
            ->name('transaksi.create');

        Route::post('/transaksi', [TransaksiController::class, 'store'])
            ->name('transaksi.store');

        Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])
            ->name('transaksi.edit');

        Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])
            ->name('transaksi.update');

        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])
            ->name('transaksi.destroy');
    });
});