<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Urun;
use Cart;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;

class SepetController extends Controller
{
    public function index(){
        return view('sepet');
    }

    public function ekle(){
        $urun = Urun::find(\request('id'));
        $cartItem = Cart::add($urun->id,$urun->urun_adi,1,$urun->fiyat,['slug'=>$urun->slug]);

        if (Auth::user()){
            $aktif_sepet_id = session('aktif_sepet_id');
            if(!isset($aktif_sepet_id)){
                $aktif_sepet = Sepet::create([
                    'kullanici_id' => auth()->id()
                ]);
                $aktif_sepet_id = $aktif_sepet->id;
                session()->put('aktif_sepet_id',$aktif_sepet_id);
            }
            $a = SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$urun->id)->first();
            if(!is_null($a)){
                $sepet_urun = SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $urun->id)->first();
                $sepet_urun->adet = $cartItem->qty;
                $sepet_urun->fiyat = $urun->fiyat;
                $sepet_urun->durum = 'beklemede';
                $sepet_urun->save();
            }else{
                $sepet_urun = new SepetUrun();
                $sepet_urun->sepet_id = $aktif_sepet_id;
                $sepet_urun->urun_id = $urun->id;
                $sepet_urun->adet = $cartItem->qty;
                $sepet_urun->fiyat = $urun->fiyat;
                $sepet_urun->durum = 'beklemede';
                $sepet_urun->save();
            }
        }
        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj','Ürün Sepete Eklendi');

    }

    public function kaldir($rowId){
        if (Auth::user()){
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowId);
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();
        }

        Cart::remove($rowId);
        return redirect()->route('sepet')
            ->with('mesaj_tur','info')
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
            ->with('mesaj','Sepet Boşaltıldı');
    }

    public function guncelle($rowId){
        $validator = Validator::make(\request()->all(),[
            'adet' => 'required|numeric|between:0,5'
        ]);
        if ($validator->fails()){
            session()->flash('mesaj_tur','danger');
            session()->flash('mesaj','Adet Değeri en fazla 5 olmalıdır');
            return response()->json(['success'=>true]);
        }

        if (auth()->check()){
            $aktif_sepet_id = session('aktif_sepet_id');
            $cartItem = Cart::get($rowId);
            if (\request('adet')==0){
                SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->delete();
            }
            else
                SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$cartItem->id)->update([
                    'adet' => \request('adet')
                ]);
        }

        Cart::update($rowId,\request('adet'));  //scriptte data olarak gonderdik
        session()->flash('mesaj_tur','success');
        session()->flash('mesaj','Adet bilgisi güncellendi');
        return response()->json(['success'=>true]);
    }

}
