<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TpembelianbarangController;


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
    Route::resource('/transaksi-pembelian-barang', TpembelianbarangController::class)->middleware('checkRole:Admin,Kasir');
    // transaksi
});
// });