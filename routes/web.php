<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Halaman tambah kegiatan (form create)
Route::get('add', [KegiatanController::class, 'create'])
    ->name('add')
    ->middleware('auth');

// Halaman manajemen kegiatan
Route::get('activity', [KegiatanController::class, 'index'])
    ->name('activity')
    ->middleware('auth');

// Route tambahan untuk hapus banyak kegiatan
Route::delete('kegiatans/delete-multiple', [KegiatanController::class, 'destroyMultiple'])
    ->name('kegiatans.destroyMultiple')
    ->middleware('auth');

// CRUD kegiatan (store, edit, update, delete, show)
Route::resource('kegiatans', KegiatanController::class)->middleware('auth');

// Form Tambah Kegiatan
Route::get('add', [KegiatanController::class, 'create'])
    ->name('add')
    ->middleware('auth');

// Tambah/simpan Kegiatan
Route::post('kegiatan', [KegiatanController::class, 'store'])
    ->name('kegiatan.store')
    ->middleware('auth');

// Riwayat Kegiatan
Route::get('/kegiatan/riwayat', [KegiatanController::class, 'riwayat'])
    ->name('kegiatans.riwayat')
    ->middleware('auth');

Route::get('/kegiatan/riwayat/export/pdf', [KegiatanController::class, 'exportPdf'])
    ->name('kegiatans.export.pdf')
    ->middleware('auth');


