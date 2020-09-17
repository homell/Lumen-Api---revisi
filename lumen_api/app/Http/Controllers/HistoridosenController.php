<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoridosenController extends Controller
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

    public function historidosen(Request $request) {
		$username 	= $request->get('username');
		$matakuliah = $request->get('matakuliah');
		$kelas 		= $request->get('kelas');
		$minggu 	= $request->get('jurusan');

		// $username = "'$username'";
		$q_matakuliah = '';
		if( isset($matakuliah) ) {
			$q_matakuliah = DB::table('matakuliah')->select('matakuliah = '.$matakuliah.'');
			// ->where('matakuliah = ');
		}
		
		$q_kelas = '';
		if(isset($kelas) ) {
			$q_kelas = DB::table('kelas')->select(DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"))
						->where(DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"), $kelas);
		}

		// $q_minggu = '';
		// if( isset($minggu) ) {
		// 	$q_minggu = " and tb_jadwal.minggu = '$minggu' ";
			
		// }

		$data_histori = DB::table('absensi_mahasiswa')
					->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
					->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					->select('nrp as nim', 'absensi_mahasiswa.nomor as absen_id',
					DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"), 'datamahasiswa.nama', 
					DB::raw("TO_DATE(absensi_mahasiswa.tanggal) as waktu"), 'matakuliah.matakuliah',
					'absensi_mahasiswa.status', 'jurusan.alias')
					->where('kuliah.semester', 1)
					->where('pegawai.nip', $username, [$q_matakuliah, $q_kelas] )
					// ->whereIn('matakuliah.matakuliah', [$matakuliah])
					// ->whereIn('matakuliah.matakuliah', $q_matakuliah, $q_kelas)
					->get();
		return response()->json(['status'=> 200, 'result'=> $data_histori], 200);
		
	}

	public function ubahkehadiran_mhs(Request $request) 
	{

		$absen_id 		= $request->post('absen_id');
		$status_absen 	= $request->post('status_absen');
		$catatan		= $request->post('catatan');

		// $absen_id = (String)$absen_id;
		if( strlen($catatan) == null || '' ) {
			$catatan = null;
		}

		if( $status_absen == "Alfa" ) {
			$data_izin = DB::table('izin')->where('absen_id', $absen_id)->get();

			if( $data_izin->count() > 0 ) {

				DB::table('izin')->where('absen_id', $absen_id)->delete();

			}
			DB::table('absensi_mahasiswa')->where('nomor', $absen_id)->delete();
			return response()->json(['status'=> 200, 'message'=> 'Data Kehadiran Berhasil Dihapus'], 200);
		} else {
			$data_update = array(
				'status' 		=> $status_absen,
				'keterangan'	=> $catatan
			);

			DB::table('absensi_mahasiswa')->where('nomor', $absen_id)->update($data_update);
			return response()->json(['status'=> 200, 'message' => 'Berhasil Ubah Data Kehadiran ke ' . $status_absen], 200);
		}

	}

	public function matkul(Request $request) {

		$username = $request->get('username');

		// $username = "'$username'";

		$data_matkul = DB::table('kuliah')
					  ->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					  ->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					  ->select('matakuliah.matakuliah')
					  ->where('pegawai.nip', $username)
					  ->where('kuliah.semester', 1)->distinct()->get();
		return response()->json(['status'=> 200, 'result'=> $data_matkul], 200);
	}

	public function kelas(Request $request) {

		$username = $request->get('username');

		// $username = "'$username'";

		$data_kelas = DB::table('kuliah')
					 ->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					 ->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					 ->select(DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"))
					 ->where('pegawai.nip', $username)
					 ->where('kuliah.semester', 1)
					 ->distinct()->get();
		return response()->json(['status'=> 200, 'result'=> $data_kelas], 200);
	}

	public function minggu(Request $request) {

		$username = $request->get('username');

		// $username = "'$username'";

		$data_minggu = DB::table('kuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('absensi_mhs_minggu', 'absensi_mhs_minggu.kelas', 'kelas.nomor')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->select('absensi_mhs_minggu.nomor as minggu')
					->where('pegawai.nip', $username)->get();
		return response()->json(['status'=> 200, 'result'=> $data_minggu], 200);	
	}

	public function jurusan(Request $request) {

		$username = $request->get('username');

		// $username = "'$username'";

		$data_jurusan = DB::table('pegawai')
					->join('jurusan', 'jurusan.nomor', 'pegawai.jurusan')
					// ->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					// ->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->select('jurusan.alias')
					->where('pegawai.nip', $username)
					->get();
		return response()->json(['status'=> 200, 'result'=> $data_jurusan], 200);	
	}
}