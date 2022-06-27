<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisLayanan;
use App\Models\Loundry;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Admin extends Controller
{

    protected $userModel;
    protected $profileUserModel;
    protected $kritikSaranModel;
    protected $kuisionerModel;
    protected $penilaianModel;


    public function __construct()
    {
        $this->userModel = new User();
    }

    public function pengguna()
    {
        $data['pengguna'] = $this->userModel->getAllUser();
        return view('pages.pengguna.index', $data);
    }

    public function profileUser()
    {
        $data['user'] = User::all();
        $data['profile'] = $this->profileUserModel->getProfileUser();
        return view('pages.rekaptulasi_data.index', $data);
    }


    public function satuan()
    {
        $data['satuan'] = Satuan::all();
        return view('pages.satuan.index', $data);
    }

    public function pembelian()
    {
        $data['satuan'] = Satuan::all();
        $data['pembelian'] = Barang::paginate(10);
        return view('pages.pembelian.index', $data);
    }

    public function penyesuaianStok()
    {
        $data['satuan'] = Satuan::all();
        $data['pembelian'] = Barang::paginate(10);
        return view('pages.penyesuaian_stok.index', $data);
    }

    public function stokDibawahMinimum()
    {
        $data['barang'] = Barang::where('stok_akhir', '<', 'stok_minimal')->get();
        return view('pages.stok_dibawah_minimum.index', $data);
    }


    public function searchBarang(Request $request)
    {
        $barang = Barang::where('nama_barang', 'LIKE', '%' . $request->keyword . '%')->get();
        return response()->json($barang);
    }

    public function getAllBarang()
    {
        $barang = Barang::all()->load('satuan');
        return response()->json($barang);
    }

    public function savePenyesuaianBarang(Request $request)
    {
        if ($request->ajax()) {

            $stokPenyesuaian = $request->stok_penyesuaian;
            $kodeBarang = $request->kode_barang;

            $dataPenyesuaian = [];
            for ($count = 0; $count < count($kodeBarang); $count++) {

                $data = [
                    'stok_penyesuaian' => $stokPenyesuaian[$count + 1],
                    'kode_barang' => $kodeBarang[$count]
                ];
                $dataPenyesuaian[] = $data;
            }
            foreach ($dataPenyesuaian as $row) {
                $kodeBarang = explode(",", $row['kode_barang'])[0];
                $stokAkhir = explode(",", $row['kode_barang'])[1];
                $stokPenyesuaian = $row['stok_penyesuaian'];
                Barang::where([
                    ['kode_barang', '=', $kodeBarang]
                ])->update([
                    'stok_akhir' => ($stokAkhir + $stokPenyesuaian)
                ]);
            }

            return 1;
        }
    }



    // fetch data user by admin
    function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            if ($request->filter == "") {
                $data['pengguna'] = DB::table('users')
                    ->where('role', '!=', 'Admin')
                    ->Where('name', 'like', '%' . $query . '%')
                    ->Where('email', 'like', '%' . $query . '%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(5);
            } else {
                $data['pengguna'] = DB::table('users')
                    ->where('role', '!=', 'Admin')
                    ->Where('role', '=', $request->filter)
                    ->Where('name', 'like', '%' . $query . '%')
                    ->Where('email', 'like', '%' . $query . '%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(5);
            }

            return view('pages.pengguna.users_data', $data)->render();
        }
    }

    // fetch data pembelian
    function fetchDataPembelian(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);

            $data['pembelian'] = DB::table('barang')
                ->Where('nama_barang', 'like', '%' . $query . '%')
                ->orWhere('barcode', 'like', '%' . $query . '%')
                ->paginate(10);

            return view('pages.pembelian.data_pembelian', $data)->render();
        }
    }


    // CRUD SATUAN

    public function createPembelian(Request $request)
    {
        $box = $request->all();
        $formData =  [];
        parse_str($box['formData'], $formData);
        $barang = Barang::where('kode_barang', $formData['kode_barang']);
        if (!$barang->first()) {
            Barang::create([
                'kode_barang' => $formData['kode_barang'],
                'tgl_masuk' => $formData['tgl_masuk'],
                'nama_barang' => $formData['nama_barang'],
                'barcode' => $formData['barcode'],
                'kode_satuan' => $formData['satuan'],
                'stok_akhir' => $formData['stok'],
                'stok_minimal' => $formData['stok_minimal'],
                'harga_jual_1' => $formData['harga_jual_1'],
                'harga_jual_2' => $formData['harga_jual_2'],
                'harga_jual_3' => $formData['harga_jual_3'],
                'harga_jual_4' => $formData['harga_jual_4'],
                'harga_jual_5' => $formData['harga_jual_5'],
                'batas_volume_harga_jual_2' => $formData['batas_volume_harga_jual_2'],
                'batas_volume_harga_jual_3' => $formData['batas_volume_harga_jual_3'],
                'batas_volume_harga_jual_4' => $formData['batas_volume_harga_jual_4'],
                'batas_volume_harga_jual_5' => $formData['batas_volume_harga_jual_5'],
                'modal' => $formData['harga_beli'],
                'hpp' => $formData['harga_pokok_penjualan'],
            ]);
            return 1;
        } else {
            $barang->update([
                'kode_barang' => $formData['kode_barang'],
                'nama_barang' => $formData['nama_barang'],
                'barcode' => $formData['barcode'],
                'kode_satuan' => $formData['satuan'],
                'stok_akhir' => $formData['stok'],
                'stok_minimal' => $formData['stok_minimal'],
                'harga_jual_1' => $formData['harga_jual_1'],
                'harga_jual_2' => $formData['harga_jual_2'],
                'harga_jual_3' => $formData['harga_jual_3'],
                'harga_jual_4' => $formData['harga_jual_4'],
                'harga_jual_5' => $formData['harga_jual_5'],
                'batas_volume_harga_jual_2' => $formData['batas_volume_harga_jual_2'],
                'batas_volume_harga_jual_3' => $formData['batas_volume_harga_jual_3'],
                'batas_volume_harga_jual_4' => $formData['batas_volume_harga_jual_4'],
                'batas_volume_harga_jual_5' => $formData['batas_volume_harga_jual_5'],
                'modal' => $formData['harga_beli'],
                'hpp' => $formData['harga_pokok_penjualan'],
            ]);
            return 2;
        }
    }

    public function updatePembelian(Request $request)
    {
        $user = Satuan::where([
            ['kode_satuan', '=', $request->id]
        ])->update([
            'kode_satuan' => $request->kode_satuan,
            'nama_satuan' => $request->nama_satuan,
            'jumlah_pcs' => $request->jumlah_pcs,
        ]);
        return redirect()->back()->with('message', 'pelanggan Berhasil di update');
    }

    public function deletePembelian(Request $request)
    {
        Barang::where([
            ['kode_barang', '=', $request->kode_barang]
        ])->delete();
        return 1;
    }


    // CRUD SATUAN

    public function createSatuan(Request $request)
    {
        Satuan::create([
            'kode_satuan' => $request->kode_satuan,
            'nama_satuan' => $request->nama_satuan,
            'jumlah_pcs' => $request->jumlah_pcs,
        ]);
        return redirect()->back()->with('message', 'pelanggan Berhasil di tambahkan');
    }

    public function updateSatuan(Request $request)
    {
        $user = Satuan::where([
            ['kode_satuan', '=', $request->id]
        ])->update([
            'kode_satuan' => $request->kode_satuan,
            'nama_satuan' => $request->nama_satuan,
            'jumlah_pcs' => $request->jumlah_pcs,
        ]);
        return redirect()->back()->with('message', 'pelanggan Berhasil di update');
    }

    public function deleteSatuan(Request $request)
    {
        Satuan::where([
            ['kode_satuan', '=', $request->kode_satuan]
        ])->delete();
        return 1;
    }


    // CRUD PENGGUNA

    public function createPengguna(Request $request)
    {
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->email),
            'role' => $request->tipe_pengguna,
        ]);
        return redirect('/admin/pengguna')->with('message', 'Pengguna Berhasil di tambahkan');
    }

    public function updatePengguna(Request $request)
    {
        $user = User::where([
            ['id', '=', $request->id]
        ])->first();
        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'role' => $request->tipe_pengguna,
        ]);
        return redirect('/admin/pengguna')->with('message', 'Pengguna Berhasil di update');
    }

    public function deletePengguna(Request $request)
    {
        User::destroy($request->post('user_id'));
        return 1;
    }


    public function select2CariBarang(Request $request){
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Barang::where('nama_barang','LIKE',"%$search%")
            		->limit(10)->get()->load('satuan');
        }
        return response()->json($data);
    }

}
