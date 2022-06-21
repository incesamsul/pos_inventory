<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Retur;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class Pimpinan extends Controller
{



    public function grafikPemasukan()
    {

        // DATA GRAFIK
        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $data['tgl_sekarang'] = $date->format('Y-m-d');
        $data['jam_sekarang'] = $date->format('H:i:s');
        $data['jumlah_barang'] = Barang::all()->count();

        $data['hariIni'] = $date->format('Y-m-d');
        $data['hariYangLalu1'] = $date->modify('-1 day')->format('Y-m-d');
        $data['hariYangLalu2'] = $date->modify('-1 day')->format('Y-m-d');
        $data['hariYangLalu3'] = $date->modify('-1 day')->format('Y-m-d');
        $data['hariYangLalu4'] = $date->modify('-1 day')->format('Y-m-d');
        $data['hariYangLalu5'] = $date->modify('-1 day')->format('Y-m-d');
        $data['hariYangLalu6'] = $date->modify('-1 day')->format('Y-m-d');
        $data['hariYangLalu7'] = $date->modify('-1 day')->format('Y-m-d');

        $data['penjualanHariIni'] = Penjualan::where('tgl_penjualan', $data['hariIni'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariIni'])->get()->sum('jumlah');
        $data['penjualan1HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu1'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu1'])->get()->sum('jumlah');
        $data['penjualan2HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu2'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu2'])->get()->sum('jumlah');
        $data['penjualan3HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu3'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu3'])->get()->sum('jumlah');
        $data['penjualan4HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu4'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu4'])->get()->sum('jumlah');
        $data['penjualan5HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu5'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu5'])->get()->sum('jumlah');
        $data['penjualan6HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu6'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu6'])->get()->sum('jumlah');
        $data['penjualan7HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu7'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu7'])->get()->sum('jumlah');
        $data['totalPenjualanKeseluruhan'] = Penjualan::all()->sum('jumlah') - Retur::all()->sum('jumlah');


        return view('pages.grafik_pemasukan.index', $data);
    }
}
