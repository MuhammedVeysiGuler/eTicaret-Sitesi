@extends('yonetim.layouts.master')
@section('title','Kategori Yönetimi')
@section('content')
    <h1>KATEGORİ YÖNETİMİ</h1>

    <form method="post" action="{{route('yonetim.kategori.kaydet',@$kategori->id)}}">
        @csrf
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{@$kategori->id > 0 ? "Güncelle" : "Kaydet"}}
            </button>
        </div>
        <h1 class="sub-header">Kategori {{@$kategori->id > 0 ? "Düzenle" : "Ekle "}}</h1>

        @include('layouts.partials.errors')
        @include('layouts.partials.alert')

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label for="kategoriadi">Üst Kategori</label>
                <select name="ust_id" id="ust_id" class="form-control">
                    <option value="">Ana Kategori</option>
                    @foreach($kategoriler as $k)
                    <option value="{{$k->id}}">{{$k->kategori_adi}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="kategori_adi">Kategori Adı</label>
                <input type="text" class="form-control" id="kategori_adi" placeholder="Kategori Adı" name="kategori_adi" value="{{old('kategori_adi',$kategori->kategori_adi)}}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="hidden" value="{{old('slug',$kategori->slug)}}" name="original_slug">
                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{old('slug',$kategori->slug)}}">
            </div>
        </div>

    </div>
</form>

@endsection
