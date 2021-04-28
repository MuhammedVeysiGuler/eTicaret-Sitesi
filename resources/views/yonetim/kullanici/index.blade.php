@extends('yonetim.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')
    <h1>KULLANICI YÖNETİMİ</h1>

    <h3 class="sub-header">Kullanıcı Listesi</h3>
    <div class="well">
        <div class="btn-group pull-right" role="group" aria-label="Basic example">
            <a href="{{route('yonetim.kullanici.yeni')}}" class="btn btn-primary">Yeni Kayıt</a>
        </div>
        <form action="{{route('yonetim.kullanici')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Ad, Email ara..." value="{{old('aranan')}}">
                <button type="submit" class="btn btn-primary">Ara</button>
                <a href="{{route('yonetim.kullanici')}}" class="btn btn-primary">Temizle </a>
            </div>
        </form>
    </div>

        @include('layouts.partials.alert')

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ad Soyad</th>
                <th>Email</th>
                <th>Aktfi Mi</th>
                <th>Yönetici Mi</th>
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
                <td>{{$l->adsoyad}}</td>
                <td>{{$l->email}}</td>
                <td>
                    @if($l->aktif_mi)
                        <span class="label label-success">Aktif</span>
                    @else
                        <span class="label label-warning">Aktif Değil</span>
                    @endif
                </td>
                <td>
                    @if($l->yonetici_mi)
                        <span class="label label-success">Yönetici</span>
                    @else
                        <span class="label label-warning">Müşteri</span>
                    @endif
                </td>
                <td>{{$l->created_at}}</td>
                <td style="width: 100px">
                    <a href="{{route('yonetim.kullanici.duzenle',$l->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{route('yonetim.kullanici.sil',$l->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
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
