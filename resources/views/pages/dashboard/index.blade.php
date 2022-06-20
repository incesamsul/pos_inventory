@extends('layouts.v_template')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah total barang </h4>
                    </div>
                    <div class="card-body">
                        {{ number_format($jumlah_barang) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Tgl hari ini</h4>
                    </div>
                    <div class="card-body">
                        {{ $tgl_sekarang }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Waktu sekarang</h4>
                    </div>
                    <div class="card-body">
                        {{ $jam_sekarang }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan hari ini</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualanHariIni) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 1 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan1HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 2 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan2HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 3 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan3HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 4 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan4HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 5 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan5HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 6 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan6HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Penjualan 7 hari yang lalu</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($penjualan7HariYangLalu) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-sack-dollar"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Penjualan Keseluruhan</h4>
                    </div>
                    <div class="card-body">
                        {{ "Rp. " . number_format($totalPenjualanKeseluruhan) }}
                    </div>
                </div>
            </div>
        </div>

    </div>



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




    $('#liDashboard').addClass('active');

</script>
@endsection
