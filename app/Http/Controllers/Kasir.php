<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;


class Kasir extends Controller
{

    public function penjualan()
    {
        $segmentPenjualanPerHari = Penjualan::select('segment', 'tgl_penjualan')->latest()->first();
        $segment = $segmentPenjualanPerHari == null ? 0 : $segmentPenjualanPerHari->segment;
        $data['segment_penjualan_terakhir_hari_ini'] = Penjualan::where('tgl_penjualan', Date('Y-m-d'))->where('segment', $segment)->get();
        return view('pages.penjualan.index', $data);
    }

    public function dataPenjualan()
    {
        $segmentPenjualanPerHari = Penjualan::select('segment', 'tgl_penjualan')->latest()->first();
        $segment = $segmentPenjualanPerHari->segment;
        $data['segment_penjualan_terakhir_hari_ini'] = Penjualan::where('tgl_penjualan', Date('Y-m-d'))->get();
        return view('pages.data_penjualan.index', $data);
    }

    public function savePenjualanBarang(Request $request)
    {
        $segmentPenjualanPerHari = Penjualan::select('segment', 'tgl_penjualan')->latest()->first();
        $segment = 0;
        if (!$segmentPenjualanPerHari || $segmentPenjualanPerHari->tgl_penjualan != date('Y-m-d')) {
            $segment = 1;
        } else {
            $segment = $segmentPenjualanPerHari->segment + 1;
        }

        if ($request->ajax()) {

            $qty = $request->qty;
            $kodeBarang = $request->kode_barang;
            $hargaJual = $request->harga_jual;

            $dataPenjualan = [];
            for ($count = 0; $count < count($kodeBarang); $count++) {
                $data = [
                    'qty' => $qty[$count + 1],
                    'kode_barang' => $kodeBarang[$count],
                    'harga_jual' => $hargaJual[$count]
                ];
                $dataPenjualan[] = $data;
            }

            foreach ($dataPenjualan as $row) {
                $kodeBarang = explode(",", $row['kode_barang'])[0];
                $qty = $row['qty'];
                $hargaJual = $row['harga_jual'];
                Penjualan::create([
                    'kode_barang' => $kodeBarang,
                    'tgl_penjualan' => now(),
                    'qty' => $qty,
                    'harga_jual' => $hargaJual,
                    'bayar' => $request->pembayaran,
                    'jumlah' => $hargaJual * $qty,
                    'segment' => $segment
                ]);

                // update stok
                $barang = Barang::where([
                    ['kode_barang', '=', $kodeBarang]
                ]);

                $stokAkhir = $barang->first()->stok_akhir;
                $barang->update([
                    'stok_akhir' => $stokAkhir - $qty
                ]);
            }


            return 1;
        }
    }
}
