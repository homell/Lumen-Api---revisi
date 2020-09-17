<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmbildataController extends Controller
{

    public function ambildata_ruang() {
        $ambil_data = DB::table('ruang')->select('keterangan')
                      ->join('jurusan', 'jurusan.nomor', 'ruang.jurusan')
                      ->where('jurusan.nomor', 1)->get();
        return $ambil_data;
    }

    public function ambildata_dosen()
    {
        $ambil_data = DB::table('pegawai')->select('nip', 'password')->get();
        return $ambil_data;
    }
}
