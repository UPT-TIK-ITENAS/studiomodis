<?php

use App\Borrow;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

Route::get('send-mail', function () {

    $borrows = Borrow::with(['ruangan', 'alat'])->findOrFail(3);
    $status = ($borrows->status == 1) ? "Disetujui" : "Ditolak";

    Mail::to('mmuqiit.f14@gmail.com')->send(new App\Mail\PeminjamanApprove($borrows, $status));

    dd("Email is Sent.");
});

Auth::routes();
Route::get('/check-ruangan', 'RuanganCheck')->name('check.ruangan');
Route::get('/check-borrow/{id}', 'BorrowDetailCheck')->name('check.ruangan.detail');
Route::get('/edit-profile', 'ProfileController@edit')->name('profile.edit');
Route::put('/edit-profile', 'ProfileController@update')->name('profile.update');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/home', 'Admin\HomeController@index')->name('home');
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/peminjaman/{type}/{year}', 'Admin\HomeController@getPeminjamanPerMonth')->name('peminjaman');
    });

    Route::get('/sumber-daya/list', 'Admin\SumberDayaController@list')->name('sumber-daya.list');
    Route::resource('sumber-daya', 'Admin\SumberDayaController');

    Route::get('/ruangan/list', 'Admin\RuanganController@list')->name('ruangan.list');
    Route::resource('ruangan', 'Admin\RuanganController');

    Route::get('/kategori/list', 'Admin\KategoriAlatController@list')->name('kategori.list');
    Route::resource('kategori', 'Admin\KategoriAlatController');

    Route::get('/alat/list', 'Admin\AlatController@list')->name('alat.list');
    Route::resource('alat', 'Admin\AlatController');

    Route::get('/user/atasan', 'Admin\UserController@atasan')->name('user.atasan');
    Route::get('/user/list', 'Admin\UserController@list')->name('user.list');
    Route::resource('user', 'Admin\UserController');

    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::post('/alat/{id}/tolak', 'Admin\Peminjaman\AlatController@tolak')->name('alat.tolak');
        Route::get('/alat/peminjaman', 'Admin\Peminjaman\AlatController@peminjaman')->name('alat.peminjaman');
        Route::post('/alat/peminjaman', 'Admin\Peminjaman\AlatController@storePeminjaman')->name('alat.storePeminjaman');
        Route::get('/alat/listPeminjaman', 'Admin\Peminjaman\AlatController@listPeminjaman')->name('alat.listPeminjaman');
        Route::get('/alat/alat_show/{id}', 'Admin\Peminjaman\RuanganController@alat_show')->name('alat.alat_show');
        Route::get('/alat/list/{type}', 'Admin\Peminjaman\AlatController@list')->name('alat.list');
        Route::post('/alat/cart/{id}', 'Admin\Peminjaman\AlatController@addToCart')->name('alat.addToCart');
        Route::put('/alat/cart/update', 'Admin\Peminjaman\AlatController@updateCart')->name('alat.updateCart');
        Route::delete('/alat/cart/delete', 'Admin\Peminjaman\AlatController@deleteCart')->name('alat.deleteCart');
        Route::get('/alat/confirm', 'Admin\Peminjaman\AlatController@confirm')->name('alat.confirm');
        Route::post('/alat/confirm', 'Admin\Peminjaman\AlatController@confirmStore')->name('alat.confirmStore');
        Route::post('/alat/{alat}/status', 'Admin\Peminjaman\AlatController@status')->name('alat.status');

        Route::resource('alat', 'Admin\Peminjaman\AlatController');

        Route::post('/ruangan/{id}/tolak', 'Admin\Peminjaman\RuanganController@tolak')->name('ruangan.tolak');
        Route::get('/ruangan/confirm', 'Admin\Peminjaman\RuanganController@confirm')->name('ruangan.confirm');
        Route::post('/ruangan/confirm', 'Admin\Peminjaman\RuanganController@confirmStore')->name('ruangan.confirmStore');
        Route::get('/ruangan/alat_list/{type}', 'Admin\Peminjaman\RuanganController@alat_list')->name('ruangan.alat_list');
        Route::post('/ruangan/alat_cart/{id}', 'Admin\Peminjaman\RuanganController@alat_cart')->name('ruangan.alat_cart');
        Route::put('/ruangan/alat/cart/update', 'Admin\Peminjaman\RuanganController@updateCart')->name('ruangan.updateCart');
        Route::delete('/ruangan/alat/cart/delete', 'Admin\Peminjaman\RuanganController@deleteCart')->name('ruangan.deleteCart');
        Route::get('/ruangan/alat', 'Admin\Peminjaman\RuanganController@alat')->name('ruangan.alat');
        Route::post('/ruangan/{ruangan}/status', 'Admin\Peminjaman\RuanganController@status')->name('ruangan.status');
        Route::get('/ruangan/list', 'Admin\Peminjaman\RuanganController@list')->name('ruangan.list');
        Route::get('/ruangan/alat_show/{id}', 'Admin\Peminjaman\RuanganController@alat_show')->name('ruangan.alat_show');
        Route::resource('ruangan', 'Admin\Peminjaman\RuanganController');
    });

    Route::get('/konsultasi/list', 'Admin\KonsultasiController@list')->name('konsultasi.list');
    Route::get('/konsultasi/pic', 'Admin\KonsultasiController@pic')->name('konsultasi.pic');
    Route::resource('konsultasi', 'Admin\KonsultasiController');
});

Route::name('user.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/home', 'User\HomeController@index')->name('home');

    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/alat', 'User\Peminjaman\AlatController@index')->name('alat.index');

        Route::get('/ruangan/{id}/selesai', 'User\Peminjaman\RuanganController@selesai')->name('ruangan.selesai');
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


        Route::get('/alat/peminjaman', 'User\Peminjaman\AlatController@peminjaman')->name('alat.peminjaman');
        Route::post('/alat/peminjaman', 'User\Peminjaman\AlatController@storePeminjaman')->name('alat.storePeminjaman');
        Route::get('/alat/listPeminjaman', 'User\Peminjaman\AlatController@listPeminjaman')->name('alat.listPeminjaman');
        Route::get('/alat/alat_show/{id}', 'User\Peminjaman\RuanganController@alat_show')->name('alat.alat_show');
        Route::get('/alat/list/{type}', 'User\Peminjaman\AlatController@list')->name('alat.list');
        Route::post('/alat/cart/{id}', 'User\Peminjaman\AlatController@addToCart')->name('alat.addToCart');
        Route::put('/alat/cart/update', 'User\Peminjaman\AlatController@updateCart')->name('alat.updateCart');
        Route::delete('/alat/cart/delete', 'User\Peminjaman\AlatController@deleteCart')->name('alat.deleteCart');
        Route::get('/alat/confirm', 'User\Peminjaman\AlatController@confirm')->name('alat.confirm');
        Route::post('/alat/confirm', 'User\Peminjaman\AlatController@confirmStore')->name('alat.confirmStore');

        Route::resource('alat', 'User\Peminjaman\AlatController');
    });

    Route::get('/konsultasi/list', 'User\KonsultasiController@list')->name('konsultasi.list');
    Route::resource('konsultasi', 'User\KonsultasiController');
});
