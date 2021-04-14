<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\KategoriController;
use \App\Http\Controllers\UrunController;
use \App\Http\Controllers\SepetController;
use \App\Http\Controllers\OdemeController;
use \App\Http\Controllers\SiparisController;
use \App\Http\Controllers\KullaniciController;


Route::get('/', function () {
    return view('anasayfa');
});

Route::get('/kategori/{slug_kategoriadi}',[KategoriController::class,'index'])->name('kategori');

Route::get('/urun/{slug_urunadi}',[UrunController::class,'index'])->name('urun');

Route::get('/sepet',[SepetController::class,'index'])->name('sepet');

Route::get('/odeme',[OdemeController::class,'index'])->name('odeme');

Route::get('/siparisler',[SiparisController::class,'index'])->name('siparisler');
Route::get('/siparisler/{id}',[SiparisController::class,'detay'])->name('siparis');

Route::group(['prefix'=>'kullanici'],function (){
    Route::get('/oturumac',[KullaniciController::class,'giris_form'])->name('kullanici.oturumac');
    Route::get('/kaydol',[KullaniciController::class,'kaydol_form'])->name('kullanici.kaydol');
});


