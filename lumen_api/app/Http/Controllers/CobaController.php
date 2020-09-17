<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function cek(Request $request)
    {
        $data_jadwal = DB::table('kuliah')
        ->join('kelas', 'kelas.nomor', 'kuliah.kelas')
        ->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
        ->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
        ->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
        ->join('ruang', 'ruang.nomor', 'kuliah.ruang')
        ->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					  ->select('kuliah.nomor as jadwal_id', 'datamahasiswa.nomor as mahasiswa', 'matakuliah.matakuliah')
					  ->where('datamahasiswa.nrp', '361755401144')
					  ->where('kuliah.semester', 1)
					  ->get();
        return $data_jadwal;
    }

    public function status(Request $request)
    {
        $data_jadwal = DB::table('kuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
					->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->select('kuliah.nomor as jadwal_id')
					->where('datamahasiswa.nrp', '361755401144')
					// ->where('ruang.keterangan', $qrcode)
					->where('kuliah.semester', 1)
					// ->where($tanggal, '2020-09-1')
                    ->get();
        return $data_jadwal;
    }
    
}
