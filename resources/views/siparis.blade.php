@extends('layouts.master')
@section('title','Sipariş Detayı')
@section('content')
    <div class="container">
        <div class="bg-content">
            <a href="{{route('siparisler')}}" class="btn btn-xs btn-primary">
                <i class="glyphicon glyphicon-arrow-left">Siparişler</i>
            </a>
            <h2>Sipariş (SP-{{$siparis->id}})</h2>
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Tutar</th>
                    <th>Adet</th>
                    <th>Ara Toplam</th>
                    <th>Durum</th>
                </tr>
                @foreach($siparis->sepet->sepet_urunler as $s)
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
                    <td colspan="2">{{$siparis->siparis_tutari}}</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Toplam Tutar(KDV dahil)</th>
                    <td colspan="2">{{$siparis->siparis_tutari * ((100+config('cart.tax'))/100)}}</td>
                </tr>
                <tr>
                    <th colspan="4" class="text-right">Sipariş Durumu</th>
                    <td colspan="2">{{$siparis->durum}}</td>
                </tr>


            </table>
        </div>
    </div>
@endsection
