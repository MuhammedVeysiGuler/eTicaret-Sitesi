<?php

namespace App\Http\Controllers;

use App\Models\SepetUrun;
use App\Models\Urun;
use Cart;
use Illuminate\Http\Request;

class SepetController extends Controller
{
    public function index(){
        return view('sepet');
    }
    public function ekle(){
        $urun = Urun::find(\request('id'));
        Cart::add($urun->id,$urun->urun_adi,1,$urun->fiyat,['slug'=>$urun->slug]);
        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj','Ürün Sepete Eklendi');

    }

    public function kaldir($rowId){
        if (auth()->check()){
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowId);
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();
        }

        Cart::remove($rowId);
        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj','Ürün Sepetten Kaldırıldı');
    }

    public function bosalt(){
        if (auth()->check()){
            $aktif_sepet_id = session('aktif_sepet_id');
            SepetUrun::where('sepet_id',$aktif_sepet_id) ->delete();
        }

        Cart::destroy();
        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj','Sepet   Boşaltıldı');
    }

    public function guncelle($rowId){
        Cart::update($rowId,\request('adet'));  //scriptte data olarak gonderdik
        session()->flash('mesaj_tur','success');
        session()->flash('mesaj','Adet bilgisi Güncellendi');
        return response()->json(['success'=>true]);
    }

}
