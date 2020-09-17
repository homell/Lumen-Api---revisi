<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PilihmatkulController extends Controller
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

    public function pilihmatkul(Request $request) {	
		$nim 	 = $request->get('nim');
		$tanggal = date('Y-m-d');

		$data_pilih = DB::table('kuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					 ->select('matakuliah.matakuliah', 'kuliah.nomor as jdwl_id')
					 ->where('datamahasiswa.nrp', $nim)
					//  ->where('kuliah.tglujian', $tanggal)
					 ->get();
		return response()->json(['status'=> 200, 'result'=> $data_pilih], 200);

	}
}