@extends('yonetim.layouts.master')
@section('title','Kategori Yönetimi')
@section('content')
    <h1>KATEGORİ YÖNETİMİ</h1>

    <h3 class="sub-header">Kategori Listesi</h3>
    <div class="well">
        <div class="btn-group pull-right" role="group" aria-label="Basic example">
            <a href="{{route('yonetim.kategori.yeni')}}" class="btn btn-primary">Yeni Kayıt</a>
        </div>
        <form action="{{route('yonetim.kategori')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan" placeholder="Kategori ara..." value="{{old('aranan')}}">
                <label for="ust_id">Üst Kategori</label>
                <select name="ust_id" id="ust_id" class="form-control">
                    <option value="">Seçiniz</option>
                    @foreach($anakategoriler as $a)
                        <option value="{{$a->id}}" {{old('ust_id')==$a->id ? 'selected' : ''}}>{{$a->kategori_adi}}</option>
                    @endforeach
                </select>
            </div>
                <button type="submit" class="btn btn-primary">Ara</button>
                <a href="{{route('yonetim.kategori')}}" class="btn btn-primary">Temizle </a>
        </form>
    </div>

    @include('layouts.partials.alert')

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Üst Kategori</th>
                <th>Kategori Adı</th>
                <th>Slug</th>
                <th>Kayıt Tarihi</th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="6" class="text-center">Kayıt Bulunamadı</td></tr>
            @endif
            @foreach($list as $l)
                <tr>
                    <td>{{$l->id}}</td>
                    <td>{{$l->ust_kategori->kategori_adi}}</td>
                    <td>{{$l->kategori_adi}}</td>
                    <td>{{$l->slug}}</td>
                    <td>{{$l->created_at}}</td>
                    <td style="width: 100px">
                        <a href="{{route('yonetim.kategori.duzenle',$l->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.kategori.sil',$l->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
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
