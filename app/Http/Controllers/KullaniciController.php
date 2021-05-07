<?php

namespace App\Http\Controllers;

use App\Mail\KullaniciKayitMail;
use App\Models\KullaniciDetay;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Kullanici;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isNull;
use Cart;


class KullaniciController extends Controller
{
    public function __construct()   //kullanıcı girişi yapmamış kişiler bu controllerdaki tüm fonsyonlara erişebilir
    {
        $this->middleware('guest')->except('oturumukapat');
    }

    public function giris_form()
    {
        return view('kullanici.oturumac');
    }

    public function kaydol_form()
    {
        return view('kullanici.kaydol');
    }

    public function kaydol()
    {
        $this->validate(request(), [
            'adsoyad' => 'required|min:5|max:30',
            'email' => 'required|email|unique:kullanici', //kullanıcı tablosundan email i kontrol eder aynısı varsa hata verir
            'sifre' => 'required|confirmed|min:6|max:12',  //şifre tekrar kısmında şifrenin key'i ne ise onun sonuna confirmed ekler oto olarak  sifre(asıl sifre) - sifre-confirmed(tekrar olan)

        ]);

        $kullanici = Kullanici::create([
            'adsoyad' => \request('adsoyad'),
            'email' => \request('email'),
            'sifre' => Hash::make(request('sifre')),
            'aktivasyon_anahtari' => Str::random(60),
            'aktif_mi' => 0
        ]);
        $kullanici->detay()->save(new KullaniciDetay());

        Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));  //1.parametre gönderilecek mail || cc() ile gönderilecek kişilere bcc() ile gizli olan mailler
        //  2.parametredede bilgileri gönderiyorum

        auth()->login($kullanici);
        return redirect()->route('anasayfa');

    }

    public function aktiflestir($anahtar)
    {
        $kullanici = Kullanici::where('aktivasyon_anahtari', $anahtar)->first();
        if (!isNull($kullanici)) {
            $kullanici->aktivasyon_anahtari = null;
            $kullanici->aktif_mi = 1;
            $kullanici->save();
            return redirect()->to('/')
                ->with('mesaj', 'Kaydınız Aktifleştirildi')
                ->with('mesaj_tur', 'success');
        } else {
            return redirect()->to('/')
                ->with('mesaj', 'Kullanıcı kaydınız aktifleştirilemedi')
                ->with('mesaj_tur', 'warning');
        }
    }

    public function giris()
    {
        $this->validate(\request(), [
            'email' => 'required|email|',
            'sifre' => 'required'
        ]);
        $crendetials = [
            'email' => \request('email'),
            'password' => \request('sifre'),
            'aktif_mi' => 1
        ];
        if (auth()->attempt($crendetials, \request()->has('benihatirla'))) {
            \request()->session()->regenerate();

            $aktif_sepet_id=Sepet::first()->aktif_sepet_id();
//            $aktif_sepet_id = Sepet::aktif_sepet_id();
            if (!is_null($aktif_sepet_id)) {
                $aktif_sepet = Sepet::create(['kullanici_id', auth()->id()]);
                $aktif_sepet_id = $aktif_sepet->id;
            }
            session()->put('aktif_sepet_id', $aktif_sepet_id);

            if (Cart::count() > 0) {
                foreach (Cart::content() as $cartItem) {
                    $a = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->id)->first();
                    if (!is_null($a)) {
                        $sepet_urun = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cartItem->id)->first();
                        $sepet_urun->adet = $cartItem->qty;
                        $sepet_urun->fiyat = $cartItem->price;
                        $sepet_urun->durum = 'beklemede';
                        $sepet_urun->save();
                    } else {
                        $sepet_urun = new SepetUrun();
                        $sepet_urun->sepet_id = $aktif_sepet_id;
                        $sepet_urun->urun_id = $cartItem->id;
                        $sepet_urun->adet = $cartItem->qty;
                        $sepet_urun->fiyat = $cartItem->price;
                        $sepet_urun->durum = 'beklemede';
                        $sepet_urun->save();
                    }
                }
            }
            Cart::destroy();
            $sepetUrunler = SepetUrun::with('urun')->where('sepet_id', $aktif_sepet_id)->get();
            foreach ($sepetUrunler as $item) {
                Cart::add($item->urun->id, $item->urun->urun_adi, $sepet_urun->adet, $item->urun->fiyat, ['slug' => $item->urun->slug]);
            }

            return redirect()->intended('/');
        } else {
            $errors = ['email' => 'Hatali Giris'];
            return back()->withErrors($errors);
        }
    }

    public function oturumukapat()
    {
        auth()->logout();
        \request()->session()->flush(); //sessiondaki bilgileri sıfırlamak için kullanılır
        \request()->session()->regenerate();
        return redirect()->route('anasayfa');
    }


}
