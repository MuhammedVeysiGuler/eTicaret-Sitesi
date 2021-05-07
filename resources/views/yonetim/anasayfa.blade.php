@extends('yonetim.layouts.master')
@section('title','Kontrol Panaeli')
@section('content')
    <h1 class="page-header">Kontrol Panali</h1>

    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Bekleyen Sipariş</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['bekleyen_siparis']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Tamamlanan Sipariş</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['tamamlanan_siparis']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Toplam Ürün</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['toplam_urun']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Toplam Kullanıcı</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['toplam_kullanici']}}</h4>
                    <p>Kişi</p>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Çok Satan Ürünler</div>
                <div class="panel-body">
                    <canvas id="chartCokSatan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Aylara Göre Satışlar</div>
                <div class="panel-body">
                    <canvas id="chartAylaraGoreSatislar"></canvas>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"
            integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg=="
            crossorigin="anonymous"></script>

    <script>
        @php
            $labels = "";
            $data = "";
            foreach ($cok_satan_urunler as $a){
                $labels .= "\"$a->urun_adi\",";
                $data .= "$a->adet,";
            }
        @endphp
        var ctx1 = document.getElementById('chartCokSatan').getContext('2d');
        var chartCokSatan = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'Çok Satan Ürünler',
                    data: [{!! $data !!}],
                    borderColor: '#0E31E2',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        stepSize: 1,

                    }
                }
            }
        });


        @php
            $labels = "";
            $data = "";
            foreach ($aylara_gore_satislar as $a){
                $labels .= "\"$a->ay\",";
                $data .= "$a->adet,";
            }
        @endphp
        var ctx2 = document.getElementById('chartAylaraGoreSatislar').getContext('2d');
        var chartAylaraGoreSatislar = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [{!! $labels !!}],
                datasets: [{
                    label: 'Aylara Göre Satışlar',
                    data: [{!! $data !!}],
                    borderColor: 'rgb(14,49,226)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        stepSize: 1,

                    }
                }
            }
        });
    </script>


@endsection
