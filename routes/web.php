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
        Route::resource('ruangan', 'User\Peminjaman\RuanganController');
    });
});
