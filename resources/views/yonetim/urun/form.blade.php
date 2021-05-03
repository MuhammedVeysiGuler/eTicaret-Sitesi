@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1>Ürün Yönetimi</h1>

    <form method="post" action="{{route('yonetim.urun.kaydet',@$urun->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{@$urun->id > 0 ? "Güncelle" : "Kaydet"}}
            </button>
        </div>
        <h1 class="sub-header">Kategori {{@$urun->id > 0 ? "Düzenle" : "Ekle "}}</h1>

        @include('layouts.partials.errors')
        @include('layouts.partials.alert')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="urun_adi">Ürün Adı</label>
                    <input type="text" class="form-control" id="urun_adi" placeholder="Ürün Adı" name="urun_adi"
                           value="{{old('kategori_adi',$urun->urun_adi)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fiyat">Ürün Fiyatı</label>
                    <input type="text" class="form-control" id="fiyat" placeholder="Ürün Fiyatı" name="fiyat"
                           value="{{old('kategori_adi',$urun->fiyat)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="hidden" value="{{old('slug',$urun->slug)}}" name="original_slug">
                    <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug"
                           value="{{old('slug',$urun->slug)}}">
                </div>
            </div>
            <div class="col-md-24">
                <div class="form-group">
                    <label style="margin-right: 5px" for="aciklama">Ürün Açıklama</label>
                    <textarea  required name="aciklama" id="aciklama" placeholder="Ürün Açıklama" cols="90"
                              rows="2">{{old('kategori_adi',$urun->aciklama)}}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategoriler">Kategoriler </label>
                    {{--multipler olarak çektiğimiz için controller'a dizi şeklinde göndermemiz gerekiyor kategoriler[] şeklinde--}}
                    <select name="kategoriler[]" class="form-control" id="kategoriler" multiple required>
                        @foreach($kategoriler as $k)
                            <option value="{{$k->id}}" {{collect(old('$kategoriler',$urun_kategorileri))->contains($k->id) ? 'selected' : '  '}} >{{$k->kategori_adi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="hidden" name="goster_slider" value="0">
                <input type="checkbox" name="goster_slider"
                       value="1" {{old('goster_slider',$urun->getUrunDetay->goster_slider ? 'checked' : "")}}> Slider'da
                Göster
            </label>

            <label>
                <input type="hidden" name="goster_gunun_firsati" value="0">
                <input type="checkbox" name="goster_gunun_firsati"
                       value="1" {{old('goster_gunun_firsati',$urun->getUrunDetay->goster_gunun_firsati ? 'checked' : "")}}>
                Günün Fırsatında Göster
            </label>

            <label>
                <input type="hidden" name="goster_one_cikan" value="0">
                <input type="checkbox" name="goster_one_cikan"
                       value="1" {{old('goster_one_cikan',$urun->getUrunDetay->goster_one_cikan ? 'checked' : "")}}> Öne
                Çıkan Ürünlerde Göster
            </label>

            <label>
                <input type="hidden" name="goster_cok_satan" value="0">
                <input type="checkbox" name="goster_cok_satan"
                       value="1" {{old('goster_cok_satan',$urun->getUrunDetay->goster_cok_satan ? 'checked' : "")}}> Çok
                Satanlarda Göster
            </label>

            <label>
                <input type="hidden" name="goster_indirimli" value="0">
                <input type="checkbox" name="goster_indirimli"
                       value="1" {{old('goster_indirimli',$urun->getUrunDetay->goster_indirimli ? 'checked' : "")}}>
                İndirimli Ürünlerde Göster
            </label>
        </div>

        <div class="form-group">
            @if($urun->getUrunDetay->urun_resmi != null)
            <img src="/urun-resimleri/urunler/{{$urun->getUrunDetay->urun_resmi}}" style="margin-right: 20px;height: 200px; width: 200px;" class="thumbnail pull-left">
            @endif
            <label for="urun_resmi">Ürün Resmi</label>
            <input type="file" id="urun_resmi" name="urun_resmi">
        </div>

    </form>

@endsection
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('#kategoriler').select2({
                placeholder: 'Kategori Seçiniz '
            });
        });
    </script>

@endsection

