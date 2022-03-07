<?php

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

Route::get('/', 'AuthController@index');

Route::post('login', 'AuthController@login')->name('login');

Route::get('logout', 'AuthController@logout')->name('logout');

Route::get('profile', 'modul\ProfileController@index')->name('profile');

Route::post('updatepicture/{id}', 'modul\ProfileController@updatepicture');

Route::post('updateprofile/{id}', 'modul\ProfileController@updateDataProfile');

Route::post('update-password', 'modul\ProfileController@changePassword');

Route::get('menu', 'modul\MenuController@index')->name('menu');

Route::get('menu/view/{id}', 'modul\MenuController@detailMenu');

Route::post('menu/save', 'modul\MenuController@store');

Route::get('menu/edit/{id}', 'modul\MenuController@edit');

Route::post('updatemenu/{id}', 'modul\MenuController@updatemenu');

Route::get('addMenu', 'modul\MenuController@addMenu');

Route::get('menu/delete/{id}', 'modul\MenuController@destroy');

Route::get('meja', 'modul\MejaController@index')->name('meja');

Route::get('addMeja', 'modul\MejaController@addMeja');

Route::post('meja/save', 'modul\MejaController@store');

Route::get('meja/delete/{id}', 'modul\MejaController@destroy');

Route::get('meja/edit/{id}', 'modul\MejaController@edit');

Route::post('updatemeja/{id}', 'modul\MejaController@updatemeja');

Route::get('role', 'modul\RoleController@index')->name('role');

Route::get('addRole', 'modul\RoleController@addRole');

Route::post('role/save', 'modul\RoleController@store');

Route::get('role/delete/{id}', 'modul\RoleController@destroy');

Route::get('role/edit/{id}', 'modul\RoleController@edit');

Route::post('updaterole/{id}', 'modul\RoleController@updaterole');

Route::get('category', 'modul\KategoriController@index')->name('category');

Route::get('addCategory', 'modul\KategoriController@addCategory');

Route::post('category/save', 'modul\KategoriController@store');

Route::post('pembayaran/save/{id_meja}', 'PembayaranController@store');

Route::post('pembayaran1/save/{id_meja}/{id}', 'PembayaranController@store2');

Route::get('category/delete/{id}', 'modul\KategoriController@destroy');

Route::get('category/edit/{id}', 'modul\KategoriController@edit');

Route::post('updatecategory/{id}', 'modul\KategoriController@updatecategory');

Route::resource('users', 'users\UserController');

Route::post('update-password/{id}', 'users\UserController@changePassword');

Route::get('laporanTransaksi', 'transaksi\TransaksiController@report')->name('category');

Route::post('laporantransaksipdf', 'transaksi\TransaksiController@cetakpdf');

Route::get('grafikMenuTerlaris', 'modul\ChartController@chartOrder');

Route::get('historyTransaksi', 'modul\HistoryController@index');

Route::get('users/view/{id}', 'users\UserController@detailUsers');

Route::get('transaksi/view/{id}', 'transaksi\TransaksiController@detailTransaksi');
Route::resource('pesanan', 'modul\PesananController');
Route::get('pesanan/view/{id}', 'modul\PesananController@detailTransaksi');
Route::post('pesanan/approve/{id}','modul\PesananController@approve')->name('pesanan.approve');
Route::post('pesanan/tolak/{id}','modul\PesananController@tolak')->name('pesanan.tolak');
Route::post('pesanan/selesai/{id}','modul\PesananController@selesai')->name('pesanan.selesai');
// Route::post('pesanan/deleted/{id}','modul\PesananController@deleted')->name('pesanan.deleted');
Route::post('cari','modul\PesananController@cari');


// Route::resource('transaksi_baru', 'transaksi\TransaksiBaruController');
// Route::post('transaksi_baru/approve/{id}','Transaksi\TransaksiBaruController@approve')->name('transaksi_baru.approve');
// Route::post('transaksi_baru/tolak/{id}','Transaksi\TransaksiBaruController@tolak')->name('transaksi_baru.tolak');
// Route::post('transaksi_baru/selesai/{id}','Transaksi\TransaksiBaruController@selesai')->name('transaksi_baru.selesai');
// Route::get('transaksi/view_meja/{idMeja}', 'transaksi\TransaksiNaruController@viewMeja');

Route::get('transaksi/cetak-struk/{id_meja}','PembayaranController@cetakStruk')->name('transaksi.cetak_struk');

Route::resource('transaksi', 'transaksi\TransaksiController');
// Route::get('transaksi', 'transaksi\TransaksiController@sudahbayar');
Route::post('transaksi/approve/{id}','Transaksi\TransaksiController@approve')->name('transaksi.approve');
Route::post('transaksi/tolak/{id}','Transaksi\TransaksiController@tolak')->name('transaksi.tolak');
Route::post('transaksi/selesai/{id}','Transaksi\TransaksiController@selesai')->name('transaksi.selesai');
// Route::post('transaksi/bayar/{id}','Transaksi\TransaksiController@bayar')->name('transaksi.bayar');
// Route::post('transaksi/deleted/{id}','Transaksi\TransaksiController@deleted')->name('transaksi.deleted');

Route::resource('historytransaksi', 'modul\HistoryController');
Route::post('historytransaksi/deleted/{id}','modul\HistoryController@destroy')->name('historytransaksi.deleted');
Route::get('users/delete/{id}', 'users\UserController@destroy');
Route::get('terlaris','Transaksi\TerlarisController@index')->name('menu.terlaris');
Route::post('cari','Transaksi\TransaksiController@cari');
Route::get('stok','modul\StokController@index');
Route::get('stok/edit/{id}', 'modul\StokController@edit');
Route::post('updatestok/{id}', 'modul\StokController@updatestok');
Route::get('transaksi/show/{id}','Transaksi\TransaksiController@show');
Route::post('laporanpenjualanexel', 'transaksi\TransaksiController@export_excel');

