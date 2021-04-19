<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\KategoriController;
use \App\Http\Controllers\UrunController;
use \App\Http\Controllers\SepetController;
use \App\Http\Controllers\OdemeController;
use \App\Http\Controllers\SiparisController;
use \App\Http\Controllers\KullaniciController;
use \App\Http\Controllers\AnasayfaController;

Route::get('/',[AnasayfaController::class,'index'])->name('anasayfa');

Route::get('/kategori/{slug_kategoriadi}',[KategoriController::class,'index'])->name('kategori');

Route::get('/urun/{slug_urunadi}',[UrunController::class,'index'])->name('urun');

Route::post('ara',[UrunController::class,'ara'])->name('urun_ara');
Route::get('ara',[UrunController::class,'ara'])->name('urun_ara');

Route::group(['prefix'=>'sepet'],function (){
    Route::get('/',[SepetController::class,'index'])->name('sepet');
    Route::post('/ekle',[SepetController::class,'ekle'])->name('sepet.ekle');
    Route::delete('/kaldir/{rowId}',[SepetController::class,'kaldir'])->name('sepet.kaldir');
});


Route::group(['middleware'=>'auth'],function (){ //sadece giriş yapmış kişilerin erişimine açık hael getirildi
    Route::get('/odeme',[OdemeController::class,'index'])->name('odeme');
    Route::get('/siparisler',[SiparisController::class,'index'])->name('siparisler');
    Route::get('/siparisler/{id}',[SiparisController::class,'detay'])->name('siparis');
});


Route::group(['prefix'=>'kullanici'],function (){
    Route::get('/oturumac',[KullaniciController::class,'giris_form'])->name('kullanici.oturumac');
    Route::post('/oturumac',[KullaniciController::class,'giris']);
    Route::get('/kaydol',[KullaniciController::class,'kaydol_form'])->name('kullanici.kaydol');
    Route::post('/kaydol',[KullaniciController::class,'kaydol'])->name('kullanici.kaydol');
    Route::get('/aktiflestir/{anahtar}',[KullaniciController::class,'aktiflestir'])->name('aktiflestir');
    Route::post('/oturumukapat',[KullaniciController::class,'oturumukapat'])->name('kullanici.oturumukapat');
});

Route::get('/test/mail',function(){
    $user = \App\Models\User::find(1);
    return new App\Mail\KullaniciKayitMail($user );
});

