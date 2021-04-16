<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class KullaniciController extends Controller
{
    public function giris_form(){
        return view('kullanici.oturumac');
    }

    public function kaydol_form(){
        return view('kullanici.kaydol');
    }
    public function kaydol(){
        $this->validate(request(),[
           'adsoyad' => 'required|min:5|max:30',
           'email' => 'required|email|unique:kullanici', //kullanıcı tablosundan email i kontrol eder aynısı varsa hata verir
           'sifre' => 'required|confirmed|min:6|max:12',  //şifre tekrar kısmında şifrenin key'i ne ise onun sonuna confirmed ekler oto olarak  sifre(asıl sifre) - sifre-confirmed(tekrar olan)

        ]);


        $kullanici = User::create([
            'adsoyad' => \request('adsoyad'),
            'email' => \request('email'),
            'sifre' => Hash::make(request('sifre')),
            'aktivasyon_anahtari' =>Str::random(60),
            'aktif_mi' => 0
        ]);

        auth()->login($kullanici);
        return redirect()->route('anasayfa');

    }
}
