<?php

namespace App\Http\Controllers;

use App\Models\Siparis;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OdemeController extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return redirect()->route('kullanici.oturumac')
                ->with('mesaj_tur', 'info')
                ->with('mesaj', 'Ödeme yapmanız için oturum açmanız gerekmektedir.');
        } else if (count(Cart::content()) == 0) {
            return redirect()->route('anasayfa')
                ->with('mesaj_tur', 'info')
                ->with('mesaj', 'Ödeme yapmanız için sepetinizde ürün bulunmalıdır.');
        }

        $kullanici_detay = Auth::user()->detay;
        return view('odeme', compact('kullanici_detay'));
    }

    public function odemeyap()
    {
        $siparis = \request()->all();
        $siparis['sepet_id'] = session('aktif_sepet_id');
        $siparis['banka'] = "Ziraat";
        $siparis['taksit_sayisi'] = 1;
        $siparis['durum'] = "Siparişiniz alındı";
        $siparis['siparis_tutari'] = Cart::subtotal();

        Siparis::create($siparis);
        Cart::destroy();
        session()->forget('aktif_sepet_id');

        return redirect()->route('siparisler')
            ->with('mesaj_tur', 'success')
            ->with('mesaj', 'Ödemeniz başarılı bir şekilde gerçekleşti');
    }

}
