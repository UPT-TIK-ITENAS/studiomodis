<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    if (!auth()->user()) {
        return redirect()->to('/login');
    } else {
        return redirect()->to('/home');
    }
});

Auth::routes();
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/home', 'Admin\HomeController@index')->name('home');

    Route::get('/ruangan/list', 'Admin\RuanganController@list')->name('ruangan.list');
    Route::resource('ruangan', 'Admin\RuanganController');

    Route::get('/kategori/list', 'Admin\KategoriAlatController@list')->name('kategori.list');
    Route::resource('kategori', 'Admin\KategoriAlatController');

    Route::get('/alat/list', 'Admin\AlatController@list')->name('alat.list');
    Route::resource('alat', 'Admin\AlatController');
});

Route::name('user.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/home', 'User\HomeController@index')->name('home');
    Route::get('/check-ruangan', 'User\Peminjaman\RuanganController@checkRuangan')->name('check.ruangan');

    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/alat', 'User\Peminjaman\AlatController@index')->name('alat.index');

        Route::get('/ruangan/list', 'User\Peminjaman\RuanganController@list')->name('ruangan.list');
        Route::get('/ruangan/alat', 'User\Peminjaman\RuanganController@alat')->name('ruangan.alat');
        Route::get('/ruangan/alat_show/{id}', 'User\Peminjaman\RuanganController@alat_show')->name('ruangan.alat_show');
        Route::get('/ruangan/confirm', 'User\Peminjaman\RuanganController@confirm')->name('ruangan.confirm');
        Route::post('/ruangan/confirm', 'User\Peminjaman\RuanganController@confirmStore')->name('ruangan.confirmStore');
        Route::get('/ruangan/alat_list/{type}', 'User\Peminjaman\RuanganController@alat_list')->name('ruangan.alat_list');
        Route::post('/ruangan/alat_cart/{id}', 'User\Peminjaman\RuanganController@alat_cart')->name('ruangan.alat_cart');
        Route::put('/ruangan/alat/cart/update', 'User\Peminjaman\RuanganController@updateCart')->name('ruangan.updateCart');
        Route::delete('/ruangan/alat/cart/delete', 'User\Peminjaman\RuanganController@deleteCart')->name('ruangan.deleteCart');
        Route::resource('ruangan', 'User\Peminjaman\RuanganController');


        Route::get('/alat/list', 'User\Peminjaman\AlatController@list')->name('alat.list');
        Route::resource('alat', 'User\Peminjaman\AlatController');
    });
});
