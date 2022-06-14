@extends('layouts.v_template')

@section('content')


<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik pemasukan 7 hari terakhir</h4>
                </div>
                <div class="card-body pl-2">
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-sm-12 d-flex justify-content-center align-items-center">
                                <canvas id="chartPemasukan7hariterakhir" width="1700" height="700"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@endsection
@section('script')
<script>
    $(document).ready(function() {

        var date = new Date();

        let hari1YangLalu = date.setDate(date.getDate() - 1);
        let hari2YangLalu = date.setDate(date.getDate() - 1);
        let hari3YangLalu = date.setDate(date.getDate() - 1);
        let hari4YangLalu = date.setDate(date.getDate() - 1);
        let hari5YangLalu = date.setDate(date.getDate() - 1);
        let hari6YangLalu = date.setDate(date.getDate() - 1);
        let hari7YangLalu = date.setDate(date.getDate() - 1);
        const dataPenjualan = {
    labels: [new Date(hari7YangLalu).toISOString().slice(0, 10),new Date(hari6YangLalu).toISOString().slice(0, 10),new Date(hari5YangLalu).toISOString().slice(0, 10),new Date(hari4YangLalu).toISOString().slice(0, 10),new Date(hari3YangLalu).toISOString().slice(0, 10),new Date(hari2YangLalu).toISOString().slice(0, 10),new Date(hari1YangLalu).toISOString().slice(0, 10), new Date().toISOString().slice(0, 10) ],
    datasets: [
        {
        label: 'jumlah uang masuk perhari',
        data: [{{ $penjualan7HariYangLalu }}, {{ $penjualan6HariYangLalu }}, {{ $penjualan5HariYangLalu }}, {{ $penjualan4HariYangLalu }}, {{ $penjualan3HariYangLalu }}, {{ $penjualan2HariYangLalu }}, {{ $penjualan1HariYangLalu }}, {{ $penjualanHariIni }}],
        fill: false,
        borderColor: '#44c',
        backgroundColor: '#2C56E1',
        }
    ]
    };
        var ctx = document.getElementById('chartPemasukan7hariterakhir');
    var myChart = new Chart(ctx, {
    type: 'line',
    data: dataPenjualan,
    options: {
        responsive: true,
        scales: {
        x: {
            display: true,
            title: {
            display: true,
            // text: 'Month',
            color: '#911',
            font: {
                family: 'Comic Sans MS',
                size: 20,
                weight: 'bold',
                lineHeight: 1.2,
            },
            padding: {top: 20, left: 0, right: 0, bottom: 0}
            }
        },
        y: {
            display: true,
            title: {
            display: true,
            text: 'Value',
            color: '#191',
            font: {
                family: 'Times',
                size: 20,
                style: 'normal',
                lineHeight: 1.2
            },
            padding: {top: 30, left: 0, right: 0, bottom: 0}
            }
        }
        }
    },
    });

    });


    $('#liGrafikPemasukan').addClass('active');

</script>
@endsection
