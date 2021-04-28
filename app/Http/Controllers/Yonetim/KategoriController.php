<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class KategoriController extends Controller
{
    public function index(){
        if (\request()->filled('aranan') || \request()->filled('ust_id')){
            \request()->flash(); //formdan gönderilen bilgileri session içinde saklar
            $aranan = \request('aranan');
            $ust_id = \request('ust_id');
            $list = Kategori::with('ust_kategori')
                ->where('kategori_adi','like',"%$aranan%")
                ->where('ust_id',$ust_id)
                ->orderbyDesc('id')
                ->paginate(8)
                ->appends(['aranan'=>$aranan,'ust_id'=>$ust_id]);
        }else{
            $list = Kategori::with('ust_kategori')->orderByDesc('id')->paginate(8);
        }
        $anakategoriler = Kategori::where('ust_id',null)->get();

        return view('yonetim.kategori.index',compact('list','anakategoriler'));
    }

    public function form($id = 0){
        $kategori = new Kategori();
        if ($id>0){
            $kategori = Kategori::find($id);
        }

        $kategoriler = Kategori::all();

        return view('yonetim.kategori.form',compact('kategori','kategoriler'));
    }

    public function kaydet($id = 0){

        $data = \request()->only('kategori_adi','slug','ust_id');
        if (!\request()->filled('slug')){
            $data['slug'] = Str::slug(\request('kategori_adi'));
            \request()->merge(['slug'=>$data['slug']]);   //merge arraylari birleştirir.
        }

        $this->validate(\request(),[
            'kategori_adi' => 'required',
            'slug' => (\request('original_slug') != \request('slug') ? 'unique:kategori,slug' : "" ),
        ]);

        if ($id>0){
            $kullanici = Kategori::where('id',$id)->firstOrFail();
            $kullanici->update($data);

        }else{
            $kullanici = Kategori::create($data);
        }

        return redirect()->route('yonetim.kategori.duzenle',$kullanici->id)
            ->with('mesaj',($id>0 ? "Güncellendi" : "Kaydedildi"))
            ->with('mesaj_tur','success');
    }

    public function sil($id){
         $kategori = Kategori::find($id);
         $kategori->urunler()->detach();   //many to many yapısı üst_id si giderse bağlı olanlarda gider-->kategoriyi sildiğimde kategoriye bağlı olan ürünlerde silinir
         $kategori->delete();
        return redirect()->route('yonetim.kategori')
            ->with('mesaj','Kayıt Silindi')
            ->with('mesaj_tur','success');
    }
}
