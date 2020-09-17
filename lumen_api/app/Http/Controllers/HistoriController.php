<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriController extends Controller
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

    public function histori(Request $request) {
		$nim 			= $request->get('nim');
		$matakuliah		= $request->get('matakuliah');
		$tanggalsatu 	= $request->get('tanggalsatu');
		$tanggaldua		= $request->get('tanggaldua');

		$q_matakuliah = '';
		if( isset($matakuliah) ) {
			$q_matakuliah = DB::table('matakuliah')->select('matakuliah')
						->where('matakuliah', $matakuliah)->get();
		}

		// Tanggal 1
		$q_tanggal = '';
		// Tanggal 2
		if( isset($tanggalsatu)) {
			$q_tanggal = DB::table('absensi_mahasiswa')->select('tanggal')
						->where('tanggal', $tanggalsatu);
		}

		if( isset($tanggalsatu) && isset($tanggaldua) ) {
			$q_tanggal = DB::table('absensi_mahasiswa')->select('tanggal')
						->whereBetween('tanggal', [$tanggalsatu, $tanggaldua]);	
		}

		$data_histori = DB::table('absensi_mahasiswa')
					->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
					->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->select('nrp as nim', 'datamahasiswa.nama', 'absensi_mahasiswa.status',
					'matakuliah.matakuliah'
					, DB::raw("TO_DATE(absensi_mahasiswa.tanggal) as hari")
					)
					->where('nrp', $nim, [$q_matakuliah, $q_tanggal])
					// ->where('nrp', $nim. $q_matakuliah)
					// ->where('nrp', $nim)->where('matakuliah.matakuliah', "'$q_matakuliah'")
					->orderBy('tanggal', 'DESC')
					->get();
		return response()->json(['status'=> 200, 'result'=> $data_histori], 200);
	}
}