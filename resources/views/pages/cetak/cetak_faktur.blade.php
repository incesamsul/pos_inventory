<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur penjualan</title>
</head>
<style>

    body{
        font-family: Arial, Helvetica, sans-serif;
    }

    .text-center{
        text-align: center;
    }

    .text-main{
        color: lightblue;
    }
    .m-0{
        margin: 0;
    }

    .mt-50{
        margin-top: 50px;
    }

    .table{
        width: 100%;
        font-size: 12px !important;
    }

    .table.border-bottom tr td{
        border-bottom: 1px solid grey;
    }
</style>
<body>
    <h1 class="text-center m-0">Faktur <span class="text-main">Penjualan</span></h1>
    <h3 class="text-center">Toko Surya Mandiri Sejahtera</h3>
    <table class="table border-bottom mt-50" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama / Kode barang</th>
                <th>Qty</th>
                <th>Harga barang</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                ?>
            @foreach ($detail_data_kasir as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->barang->nama_barang }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>{{ "Rp. ".  number_format($row->barang->harga_jual_1) }}</td>
                    <td>{{ "Rp. " . number_format($row->jumlah) }}</td>
                    <?php $total += $row->jumlah ?>
                </tr>
            @endforeach
                <tr>
                    <th class="text-center" colspan="4">TOTAL</th>
                    <th>{{ 'Rp. '. number_format($total) }}</th>
                </tr>
        </tbody>
    </table>
</body>
</html>
