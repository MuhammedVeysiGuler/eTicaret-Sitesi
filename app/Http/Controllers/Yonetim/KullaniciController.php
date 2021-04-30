<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class KullaniciController extends Controller
{
    public function index()
    {
        if (!empty(request('aranan'))) {
            \request()->flash(); //formdan gönderilen bilgileri session içinde saklar
            $aranan = \request('aranan');
            $list = Kullanici::where('adsoyad', 'like', "%$aranan%")
                ->orWhere('email', 'like', "%$aranan%")
                ->orderbyDesc('created_at')
                ->paginate(8)
                ->appends(['aranan' => $aranan]);
        } else {
            \request()->flush();
            $list = Kullanici::orderByDesc('created_at')->paginate(8);
        }
        return view('yonetim.kullanici.index', compact('list'));
    }

    public function oturumac()
    {
        if (\request()->isMethod('POST')) {
            $this->validate(\request(), [
                'email' => 'required|email',
                'sifre' => 'required'
            ]);
            $credentials = [
                'email' => \request()->get('email'),
                'password' => \request()->get('sifre'),
                'yonetici_mi' => 1,
                'aktif_mi' => 1
            ];
            if (Auth::guard('yonetim')->attempt($credentials, \request()->has('benihatirla'))) {
                return redirect()->route('yonetim.anasayfa');
            } else {
                return back()->withInput()->withErrors(['email' => 'Giriş Hatalı']);
            }
        }
        return view('yonetim.oturumac');
    }

    public function oturumuKapat()
    {
        Auth::guard('yonetim')->logout();
        \request()->session()->flush(); //sessiondaki bilgileri sıfırlamak için kullanılır
        \request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }

    public function form($id = 0)
    {
        $kullanici = new Kullanici();
        if ($id > 0) {
            $kullanici = Kullanici::find($id);
        }
        return view('yonetim.kullanici.form', compact('kullanici'));
    }

    public function kaydet($id = 0)
    {
        $this->validate(\request(), [
            'adsoyad' => 'required',
            'email' => 'required|email'
        ]);
        $data = \request()->only('adsoyad', 'email');

        if (\request()->filled('sifre')) {  //şifre alanı doldurulmuşsa güncellemeye dahil edilecek
            $data['sifre'] = Hash::make(\request('sifre'));
        }

        $data['aktif_mi'] = \request()->has('aktif_mi') && \request('aktif_mi') == 1 ? 1 : 0; //aktif_mi seçilmişşe 1 olarak seçilmemişse 0 olarak güncelle
        $data['yonetici_mi'] = \request()->has('yonetici_mi') && \request('yonetici_mi') == 1 ? 1 : 0; //aktif_mi seçilmişşe 1 olarak seçilmemişse 0 olarak güncelle


        if ($id > 0) {
            $kullanici = Kullanici::where('id', $id)->firstOrFail();
            $kullanici->update($data);

        } else {
            $kullanici = Kullanici::create($data);
        }
        $a = KullaniciDetay::where('kullanici_id', $kullanici->id)->first();
        if (!is_null($a)) {
            $kullanici_detay = KullaniciDetay::where('kullanici_id', $kullanici->id)->first();
            $kullanici_detay->adres = \request('adres');
            $kullanici_detay->telefon = \request('telefon');
            $kullanici_detay->cepTelefonu = \request('ceptelefonu');
            $kullanici_detay->save();
        } else {
            $kullanici_detay = new KullaniciDetay();
            $kullanici_detay->kullanici_id = $kullanici->id;
            $kullanici_detay->adres = \request('adres');
            $kullanici_detay->telefon = \request('telefon');
            $kullanici_detay->cepTelefonu = \request('ceptelefonu');
            $kullanici_detay->save();
        }
        return redirect()->route('yonetim.kullanici.duzenle', $kullanici->id)
            ->with('mesaj', ($id > 0 ? "Güncellendi" : "Kaydedildi"))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Kullanici::destroy($id);
        return redirect()->route('yonetim.kullanici')
            ->with('mesaj', 'Kayıt Silindi')
            ->with('mesaj_tur', 'success');
    }
}
