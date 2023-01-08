<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TpembelianbarangController;
use App\Http\Controllers\TpembelianController;
use App\Http\Controllers\MbarangController;


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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();


Route::group(['middleware' => ['web']], function () {
    // Halaman Utama
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkRole:Admin,Kasir');
    // Halaman Utama

    Route::resource('/user', UserController::class)->middleware('checkRole:Admin');
    Route::resource('/dashboard', DashboardController::class)->only(['index'])->middleware('checkRole:Admin');
    // transaksi
    Route::resource('/transaksi-pembelian', TpembelianController::class)->only(['index', 'show'])->middleware('checkRole:Admin,Kasir');
    Route::resource('/transaksi-pembelian-barang', TpembelianbarangController::class)->middleware('checkRole:Admin,Kasir');
    // transaksi
    // master barang
    Route::resource('/master-barang', MbarangController::class)->middleware('checkRole:Admin,Kasir');
    // master barang
    // data PDF transaksi pembelian
    Route::get('/pdf-transaksi-pembelian', [TpembelianController::class, 'pdf'])->name('pdf-transaksi-pembelian')->middleware('checkRole:Admin,Kasir');
    // detail PDF transaksi pembelian
    Route::get('/pdf-transaksi-pembelian-detail/{id}', [TpembelianController::class, 'pdf_detail'])->name('pdf-transaksi-pembelian-detail')->middleware('checkRole:Admin,Kasir');
    // PDF Pada Master Barang
    Route::get('/pdf-master-barang', [MbarangController::class, 'pdf'])->name('pdf-master-barang')->middleware('checkRole:Admin');
    // show PDF Master barang
    Route::get('/pdf-master-barang-detail/{id}', [MbarangController::class, 'pdf_detail'])->name('pdf-master-barang-detail')->middleware('checkRole:Admin');
    // PDF pembelian barang
    Route::get('/pdf-transaksi-pembelian-barang', [TpembelianbarangController::class, 'pdf'])->name('pdf-transaksi-pembelian-barang')->middleware('checkRole:Admin,Kasir');
    // detail PDF pembelian barang
    Route::get('/pdf-transaksi-pembelian-barang-detail/{id}', [TpembelianbarangController::class, 'pdf_detail'])->name('pdf-transaksi-pembelian-barang-detail')->middleware('checkRole:Admin,Kasir');    
});
// });