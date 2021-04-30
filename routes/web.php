<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\KategoriController;
use \App\Http\Controllers\UrunController;
use \App\Http\Controllers\SepetController;
use \App\Http\Controllers\OdemeController;
use \App\Http\Controllers\SiparisController;
use \App\Http\Controllers\KullaniciController;
use \App\Http\Controllers\AnasayfaController;

Route::get('/', [AnasayfaController::class, 'index'])->name('anasayfa');

Route::namespace('Yonetim')->group(function () {
    Route::group(['prefix' => 'yonetim'], function () {
        Route::redirect('/', 'yonetim/oturumac');
        Route::match(['get', 'post'], '/oturumac', [App\Http\Controllers\Yonetim\KullaniciController::class, 'oturumac'])->name('yonetim.oturumac');
        Route::get('/oturumukapat', [App\Http\Controllers\Yonetim\KullaniciController::class, 'oturumukapat'])->name('yonetim.oturumukapat');

        Route::group(['middleware' => 'yonetim'], function () {
            Route::get('/anasayfa', [App\Http\Controllers\Yonetim\AnasayfaController::class, 'index'])->name('yonetim.anasayfa');

            Route::group(['prefix' => 'kullanici'], function () {
                Route::match(['get', 'post'], '/', [App\Http\Controllers\Yonetim\KullaniciController::class, 'index'])->name('yonetim.kullanici');
                Route::get('/yeni', [App\Http\Controllers\Yonetim\KullaniciController::class, 'form'])->name('yonetim.kullanici.yeni');
                Route::get('/duzenle/{id}', [App\Http\Controllers\Yonetim\KullaniciController::class, 'form'])->name('yonetim.kullanici.duzenle');
                Route::post('/kaydet/{id?}', [App\Http\Controllers\Yonetim\KullaniciController::class, 'kaydet'])->name('yonetim.kullanici.kaydet');
                Route::get('/sil/{id}', [App\Http\Controllers\Yonetim\KullaniciController::class, 'sil'])->name('yonetim.kullanici.sil');
            });


            Route::group(['prefix' => 'kategori'], function () {
                Route::match(['get', 'post'], '/', [App\Http\Controllers\Yonetim\KategoriController::class, 'index'])->name('yonetim.kategori');
                Route::get('/yeni', [App\Http\Controllers\Yonetim\KategoriController::class, 'form'])->name('yonetim.kategori.yeni');
                Route::get('/duzenle/{id}', [App\Http\Controllers\Yonetim\KategoriController::class, 'form'])->name('yonetim.kategori.duzenle');
                Route::post('/kaydet/{id?}', [App\Http\Controllers\Yonetim\KategoriController::class, 'kaydet'])->name('yonetim.kategori.kaydet');
                Route::get('/sil/{id}', [App\Http\Controllers\Yonetim\KategoriController::class, 'sil'])->name('yonetim.kategori.sil');
            });

            Route::group(['prefix' => 'urun'], function () {
                Route::match(['get', 'post'], '/', [App\Http\Controllers\Yonetim\UrunController::class, 'index'])->name('yonetim.urun');
                Route::get('/yeni', [App\Http\Controllers\Yonetim\UrunController::class, 'form'])->name('yonetim.urun.yeni');
                Route::get('/duzenle/{id}', [App\Http\Controllers\Yonetim\UrunController::class, 'form'])->name('yonetim.urun.duzenle');
                Route::post('/kaydet/{id?}', [App\Http\Controllers\Yonetim\UrunController::class, 'kaydet'])->name('yonetim.urun.kaydet');
                Route::get('/sil/{id}', [App\Http\Controllers\Yonetim\UrunController::class, 'sil'])->name('yonetim.urun.sil');
            });

        });
    });
});


Route::get('/kategori/{slug_kategoriadi}', [KategoriController::class, 'index'])->name('kategori');

Route::get('/urun/{slug_urunadi}', [UrunController::class, 'index'])->name('urun');

Route::post('ara', [UrunController::class, 'ara'])->name('urun_ara');
Route::get('ara', [UrunController::class, 'ara'])->name('urun_ara');

Route::group(['prefix' => 'sepet'], function () {
    Route::get('/', [SepetController::class, 'index'])->name('sepet');
    Route::post('/ekle', [SepetController::class, 'ekle'])->name('sepet.ekle');
    Route::delete('/kaldir/{rowId}', [SepetController::class, 'kaldir'])->name('sepet.kaldir');
    Route::delete('/bosalt', [SepetController::class, 'bosalt'])->name('sepet.bosalt');
    Route::patch('/guncelle/{rowId}', [SepetController::class, 'guncelle'])->name('sepet.guncelle');
});

Route::get('/odeme', [OdemeController::class, 'index'])->name('odeme');
Route::post('/odeme', [OdemeController::class, 'odemeyap'])->name('odemeyap');

Route::group(['middleware' => 'auth'], function () { //sadece giriş yapmış kişilerin erişimine açık hael getirildi
    Route::get('/siparisler', [SiparisController::class, 'index'])->name('siparisler');
    Route::get('/siparisler/{id}', [SiparisController::class, 'detay'])->name('siparis');
});


Route::group(['prefix' => 'kullanici'], function () {
    Route::get('/oturumac', [KullaniciController::class, 'giris_form'])->name('kullanici.oturumac');
    Route::post('/oturumac', [KullaniciController::class, 'giris']);
    Route::get('/kaydol', [KullaniciController::class, 'kaydol_form'])->name('kullanici.kaydol');
    Route::post('/kaydol', [KullaniciController::class, 'kaydol'])->name('kullanici.kaydol');
    Route::get('/aktiflestir/{anahtar}', [KullaniciController::class, 'aktiflestir'])->name('aktiflestir');
    Route::post('/oturumukapat', [KullaniciController::class, 'oturumukapat'])->name('kullanici.oturumukapat');
});

Route::get('/test/mail', function () {
    $user = \App\Models\Kullanici::find(1);
    return new App\Mail\KullaniciKayitMail($user);
});

