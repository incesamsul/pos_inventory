<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Retur;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class Kasir extends Controller
{

    public function penjualan()
    {
        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tglPenjualan = $date->format('Y-m-d');
        $jamPenjualan = $date->format('H:i:s');
        $data['tgl_penjualan'] = $tglPenjualan;
        $data['jam_penjualan'] = $jamPenjualan;
        $segmentPenjualanPerHari = Penjualan::select('segment', 'tgl_penjualan')->latest()->first();
        $segment = $segmentPenjualanPerHari == null ? 0 : $segmentPenjualanPerHari->segment;
        $data['segment_penjualan_terakhir_hari_ini'] = Penjualan::where('tgl_penjualan', $tglPenjualan)->where('segment', $segment)->where('id_kasir', auth()->user()->id)->get();
        return view('pages.penjualan.index', $data);
    }

    public function getSegmentPenjualanTerakhirHariIni()
    {
        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tglPenjualan = $date->format('Y-m-d');
        $jamPenjualan = $date->format('H:i:s');
        $data['tgl_penjualan'] = $tglPenjualan;
        $data['jam_penjualan'] = $jamPenjualan;

        $segmentPenjualanPerHari = Penjualan::select('segment', 'tgl_penjualan')->latest()->first();
        $segment = $segmentPenjualanPerHari == null ? 0 : $segmentPenjualanPerHari->segment;
        return json_encode(Penjualan::where('tgl_penjualan', $tglPenjualan)->where('segment', $segment)->where('id_kasir', auth()->user()->id)->get()->load('barang'));
    }

    public function retur()
    {
        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tglPenjualan = $date->format('Y-m-d');
        $jamPenjualan = $date->format('H:i:s');
        $data['tgl_penjualan'] = $tglPenjualan;
        $data['jam_penjualan'] = $jamPenjualan;

        $segmentPenjualanPerHari = Retur::select('segment', 'tgl_retur')->latest()->first();
        $segment = $segmentPenjualanPerHari == null ? 0 : $segmentPenjualanPerHari->segment;
        $data['segment_retur_terakhir_hari_ini'] = Retur::where('tgl_retur', $tglPenjualan)->where('segment', $segment)->where('id_kasir', auth()->user()->id)->get();
        return view('pages.retur.index', $data);
    }

    public function dataKasir($tgl = null)
    {
        if (!$tgl) {
            $tgl = Date('Y-m-d');
        }
        $data['tgl'] = $tgl;
        $data['data_kasir'] = DB::table('penjualan')->selectRaw('*, sum(jumlah) as total')->where('tgl_penjualan', $tgl)->groupBy('segment')->get();
        return view('pages.data_kasir.index', $data);
    }

    public function detailDataKasir($tgl, $segment)
    {
        $data['tgl'] = $tgl;
        $data['segment'] = $segment;
        $data['detail_data_kasir'] = Penjualan::where('tgl_penjualan', $tgl)->where('segment', $segment)->get();
        return view('pages.detail_data_kasir.index', $data);
    }

    public function editDataKasir($tgl, $segment)
    {
        $data['tgl'] = $tgl;
        $data['segment'] = $segment;
        $data['edit_data_kasir'] = Penjualan::where('tgl_penjualan', $tgl)->where('segment', $segment)->get();
        return view('pages.edit_data_kasir.index', $data);
    }

    public function dataPenjualan($tgl = null)
    {
        if (!$tgl) {
            $tgl = Date('Y-m-d');
        }
        $data['tgl'] = $tgl;
        $data['data_penjualan'] = Penjualan::where('tgl_penjualan', $tgl)->get();
        $data['retur'] = Retur::where('tgl_retur', $tgl)->get();
        return view('pages.data_penjualan.index', $data);
    }

    public function cetakDataPenjualan($tgl = null)
    {
        if (!$tgl) {
            $tgl = Date('Y-m-d');
        }
        $segmentPenjualanPerHari = Penjualan::select('segment', 'tgl_penjualan')->latest()->first();
        $segment = $segmentPenjualanPerHari->segment;
        $data['tgl'] = $tgl;
        $data['data_penjualan'] = Penjualan::where('tgl_penjualan', $tgl)->get();
        $html = view('pages.cetak.cetak_data_penjualan', $data);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('Legal', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        exit(0);
    }

    public function cetakFaktur($tgl = null, $segment = 1)
    {
        if (!$tgl) {
            $tgl = Date('Y-m-d');
        }
        $data['tgl'] = $tgl;
        $data['detail_data_kasir'] = Penjualan::where('tgl_penjualan', $tgl)->where('segment', $segment)->get();
        $html = view('pages.cetak.cetak_faktur', $data);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('Legal', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        exit(0);
    }

    public function updatePenjualanBarang(Request $request)
    {
        // var_dump($request->tgl);
        // var_dump($request->kode_barang);
        // die;
        if ($request->ajax()) {

            $qty = $request->qty;
            $kodeBarang = $request->kode_barang;
            $hargaJual = $request->harga_jual;
            $rpdisc = $request->rpdisc;

            $dataPenjualan = [];
            for ($count = 0; $count < count($kodeBarang); $count++) {
                $data = [
                    'qty' => $qty[$count + 1],
                    'kode_barang' => $kodeBarang[$count],
                    'harga_jual' => $hargaJual[$count],
                    'rpdisc' => $rpdisc[$count + 1],
                ];
                $dataPenjualan[] = $data;
            }




            foreach ($dataPenjualan as $row) {
                $kodeBarang = explode(",", $row['kode_barang'])[0];
                $statusBarang = explode(",", $row['kode_barang'])[7];

                $qty = $row['qty'];
                $hargaJual = $row['harga_jual'];
                $penjualan = Penjualan::where([
                    'tgl_penjualan' => $request->tgl,
                    'segment' => $request->segment
                ]);

                // update stok
                // $barang = Barang::where([
                //     ['kode_barang', '=', $kodeBarang]
                // ]);

                // $stokAkhir = $barang->first()->stok_akhir;
                // $barang->update([
                //     'stok_akhir' => $stokAkhir + $qty
                // ]);

                $penjualan->delete();

                // // update stok
                // $barang = Barang::where([
                //     ['kode_barang', '=', $kodeBarang]
                // ]);

                // $stokAkhir = $barang->first()->stok_akhir;
                // $barang->update([
                //     'stok_akhir' => $stokAkhir - $qty
                // ]);
            }

            foreach ($dataPenjualan as $row) {
                $kodeBarang = explode(",", $row['kode_barang'])[0];
                $qty = $row['qty'];
                $rpdisc = $row['rpdisc'];
                $hargaJual = $row['harga_jual'];
                $penjualan = Penjualan::where([
                    'tgl_penjualan' => $request->tgl,
                    'segment' => $request->segment
                ]);


                Penjualan::create([
                    'id_kasir' => auth()->user()->id,
                    'kode_barang' => $kodeBarang,
                    'tgl_penjualan' => $request->tgl,
                    'qty' => $qty,
                    'harga_jual' => $hargaJual,
                    'rpdisc' => $rpdisc,
                    'bayar' => $request->pembayaran == null ? 0 : $request->pembayaran,
                    'jumlah' => $hargaJual * $qty,
                    'segment' => $request->segment
                ]);


                $statusBarang = explode(",", $row['kode_barang'])[7];

                if ($statusBarang == 'baru') {
                    // update stok
                    $barang = Barang::where([
                        ['kode_barang', '=', $kodeBarang]
                    ]);

                    $stokAkhir = $barang->first()->stok_akhir;
                    $barang->update([
                        'stok_akhir' => $stokAkhir - $qty
                    ]);
                }
            }


            return 1;
        }
    }

    public function savePenjualanBarang(Request $request)
    {
        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tglPenjualan = $date->format('Y-m-d');
        $jamPenjualan = $date->format('H:i:s');
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
            $rpdisc = $request->rpdisc;

            $dataPenjualan = [];
            for ($count = 0; $count < count($kodeBarang); $count++) {
                $data = [
                    'qty' => $qty[$count + 1],
                    'kode_barang' => $kodeBarang[$count],
                    'harga_jual' => $hargaJual[$count],
                    'rpdisc' => $rpdisc[$count + 1]
                ];
                $dataPenjualan[] = $data;
            }

            foreach ($dataPenjualan as $row) {
                $kodeBarang = explode(",", $row['kode_barang'])[0];
                $qty = $row['qty'];
                $hargaJual = $row['harga_jual'];
                $rpdisc = $row['rpdisc'];
                Penjualan::create([
                    'id_kasir' => auth()->user()->id,
                    'kode_barang' => $kodeBarang,
                    'tgl_penjualan' => $tglPenjualan,
                    'jam_penjualan' => $jamPenjualan,
                    'qty' => $qty,
                    'harga_jual' => $hargaJual,
                    'rpdisc' => $rpdisc,
                    'bayar' => $request->pembayaran == null ? 0 : $request->pembayaran,
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


    public function saveReturBarang(Request $request)
    {
        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $tglRetur = $date->format('Y-m-d');
        $jamRetur = $date->format('H:i:s');
        $segmentReturPerHari = Retur::select('segment', 'tgl_retur')->latest()->first();
        $segment = 0;
        if (!$segmentReturPerHari || $segmentReturPerHari->tgl_retur != date('Y-m-d')) {
            $segment = 1;
        } else {
            $segment = $segmentReturPerHari->segment + 1;
        }

        if ($request->ajax()) {

            $qty = $request->qty;
            $kodeBarang = $request->kode_barang;
            $hargaJual = $request->harga_jual;
            $rpdisc = $request->rpdisc;

            $dataRetur = [];
            for ($count = 0; $count < count($kodeBarang); $count++) {
                $data = [
                    'qty' => $qty[$count + 1],
                    'kode_barang' => $kodeBarang[$count],
                    'harga_jual' => $hargaJual[$count],
                    'rpdisc' => $rpdisc[$count + 1]
                ];
                $dataRetur[] = $data;
            }

            foreach ($dataRetur as $row) {
                $kodeBarang = explode(",", $row['kode_barang'])[0];
                $qty = $row['qty'];
                $hargaJual = $row['harga_jual'];
                $rpdisc = $row['rpdisc'];
                Retur::create([
                    'id_kasir' => auth()->user()->id,
                    'kode_barang' => $kodeBarang,
                    'tgl_retur' => $tglRetur,
                    'jam_retur' => $jamRetur,
                    'qty' => $qty,
                    'harga_jual' => $hargaJual,
                    'rpdisc' => $rpdisc,
                    'bayar' => $request->pembayaran == null ? 0 : $request->pembayaran,
                    'jumlah' => $hargaJual * $qty,
                    'segment' => $segment
                ]);

                // update stok
                $barang = Barang::where([
                    ['kode_barang', '=', $kodeBarang]
                ]);

                $stokAkhir = $barang->first()->stok_akhir;
                $barang->update([
                    'stok_akhir' => $stokAkhir + $qty
                ]);
            }


            return 1;
        }
    }
}
