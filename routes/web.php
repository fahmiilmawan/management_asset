<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Livewire\AssetDetail;
use Illuminate\Support\Facades\Route;


// Route Login
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('/barang',[BarangController::class,'index'])->name('index.barang');
Route::get('/ruangan',[RuanganController::class,'index'])->name('index.ruangan');
Route::get('/unit',[UnitController::class,'index'])->name('index.unit');
Route::get('/user',[UserController::class,'index'])->name('index.user');
Route::get('/asset',[AssetController::class,'index'])->name('index.asset');
Route::get('/pengaduan',[PengaduanController::class,'index'])->name('index.pengaduan');


Route::get('/user/send-wa/{id}',[UserController::class,'sendWhatsappMessage'])->name('sendWhatsapp');








