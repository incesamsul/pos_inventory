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


class General extends Controller
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function dashboard()
    {

        // DATA GRAFIK
        $data['hariIni'] = date('Y-m-d');
        $data['hariYangLalu1'] = date("Y-m-d", strtotime('-1 days'));
        $data['hariYangLalu2'] = date("Y-m-d", strtotime('-2 days'));
        $data['hariYangLalu3'] = date("Y-m-d", strtotime('-3 days'));
        $data['hariYangLalu4'] = date("Y-m-d", strtotime('-4 days'));
        $data['hariYangLalu5'] = date("Y-m-d", strtotime('-5 days'));
        $data['hariYangLalu6'] = date("Y-m-d", strtotime('-6 days'));
        $data['hariYangLalu7'] = date("Y-m-d", strtotime('-7 days'));
        $data['penjualanHariIni'] = Penjualan::where('tgl_penjualan', $data['hariIni'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariIni'])->get()->sum('jumlah');
        $data['penjualan1HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu1'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu1'])->get()->sum('jumlah');
        $data['penjualan2HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu2'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu2'])->get()->sum('jumlah');
        $data['penjualan3HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu3'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu3'])->get()->sum('jumlah');
        $data['penjualan4HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu4'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu4'])->get()->sum('jumlah');
        $data['penjualan5HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu5'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu5'])->get()->sum('jumlah');
        $data['penjualan6HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu6'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu6'])->get()->sum('jumlah');
        $data['penjualan7HariYangLalu'] = Penjualan::where('tgl_penjualan', $data['hariYangLalu7'])->get()->sum('jumlah') - Retur::where('tgl_retur', $data['hariYangLalu7'])->get()->sum('jumlah');
        $data['totalPenjualanKeseluruhan'] = Penjualan::all()->sum('jumlah') - Retur::all()->sum('jumlah');

        $timezone = 'Asia/Makassar';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $data['tgl_sekarang'] = $date->format('Y-m-d');
        $data['jam_sekarang'] = $date->format('H:i:s');
        $data['jumlah_barang'] = Barang::all()->count();
        return view('pages.dashboard.index', $data);
    }

    public function profile()
    {
        $data['user'] = $this->userModel->getUserProfile(auth()->user()->id);
        return view('pages.profile.index', $data);
    }

    public function bantuan()
    {
        return view('pages.bantuan.index');
    }

    public function ubahRole(Request $request)
    {
        User::where('id', auth()->user()->id)
            ->update(['role' => $request->post('role')]);
        return redirect()->back();
    }

    public function ubahFotoProfile(Request $request)
    {

        $extensions = ['jpg', 'jpeg', 'png'];

        $result = array($request->foto->getClientOriginalExtension());

        if (in_array($result[0], $extensions)) {
            $file = $request->foto;
        } else {
            return redirect()->back()->with('error', 'format file tidak di dukung');
        }

        // $fileName = auth()->user()->email . "." . $request->foto->extension();
        $fileName = uniqid() . "." . $request->foto->extension();
        $request->foto->move(public_path('data/foto_profile/' . $fileName . '/'), $fileName);

        // Storage::disk('uploads')->put($fileName, file_get_contents($request->foto->getRealPath()));

        User::where('id', auth()->user()->id)
            ->update(['foto' => $fileName]);
        return redirect()->back();
    }
}
