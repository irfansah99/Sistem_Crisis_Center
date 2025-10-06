<?php

use App\Events\BidPlaced;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardInstansiController;
use App\Http\Controllers\DashbordController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilAdmincontroller;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfilInstansicontroller;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Riwayat_admincontroller;
use App\Http\Controllers\Riwayatcontroller;
use App\Http\Controllers\RiwayatinstansiController;
use App\Http\Middleware\SudahLogin;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(SudahLogin::class)->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::resource('register', RegisterController::class);
});
route::post('logout', [LoginController::class, 'logout']);




Route::middleware(['auth:web'])->group(function () {
    Route::resource('beranda', BerandaController::class);
    Route::get('/riwayat', [Riwayatcontroller::class, 'index'])->name('riwayat.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
});

Route::middleware(['auth:admin'])->as('admin.')->prefix('admin')->group(function () {
    Route::resource('dashboard', DashbordController::class);
    Route::resource('histories', Riwayat_admincontroller::class);
    Route::resource('reports', ReportsController::class);
    Route::resource('reports', ReportsController::class);
    Route::get('profil/edit', [ProfilAdminController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [ProfilAdminController::class, 'update'])->name('profil.update');
});

Route::middleware(['auth:instansi'])->prefix('instansi')->as('instansi.')->group(function () {
    Route::resource('dashboard', DashboardInstansiController::class);
    Route::resource('histories', RiwayatinstansiController::class);
    Route::get('profil/edit', [ProfilInstansicontroller::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [ProfilInstansicontroller::class, 'update'])->name('profil.update');
});
