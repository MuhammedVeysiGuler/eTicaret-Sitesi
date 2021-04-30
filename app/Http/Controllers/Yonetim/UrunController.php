<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Urun;
use App\Models\UrunDetay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrunController extends Controller
{
    public function index()
    {
        if (!empty(request('aranan'))) {
            \request()->flash(); //formdan gönderilen bilgileri session içinde saklar
            $aranan = \request('aranan');
            $list = Urun::where('urun_adi', 'like', "%$aranan%")
                ->orWhere('aciklama', 'like', "%$aranan%")
                ->orderbyDesc('id')
                ->paginate(8)
                ->appends(['aranan' => $aranan]);
        } else {
            \request()->flush();
            $list = Urun::orderByDesc('id')->paginate(8);
        }
        return view('yonetim.urun.index', compact('list'));
    }

    public function form($id = 0)
    {
        $urun = new Urun();
        $urun_kategorileri = [];
        if ($id > 0) {
            $urun = Urun::find($id);
            $urun_kategorileri = $urun->kategoriler()->pluck('kategori_id')->all(); //pluck sadece belirli bir değeri almayı sağlar
        }

        $kategoriler = Kategori::all();

        return view('yonetim.urun.form', compact('urun', 'kategoriler', 'urun_kategorileri'));
    }

    public function kaydet($id = 0)
    {

        $data = \request()->only('urun_adi', 'slug', 'aciklama', 'fiyat');
        $data_detay = \request()->only('goster_slider', 'goster_gunun_firsati', 'goster_one_cikan', 'goster_cok_satan', 'goster_indirimli');
        if (!\request()->filled('slug')) {
            $data['slug'] = Str::slug(\request('urun_adi'));
            \request()->merge(['slug' => $data['slug']]);   //merge arraylari birleştirir.
        }

        $this->validate(\request(), [
            'urun_adi' => 'required',
            'fiyat' => 'required',
            'slug' => (\request('original_slug') != \request('slug') ? 'unique:urun,slug' : ""),
            'kategoriler' => 'required',
            'aciklama' => 'required'
        ]);

        $kategoriler = \request('kategoriler');

        if ($id > 0) {
            $urun = Urun::where('id', $id)->firstOrFail();
            $urun->update($data);
            $urun->getUrunDetay()->update($data_detay);
            $urun->kategoriler()->sync($kategoriler);  //sync o anda gönderileri kaydeder eskilerini siler
        } else {
            $urun = Urun::create($data);
            $urun->getUrunDetay()->create($data_detay);
            $urun->kategoriler()->attach($kategoriler);
        }

        if (\request()->hasFile('urun_resmi')) {
            $this->validate(\request(), [
                'urun_resmi' => 'image|mimes:jpg,png,jpeg,gif|max:4096'
            ]);
            $urun_resmi = \request()->file('urun_resmi');
//            $urun_resmi->extension(); //urun_resmi uzantısı çekilir
//            $urun_resmi->getClientOriginalName(); //dosyanın orkinal adını çekmemizi sağlar
//            $urun_resmi->hashName(); //ismi hashler rastgele olusturur.
            $dosya_adi = $urun->id . '-' . time() . '-' . $urun_resmi->extension();

            if ($urun_resmi->isValid()) { //geçici bir klosere cachliyor isValid
                $urun_resmi->move('urun-resimleri/urunler', $dosya_adi);  //public.urunler içinde dosya_adi değeri ile kaydeder
                $a = UrunDetay::where('urun_id', $urun->id);
                if (!is_null($a)) {
                    $urun1 = UrunDetay::where('urun_id', $urun->id)->first();
                    $urun1->urun_resmi = $dosya_adi;
                    $urun1->save();
                } else {
                    $urun1 = new UrunDetay();
                    $urun1->urun_resmi = $dosya_adi;
                    $urun1->save();
                }
            }
        }
        return redirect()->route('yonetim.urun.duzenle', $urun->id)
            ->with('mesaj', ($id > 0 ? "Güncellendi" : "Kaydedildi"))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        $kategori = Urun::find($id);
        $kategori->kategoriler()->detach();  //many to many yapısında detach ile kaldırma işlemi gerçekleşiyor
        $kategori->delete();
        return redirect()->route('yonetim.urun')
            ->with('mesaj', 'Kayıt Silindi')
            ->with('mesaj_tur', 'success');
    }
}
