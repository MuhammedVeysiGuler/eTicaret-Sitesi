@extends('yonetim.layouts.master')
@section('title','Ürün Yönetimi')
@section('content')
    <h1>ÜRÜN YÖNETİMİ</h1>

    <h3 class="sub-header">Ürün Listesi</h3>
    <div class="well">
        <div class="btn-group pull-right" role="group" aria-label="Basic example">
            <a href="{{route('yonetim.urun.yeni')}}" class="btn btn-primary">Yeni Kayıt</a>
        </div>
        <form action="{{route('yonetim.urun')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ürün ara..." value="{{old('aranan')}}">
                <button type="submit" class="btn btn-primary">Ara</button>
                <a href="{{route('yonetim.urun')}}" class="btn btn-primary">Temizle </a>
            </div>
        </form>
    </div>

        @include('layouts.partials.alert')

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Resim</th>
                <th>Ürün Adı</th>
                <th>Ürün Açıklama</th>
                <th>Ürün Fiyatı</th>
                <th>Slug</th>
                <th>Kayıt Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="7" class="text-center">Kayıt Bulunamadı</td></tr>
            @endif
            @foreach($list as $l)
            <tr>
                <td>{{$l->id}}</td>
                <td>
                    <img src="{{$l->getUrunDetay->urun_resmi != null ? asset('/urun-resimleri/urunler/'.$l->getUrunDetay->urun_resmi) :
                'https://via.placeholder.com/120x120?text=Resim Bulunamadı'}}" style="width: 120px" class="img-responsive">
                </td>
                <td>{{$l->urun_adi}}</td>
                <td>{{$l->aciklama}}</td>
                <td>{{$l->fiyat}}</td>
                <td>{{$l->slug}}</td>
                <td>{{$l->created_at}}</td>
                <td style="width: 100px">
                    <a href="{{route('yonetim.urun.duzenle',$l->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{route('yonetim.urun.sil',$l->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{$list->appends('aranan',old('aranan'))->links('pagination::bootstrap-4')}}
    </div>
@endsection
