@extends('yonetim.layouts.master')
@section('title','Sipariş Yönetimi')
@section('content')
    <h1>Sipariş Yönetimi</h1>

    <form method="post" action="{{route('yonetim.siparis.kaydet',@$urun->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{@$urun->id > 0 ? "Güncelle" : "Kaydet"}}
            </button>
        </div>
        <h1 class="sub-header">Sipariş {{@$urun->id > 0 ? "Düzenle" : "Ekle "}}</h1>

        @include('layouts.partials.errors')
        @include('layouts.partials.alert')
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" id="adsoyad" placeholder="Ad Soyad" name="adsoyad"
                           value="{{old('adsoyad',$urun->adsoyad)}}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" id="telefon" placeholder="Telefon" name="telefon"
                           value="{{old('telefon',$urun->telefon)}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cepTelefonu">Cep Telefonu</label>
                    <input type="text" class="form-control" id="cepTelefonu" placeholder="Cep Telefonu"
                           name="cepTelefonu"
                           value="{{old('cepTelefonu',$urun->cepTelefonu)}}">
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" id="adres" placeholder="Adres" name="adres"
                           value="{{old('kategori_adi',$urun->adres)}}">
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="durum">Durum </label>
                    <select name="durum" class="form-control" id="durum">
                        <option {{old('durum',$urun->durum) == 'Siparişiniz Alındı' ? 'selected' : ''}}}>Siparişiniz
                            Alındı
                        </option>
                        <option {{old('durum',$urun->durum) == 'Ödeme Onaylandı' ? 'selected' : ''}}}>Ödeme Onaylandı
                        </option>
                        <option {{old('durum',$urun->durum) == 'Kargoya Verildi' ? 'selected' : ''}}}>Kargoya Verildi
                        </option>
                        <option {{old('durum',$urun->durum) == 'Sipariş Tamamlandı' ? 'selected' : ''}}}>Sipariş
                            Tamamlandı
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <h3>Sipariş (SP-{{$urun->id}})</h3>
    <table class="table table-bordererd table-hover">
        <tr>
            <th colspan="2">Ürün</th>
            <th>Tutar</th>
            <th>Adet</th>
            <th>Ara Toplam</th>
            <th>Durum</th>
        </tr>
        @foreach($urun->sepet->sepet_urunler as $s)
            <tr>
                <td>
                    <a href="{{route('urun',$s->urun->slug)}}">
                        <img src="{{$s->urun->getUrunDetay->urun_resmi != null ? asset('/urun-resimleri/urunler/'.$s->urun->getUrunDetay->urun_resmi) :
                'https://via.placeholder.com/120x100?text=Resim Bulunamadı'}}" style="width: 140px;">
                    </a>
                </td>
                <td>
                    <a href="{{route('urun',$s->urun->slug)}}">
                        {{$s->urun->urun_adi}}
                    </a>
                </td>
                <td>{{$s->fiyat}}</td>
                <td>{{$s->adet}}</td>
                <td>{{$s->fiyat * $s->adet}}</td>
                <td>{{$s->durum}}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="4" class="text-right">Toplam Tutar</th>
            <td colspan="2">{{$urun->siparis_tutari}}</td>
        </tr>
        <tr>
            <th colspan="4" class="text-right">Toplam Tutar(KDV dahil)</th>
            <td colspan="2">{{$urun->siparis_tutari * ((100+config('cart.tax'))/100)}}</td>
        </tr>
        <tr>
            <th colspan="4" class="text-right">Sipariş Durumu</th>
            <td colspan="2">{{$urun->durum}}</td>
        </tr>


    </table>

@endsection


