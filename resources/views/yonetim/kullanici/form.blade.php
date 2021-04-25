@extends('yonetim.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')
    <h1>KULLANICI YÖNETİMİ</h1>

    <form method="post" action="{{route('yonetim.kullanici.kaydet',@$kullanici->id)}}">
        @csrf
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{@$kullanici->id > 0 ? "Güncelle" : "Kaydet"}}
            </button>
        </div>
        <h1 class="sub-header">Kullanıcı {{@$kullanici->id > 0 ? "Düzenle" : "Ekle "}}</h1>

        @include('layouts.partials.errors')
        @include('layouts.partials.alert')

        <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="adsoyad">Ad Soyad</label>
                <input type="text" class="form-control" id="adsoyad" placeholder="Ad Soyad" name="adsoyad" value="{{old('adsoyad',$kullanici->adsoyad)}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{old('email',$kullanici->email)}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="sifre">Şifre</label>
                <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre">
            </div>
        </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" id="adres" placeholder="Adres" name="adres" value="{{old('adres',$kullanici->detay->adres)}}">
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" id="telefon" placeholder="Telefon" name="telefon" value="{{old('telefon',$kullanici->detay->telefon)}}">
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                    <label for="ceptelefonu">Cep Telefonu</label>
                    <input type="text" class="form-control" id="ceptelefonu" placeholder="Cep Telefonu" name="ceptelefonu" value="{{old('ceptelefonu',$kullanici->detay->cepTelefonu)}}">
                </div>
            </div>

    </div>
    <div class="checkbox">
        <label>
            <input type="hidden" name="aktif_mi" value="0">
            <input type="checkbox" name="aktif_mi" value="1" {{old('aktif_mi',$kullanici->aktif_mi ? 'checked' : "")}}> Aktif Mi
        </label>

        <label>
            <input type="hidden" name="yonetici_mi" value="0">
            <input type="checkbox" name="yonetici_mi" value="1" {{old('yonetici_mi',$kullanici->yonetici_mi ? 'checked' : "")}} > Yönetici Mi
        </label>
    </div>
</form>

@endsection
