@extends('layouts.master')
@section('title','Sepet')
@section('content')
    <div class="container">
        <div class="bg-content">
            <h2>Sepet</h2>
            @include('layouts.partials.alert')
            @if(count(Cart::content())>0)
                <table class="table table-bordererd table-hover">
                    <tr>
                        <th colspan="2">Ürün</th>
                        <th>Adet Fiyatı</th>
                        <th>Adet</th>
                        <th>Tutar</th>
                    </tr>
                    @foreach(Cart::content() as $urunCartItem)
                        <tr>
                        <td>
                            <a href="{{route('urun',$urunCartItem->options->slug)}}">
                                <img src="https://picsum.photos/120/100">
                            </a>
                        </td>
                        <td>
                            <a href="{{route('urun',$urunCartItem->options->slug)}}">
                                {{$urunCartItem->name}}
                            </a>

                            <form action="{{route('sepet.kaldir',$urunCartItem->rowId)}}" method="post">
                                @csrf
                                {{method_field('DELETE')}}
                                <input type="submit" class="btn btn-danger btn-xs" value="Sepetten Kaldır">
                            </form>
                        </td>


                            <td>{{$urunCartItem->price}}</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-default">-</a>
                                <span style="padding: 10px 20px">{{$urunCartItem->qty}}</span>
                                <a href="#" class="btn btn-xs btn-default">+</a>
                            </td>
                            <td class="text-right">
                                {{$urunCartItem->subtotal}}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="text-right">Alt Toplam</th>
                        <td class="text-right"> {{Cart::subtotal()}}</td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">KDV</th>
                        <td class="text-right">{{Cart::tax()}}</td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Genel Toplam </th>
                        <td class="text-right">{{Cart::total()}}</td>
                    </tr>
                </table>
                <a href="#" class="btn btn-info pull-left">Sepeti Boşalt</a>
                <a href="#" class="btn btn-success pull-right btn-lg">Ödeme Yap</a>
            @else
                <p>Sepetinizde Ürün Yok</p>
            @endif
            <div>

            </div>
        </div>
    </div>
@endsection
