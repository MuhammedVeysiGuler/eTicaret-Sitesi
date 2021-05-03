@extends('layouts.master')
@section('title','Siparişler')
@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Siparişler</h2>
            @if(count(array($siparisler))==0)
                <p>Henüz Sipariş Yok</p>
            @endif
            <table class="table table-bordererd table-hover">
                <tr>
                    <th>Sipariş Kodu</th>
                    <th>Tutar</th>
                    <th>Toplam Ürün</th>
                    <th>Durum</th>
                </tr>
                @foreach($siparisler as $s)
                    <tr>
                        <td>SP-{{$s->id}}</td>
                        <td>{{$s->siparis_tutari}}</td>
                        <td>{{$s->sepet->sepet_urun_adet()}}</td>
                        <td>{{$s->durum}}</td>

                        <td><a href="{{route('siparis',$s->id)}}" class="btn btn-sm btn-success">Detay</a></td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection
