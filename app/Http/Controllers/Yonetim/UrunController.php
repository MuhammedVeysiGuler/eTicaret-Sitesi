<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrunController extends Controller
{
    public function index(){
        if (!empty(request('aranan'))){
            \request()->flash(); //formdan gönderilen bilgileri session içinde saklar
            $aranan = \request('aranan');
            $list = Urun::where('urun_adi','like',"%$aranan%")
                ->orWhere('aciklama','like', "%$aranan%")
                ->orderbyDesc('id')
                ->paginate(8)
                ->appends(['aranan'=>$aranan]);
        }else{
            \request()->flush();
            $list = Urun::orderByDesc('id')->paginate(8);
        }
        return view('yonetim.urun.index',compact('list'));
    }

    public function form($id = 0){
        $urun = new Urun();
        if ($id>0){
            $urun = Urun::find($id);
        }

        $urunler = Urun::all();

        return view('yonetim.urun.form',compact('urun','urunler'));
    }

    public function kaydet($id = 0){

        $data = \request()->only('urun_adi','slug','aciklama','fiyat');
        $data_detay = \request()->only('goster_slider','goster_gunun_firsati','goster_one_cikan','goster_cok_satan','goster_indirimli');
        if (!\request()->filled('slug')){
            $data['slug'] = Str::slug(\request('urun_adi'));
            \request()->merge(['slug'=>$data['slug']]);   //merge arraylari birleştirir.
        }

        $this->validate(\request(),[
            'urun_adi' => 'required',
            'fiyat' => 'required',
            'slug' => (\request('original_slug') != \request('slug') ? 'unique:urun,slug' : "" ),
        ]);

        if ($id>0){
            $urun = Urun::where('id',$id)->firstOrFail();
            $urun->update($data);
            $urun->getUrunDetay()->update($data_detay);

        }else{
            $urun = Urun::create($data);
            $urun->getUrunDetay()->create($data_detay);
        }

        return redirect()->route('yonetim.urun.duzenle',$urun->id)
            ->with('mesaj',($id>0 ? "Güncellendi" : "Kaydedildi"))
            ->with('mesaj_tur','success');
    }

    public function sil($id){
        $kategori = Urun::find($id);
        $kategori->kategoriler()->detach();  //many to many yapısında detach ile kaldırma işlemi gerçekleşiyor
        $kategori->delete();
        return redirect()->route('yonetim.urun')
            ->with('mesaj','Kayıt Silindi')
            ->with('mesaj_tur','success');
    }
}
