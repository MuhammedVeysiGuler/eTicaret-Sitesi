<?php

namespace App\Http\Controllers;

use App\Mail\KullaniciKayitMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;


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

        Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));  //1.parametre gönderilecek mail || cc() ile gönderilecek kişilere bcc() ile gizli olan mailler
        //  2.parametredede bilgileri gönderiyorum

        auth()->login($kullanici);
        return redirect()->route('anasayfa');

    }

    public function aktiflestir($anahtar){
        $kullanici = User::where('aktivasyon_anahtari',$anahtar)->first();
        if (!isNull($kullanici)){
            $kullanici->aktivasyon_anahtari = null;
            $kullanici->aktif_mi = 1;
            $kullanici->save();
            return redirect()->to('/')
                ->with('mesaj','Kaydınız Aktifleştirildi')
                ->with('mesaj_turu','success');
        }
        else{
            return redirect()->to('/')
                ->with('mesaj','Kullanıcı kaydınız aktifleştirilemedi')
                ->with('mesaj_turu','warning');
        }
    }



}
