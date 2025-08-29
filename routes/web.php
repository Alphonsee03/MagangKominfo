<?php

use App\Http\Controllers\KategotiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SupplierController;

use App\Http\Controllers\Kasir\POSController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\TransaksiController;
use App\Http\Controllers\Kasir\CartController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'submit'])->name('login.submit');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'submitregister'])->name('register.submit');
Route::get('/autherror', [AuthController::class, 'autherror'])->name('autherror');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/users', UserController::class);
    Route::resource('produks', AdminProdukController::class);
    Route::post('produks/{produk}/update-stok', [AdminProdukController::class, 'updateStok'])->name('produks.updateStok');
    Route::resource('/kategoris', KategoriController::class);
    Route::resource('/suppliers', SupplierController::class);


});

Route::middleware('auth:kasir')->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/transaksi', [POSController::class, 'index'])->name('transaksi.index');

    Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQty'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/cart/reset', [CartController::class, 'resetCart'])->name('cart.reset');
    Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');

    // Transaksi
    Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
    Route::post('/cancel/{id}', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::get('/transaksi/{id}/invoice', [TransaksiController::class, 'invoice'])->name('transaksi.invoice'); //yang baru kamu buat


    Route::get('/transaksi/history/data', [TransaksiController::class, 'historyData'])->name('transaksi.history.data');

    Route::get('/transaksi/rekap/harian', [TransaksiController::class, 'rekapHarian'])->name('.transaksi.rekap.harian');

    Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'historyDetail'])->name('transaksi.history.detail');

    Route::get('/history', [TransaksiController::class, 'history'])->name('transaksi.history');
    Route::get('/laporan/harian', [TransaksiController::class, 'laporanHarian'])->name('laporan.harian');
});




Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
