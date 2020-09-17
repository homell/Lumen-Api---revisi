<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
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
	
	public function ambildata_jadwal()
	{
		$ambil_data = DB::table('kuliah')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					->select('pegawai.nama as dosen','pegawai.nip','matakuliah.matakuliah', 
							DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"), 'ruang.keterangan as ruangan',
							DB::raw("TO_DATE(kuliah.tglnilai) as hari"),
							'kuliah.kehadiran as status', 'jurusan.jurusan')
					->get();
		return response()->json($ambil_data);
	}
	
	public function jadwalmahasiswa(Request $request) {

		$nim = $request->get('nim');

		date_default_timezone_set('Asia/Jakarta');
		$tanggal_skrg = date("Y-m-d");

		/**
		AND tb_jadwal.tanggal BETWEEN DATE_SUB($tanggal_skrg, INTERVAL 3) AND 
		DATE_ADD($tanggal_skrg, INTERVAL 7);

		BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)

		Work : AND tb_jadwal.tanggal  BETWEEN CURDATE() AND DATE_ADD(CURDATE(),INTERVAL 7 DAY)
		**/
		$data_jdwl = DB::table('kuliah')
			->join('kelas', 'kelas.nomor', 'kuliah.kelas')
			->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
			->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
			->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
			->join('ruang', 'ruang.nomor', 'kuliah.ruang')
			->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
			->select('pegawai.nama as dosen', 'matakuliah.matakuliah', 'ruang.keterangan as ruangan',
					DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"), 
					// DB::raw("TO_DATE(kuliah.tglnilai, '%d-%m-%Y') as hari"),
					'kuliah.nomor', 'kuliah.kehadiran as status', 'jurusan.jurusan')
			// ->select('pegawai.nama')
			->where('datamahasiswa.nrp', $nim)
			->where('kuliah.semester', 1)
			->orderBy('datamahasiswa.nrp', 'ASC')
			->get();

		if( $data_jdwl->isNotEmpty() ) {
			return response()->json(['status' => 200, 'result' => $data_jdwl], 200);
		} else {
			return response()->json(['status' => 500, 'result' => 'Jadwal perkuliahan kosong'], 500);
		}
	}

	public function jadwaldosen(Request $request) 
	{
		$username = $request->get('username');
		$data_jadwal = DB::table('kuliah')
			->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
			->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
			->join('ruang', 'ruang.nomor', 'kuliah.ruang')
			->join('kelas', 'kelas.nomor', 'kuliah.kelas')
			// ->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
			->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
			->select('pegawai.nama as dosen','matakuliah.matakuliah', 
					DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"), 'ruang.keterangan as ruangan',
					DB::raw("TO_DATE(kuliah.tglnilai) as hari"),
					'kuliah.kehadiran as status', 'jurusan.jurusan')
			->where('pegawai.nip', $username)
			->where('kuliah.semester', 1)
			->get();

		if( $data_jadwal->isNotEmpty()) {
			return response()->json(['status' => 200, 'result' => $data_jadwal], 200);
		} else {
			return response()->json(['status' => 500, 'message' => 'Jadwal perkuliahan kosong'], 500);
		}
	}

	public function id_dosen()
	{
		$id_absen = DB::table('kuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					// ->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					// ->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					// ->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					->select('kuliah.dosen', 'jurusan.nomor', 'matakuliah.matakuliah')
					->where('kelas.nomor', 775)
					->get();
		return $id_absen;
	}
	 
}