<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\General;
use App\Http\Controllers\Home;
use App\Http\Controllers\Kasir;
use App\Http\Controllers\Penilai;
use App\Http\Controllers\Pimpinan;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

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



Route::post('/postlogin', [LoginController::class, 'postLogin']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/', [Home::class, 'home']);


Route::get('/tentang_aplikasi', [Home::class, 'tentangAplikasi']);


Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
});

// GENERAL CONTROLLER ROUTE
Route::group(['middleware' => ['auth', 'ceklevel:Administrator,kasir,pimpinan']], function () {

    Route::get('/dashboard', [General::class, 'dashboard']);
    Route::get('/profile', [General::class, 'profile']);
    Route::get('/bantuan', [General::class, 'bantuan']);

    Route::post('/ubah_foto_profile', [General::class, 'ubahFotoProfile']);
    Route::post('/ubah_role', [General::class, 'ubahRole']);
});

// ADMIN ROUTE
Route::group(['middleware' => ['auth', 'ceklevel:user']], function () {
});


// ADMIN ROUTE
Route::group(['middleware' => ['auth', 'ceklevel:Administrator']], function () {
    Route::group(['prefix' => 'admin'], function () {
        // GET REQUEST

        Route::get('/pengguna', [Admin::class, 'pengguna']);
        Route::get('/fetch_data', [Admin::class, 'fetchData']);
        Route::get('/fetch_data_pembelian', [Admin::class, 'fetchDataPembelian']);

        Route::post('/search_barang', [Admin::class, 'searchBarang']);
        Route::post('/get_all_barang', [Admin::class, 'getAllBarang']);
        Route::post('/save_penyesuaian_barang', [Admin::class, 'savePenyesuaianBarang']);


        // CRUD PENGGUNA
        Route::post('/create_pengguna', [Admin::class, 'createPengguna']);
        Route::post('/update_pengguna', [Admin::class, 'updatePengguna']);
        Route::post('/delete_pengguna', [Admin::class, 'deletePengguna']);

        // CRUD PELANGGAN
        Route::get('/pelanggan', [Admin::class, 'pelanggan']);
        Route::post('/create_pelanggan', [Admin::class, 'createPelanggan']);
        Route::post('/update_pelanggan', [Admin::class, 'updatePelanggan']);
        Route::post('/delete_pelanggan', [Admin::class, 'deletePelanggan']);

        // CRUD JENIS LAYANAN
        Route::get('/jenis_layanan', [Admin::class, 'jenisLayanan']);
        Route::post('/create_jenis_layanan', [Admin::class, 'createJenisLayanan']);
        Route::post('/update_jenis_layanan', [Admin::class, 'updateJenisLayanan']);
        Route::post('/delete_jenis_layanan', [Admin::class, 'deleteJenisLayanan']);

        // CRUD SATUAN
        Route::get('/satuan', [Admin::class, 'satuan']);
        Route::post('/create_satuan', [Admin::class, 'createSatuan']);
        Route::post('/update_satuan', [Admin::class, 'updateSatuan']);
        Route::post('/delete_satuan', [Admin::class, 'deleteSatuan']);

        // CRUD PEMBELIAN
        Route::get('/pembelian', [Admin::class, 'pembelian']);
        Route::post('/create_pembelian', [Admin::class, 'createPembelian']);
        Route::post('/update_pembelian', [Admin::class, 'updatePembelian']);
        Route::post('/delete_pembelian', [Admin::class, 'deletePembelian']);

        // PENYESUAIAN STOK
        Route::get('/penyesuaian_stok', [Admin::class, 'penyesuaianStok']);
        Route::get('/stok_dibawah_minimum', [Admin::class, 'stokDibawahMinimum']);
    });
});
// ADMIN ROUTE
Route::group(['middleware' => ['auth', 'ceklevel:kasir']], function () {
    Route::group(['prefix' => 'kasir'], function () {
        // GET REQUEST

        Route::get('/penjualan', [Kasir::class, 'penjualan']);
        Route::get('/data_kasir', [Kasir::class, 'dataKasir']);
        Route::get('/data_kasir/detail/{tgl}/{segment}', [Kasir::class, 'detailDataKasir']);
        Route::get('/data_kasir/edit/{tgl}/{segment}', [Kasir::class, 'editDataKasir']);
        Route::get('/data_penjualan', [Kasir::class, 'dataPenjualan']);
        Route::get('/data_penjualan/{tgl}', [Kasir::class, 'dataPenjualan']);
        Route::post('/get_all_barang', [Admin::class, 'getAllBarang']);

        Route::post('/save_penjualan_barang', [Kasir::class, 'savePenjualanBarang']);
        Route::post('/update_penjualan_barang', [Kasir::class, 'updatePenjualanBarang']);

        Route::get('/cetak_data_penjualan', [Kasir::class, 'cetakDataPenjualan']);
        Route::get('/cetak_data_penjualan/{tgl}', [Kasir::class, 'cetakDataPenjualan']);
    });
});


Route::group(['middleware' => ['auth', 'ceklevel:pimpinan']], function () {
    Route::group(['prefix' => 'pimpinan'], function () {
        Route::get("/data_penjualan", [Kasir::class, 'dataPenjualan']);
        Route::get("/grafik_pemasukan", [Pimpinan::class, 'grafikPemasukan']);
    });
});
