<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/products', \App\Http\Controllers\ProductController::class);
Route::resource('/kategori', \App\Http\Controllers\ProductController::class);

Route::get('login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class,'authenticate']);


Route::post('logout', [LoginController::class,'logout']);
Route::get('logout', [LoginController::class,'logout']);

Route::post('register', [RegisterController::class,'store']);
Route::get('register', [RegisterController::class,'create']);

Route::resource('barang',BarangController::class);//->middleware('auth');
Route::resource('kategori',KategoriController::class);//>middleware('auth');
Route::resource('barangmasuk',BarangMasukController::class);//middleware('auth');
Route::resource('barangkeluar',BarangKeluarController::class) ;//->middleware('auth');

Route::get('/search', [\App\Http\Controllers\SearchController::class,'index']);//->middleware('auth');