<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiltermatkulController extends Controller
{

    public function __construct()
    {
        //
    }

    public function filtermatkul(Request $request) {
		$nim = $request->get('nim');
		$data_matkul = DB::table('kuliah')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
					->select('matakuliah.matakuliah', 'matakuliah.kode as kodemk')
					->where('datamahasiswa.nrp', $nim)
					->where('kuliah.semester', 1)
					->distinct()->get();
		return response()->json([
			'status'=> 200, 'result'=> $data_matkul
		], 200);

	}

}
