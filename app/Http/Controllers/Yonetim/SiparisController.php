<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Siparis;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiparisController extends Controller
{
    public function index()
    {
        if (!empty(request('aranan'))) {
            \request()->flash(); //formdan gönderilen bilgileri session içinde saklar
            $aranan = \request('aranan');
            $list = Siparis::with('sepet.kullanici')
                ->where('banka', 'like', "%$aranan%") //hem sepeti hemde kullaniciyi çekmiş oluyoruz
                ->orWhere('id', $aranan)
                ->orderbyDesc('id')
                ->paginate(8)
                ->appends(['aranan' => $aranan]);
        } else {
            \request()->flush();
            $list = Siparis::with('sepet.kullanici')
                ->orderByDesc('id')->paginate(8);
        }

        return view('yonetim.siparis.index', compact('list'));
    }

    public function form($id = 0)
    {
        if ($id > 0) {
            $urun = Siparis::with('sepet.sepet_urunler.urun')->find($id);
        }


        return view('yonetim.siparis.form', compact('urun'));
    }

    public function kaydet($id = 0)
    {


        $this->validate(\request(), [
            'adsoyad' => 'required',
            'adres' => 'required',
            'telefon' => 'required',
            'durum' => 'required',
        ]);
        $data = \request()->only('adsoyad', 'adres', 'telefon', 'cepTelefonu','durum');


        if ($id > 0) {
            $urun = Siparis::where('id', $id)->firstOrFail();
            $urun->update($data);
        }
        return redirect()->route('yonetim.siparis.duzenle', $urun->id)
            ->with('mesaj', 'Güncellendi')
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        Siparis::destroy($id);

        return redirect()->route('yonetim.siparis')
            ->with('mesaj', 'Sipariş Silindi')
            ->with('mesaj_tur', 'success');
    }
}
