<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class Pimpinan extends Controller
{



    public function grafikPemasukan()
    {

        $data['hariIni'] = date('Y-m-d');
        $data['hariYangLalu1'] = date("Y-m-d", strtotime('-1 days'));
        $data['hariYangLalu2'] = date("Y-m-d", strtotime('-2 days'));
        $data['hariYangLalu3'] = date("Y-m-d", strtotime('-3 days'));
        $data['hariYangLalu4'] = date("Y-m-d", strtotime('-4 days'));
        $data['hariYangLalu5'] = date("Y-m-d", strtotime('-5 days'));
        $data['hariYangLalu6'] = date("Y-m-d", strtotime('-6 days'));
        $data['hariYangLalu7'] = date("Y-m-d", strtotime('-7 days'));
        $data['penjualanHariIni'] = Penjualan::where('tgl_penjualan', $data['hariIni'])->get()->sum('jumlah');
        $data['penjualan1HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu1'])->get()->sum('jumlah');
        $data['penjualan2HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu2'])->get()->sum('jumlah');
        $data['penjualan3HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu3'])->get()->sum('jumlah');
        $data['penjualan4HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu4'])->get()->sum('jumlah');
        $data['penjualan5HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu5'])->get()->sum('jumlah');
        $data['penjualan6HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu6'])->get()->sum('jumlah');
        $data['penjualan7HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu7'])->get()->sum('jumlah');


        return view('pages.grafik_pemasukan.index', $data);
    }
}
