<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\CetakNotaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\HistoryBarangController;
use App\Http\Controllers\LabaRugiController;
use App\Http\Controllers\LabaRugiTableController;

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

Route::get('/laporanstok', [LaporanStokController::class, 'index'])->name('laporanstok.index');

Route::get('/labarugi', [LabaRugiController::class, 'index'])->name('labarugi.index');
Route::get('/labarugitable', [LabaRugiTableController::class, 'hasil'])->name('labarugitable.hasil');
Route::get('/labarugi/export-excell', [LabaRugiController::class, 'exportExcell'])->name('labarugi.exportexcell');

Route::get('/backup', [BackupController::class, 'index']);
Route::get('/download-backup/{name}', [BackupController::class, 'downloadBackup'])
    ->name('download.backup');
Route::post('/backup/dbonly', [BackupController::class, 'runBackupDbOnly'])
    ->name('backup.dbonly');
Route::post('/backup/full', [BackupController::class, 'runBackupFull'])
    ->name('backup.full');
Route::delete('/delete-backup/{name}', [BackupController::class, 'deleteBackup'])
    ->name('delete.backup');


Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier.index');
Route::get('/suplier/create', [SuplierController::class, 'create'])->name('suplier.create');
Route::post('/suplier', [SuplierController::class, 'store'])->name('suplier.store');
Route::get('/suplier/{id}/edit', [SuplierController::class, 'edit'])->name('suplier.edit');
Route::put('/suplier/{id}', [SuplierController::class, 'update'])->name('suplier.update');
Route::delete('/suplier/{id}', [SuplierController::class, 'destroy'])->name('suplier.destroy');

Route::get('/historybarang', [HistoryBarangController::class, 'index'])->name('historybarang.index');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/kategoribarang', [KategoriBarangController::class, 'index'])->name('kategoribarang.index');
Route::get('/kategoribarang/create', [KategoriBarangController::class, 'create'])->name('kategoribarang.create');
Route::post('/kategoribarang', [KategoriBarangController::class, 'store'])->name('kategoribarang.store');
Route::get('/kategoribarang/{id}/edit', [KategoriBarangController::class, 'edit'])->name('kategoribarang.edit');
Route::put('/kategoribarang/{id}', [KategoriBarangController::class, 'update'])->name('kategoribarang.update');
Route::delete('/kategoribarang/{id}', [KategoriBarangController::class, 'destroy'])->name('kategoribarang.destroy');

Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
Route::put('/penjualan/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

Route::get('/returpenjualan', [ReturPenjualanController::class, 'index'])->name('returpenjualan.index');
Route::post('/returpenjualan/{inv}', [ReturPenjualanController::class, 'copyto'])->name('returpenjualan.copyto');


Route::delete('/hapus-item-penjualan/{barangId}', [PenjualanController::class, 'hapusItemPenjualan'])->name('hapusdetailpenjualan.destroy');

Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');

Route::get('/hutang', [HutangController::class, 'index'])->name('hutang.index');
Route::get('/hutang/{id}', [HutangController::class, 'update'])->name('hutang.update');

Route::get('/piutang', [PiutangController::class, 'index'])->name('piutang.index');
Route::get('/piutang/{id}', [PiutangController::class, 'update'])->name('piutang.update');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/{id}', [HomeController::class, 'show'])->name('home.show');
Route::post('/', [HomeController::class, 'store'])->name('home.store');

Route::get('cetaknota1/{id}', [CetakNotaController::class, 'nota1'])->name('cetaknota1.nota1');
Route::get('cetaknota2/{id}', [CetakNotaController::class, 'nota2'])->name('cetaknota2.nota2');
Route::get('cetaknota3/{id}', [CetakNotaController::class, 'nota3'])->name('cetaknota3.nota3');

Route::get('/laporan/hutang', [LaporanController::class, 'hutang'])->name('laporan.hutang');
Route::get('/laporan/piutang', [LaporanController::class, 'piutang'])->name('laporan.piutang');