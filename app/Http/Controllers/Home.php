<?php

namespace App\Http\Controllers;

use App\Models\Loundry;
use Illuminate\Http\Request;

class Home extends Controller
{

    public function cekStatusLoundry($idLoundry = null)
    {
        $data['loundry'] = Loundry::where('id_loundry', $idLoundry)->first();
        $data['id_loundry'] = $idLoundry;
        return view('home.cek_status_loundry', $data);
    }
}
