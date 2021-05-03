@extends('yonetim.layouts.master')
@section('title','Sipariş Yönetimi')
@section('content')
    <h1>SİPARİŞ YÖNETİMİ</h1>

    <h3 class="sub-header">Sipariş Listesi</h3>
    <div class="well">
        <form action="{{route('yonetim.siparis')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Sipariş ara..." value="{{old('aranan')}}">
                <button type="submit" class="btn btn-primary">Ara</button>
                <a href="{{route('yonetim.siparis')}}" class="btn btn-primary">Temizle </a>
            </div>
        </form>
    </div>

        @include('layouts.partials.alert')

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Sipariş Kodu</th>
                <th>Kullanıcı</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Sipariş Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="7" class="text-center">Kayıt Bulunamadı</td></tr>
            @endif
            @foreach($list as $l)
            <tr>
                <td>SP-{{$l->id}}</td>
                <td>{{$l->sepet->kullanici->adsoyad}}</td>
                <td>{{$l->siparis_tutari * ((100 + config('cart.tax'))/100)}} TL </td>
                <td>{{$l->durum}}</td>
                <td>{{$l->created_at}}</td>
                <td style="width: 100px">
                    <a href="{{route('yonetim.siparis.duzenle',$l->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{route('yonetim.siparis.sil',$l->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
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
