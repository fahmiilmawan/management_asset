<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\ScanQRController;
use App\Http\Controllers\SettingProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Livewire\AssetDetail;
use App\Livewire\SettingProfile;
use Illuminate\Support\Facades\Route;
use App\Exports\AssetTemplateExport;
use App\Exports\BarangTemplateExport;
use App\Exports\RuanganTemplateExport;
use App\Exports\UnitTemplateExport;
use Maatwebsite\Excel\Facades\Excel;


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
Route::get('/scan',[AssetController::class,'detailAsset'])->name('index.detail-asset');

Route::get('/pengaduan',[PengaduanController::class,'index'])->name('index.pengaduan');
Route::get('/pengadaan',[PengadaanController::class,'index'])->name('index.pengadaan');
Route::get('/scan-qr',[ScanQRController::class,'index'])->name('index.scanqr');
Route::get('/setting-profile',[SettingProfileController::class,'index'])->name('setting-profile');


Route::get('/user/send-wa/{id}',[UserController::class,'sendWhatsappMessage'])->name('sendWhatsapp');
Route::get('/laporan-asset',[LaporanController::class,'indexLaporanAsset'])->name('index.laporan-asset');
Route::get('/laporan-pengadaan',[LaporanController::class,'indexLaporanPengadaan'])->name('index.laporan-pengadaan');
Route::get('/laporan-pengaduan',[LaporanController::class,'indexLaporanPengaduan'])->name('index.laporan-pengaduan');

Route::get('/print-qr-code',[AssetController::class,'generatePrintQRCode'])->name('print.qr-code');
Route::get('/print-laporan-asset',[LaporanController::class,'generatePrintPDFAsset'])->name('print.laporan-asset');
Route::get('/print-laporan-pengadaan',[LaporanController::class,'generatePrintPDFPengadaan'])->name('print.laporan-pengadaan');
Route::get('/print-laporan-pengaduan',[LaporanController::class,'generatePrintPDFPengaduan'])->name('print.laporan-pengaduan');

Route::get('/export-laporan-asset',[LaporanController::class,'exportExcelAsset'])->name('export.laporan-asset');
Route::get('/export-laporan-pengadaan',[LaporanController::class,'exportExcelPengadaan'])->name('export.laporan-pengadaan');
Route::get('/export-laporan-pengaduan',[LaporanController::class,'exportExcelPengaduan'])->name('export.laporan-pengaduan');

Route::get('/export-template-barang',function(){
    return Excel::download(new BarangTemplateExport, 'template-import-barang.xlsx');
})->name('export.template-barang');

Route::get('/export-template-ruangan',function(){
    return Excel::download(new RuanganTemplateExport, 'template-import-ruangan.xlsx');
})->name('export.template-ruangan');

Route::get('/export-template-unit',function(){
    return Excel::download(new UnitTemplateExport, 'template-import-unit.xlsx');
})->name('export.template-unit');










