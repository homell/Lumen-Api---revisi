<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IzindosenController extends Controller
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

    public function index(Request $request) 
	{
		$username = $request->input('username');
        $data_izin = DB::table('izin')
					->join('absensi_mahasiswa', 'absensi_mahasiswa.nomor', 'izin.absen_id')
					->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('datamahasiswa', 'datamahasiswa.nrp', 'izin.nrp')
					// ->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->select( 'izin.*', 'datamahasiswa.nama', 'datamahasiswa.nrp as nim',
							DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),
							'matakuliah.matakuliah')
					->where('pegawai.nip', $username)
					->get();

		if( $data_izin->isNotEmpty() ) {
			return response()->json(['status'=> 200, 'result'=> $data_izin]);
		} else {
			return response()->json(['status'=> 500, 'message'=> 'Tidak Ada Mahasiswa Izin']);
		}

	}

	public function deleteizin(Request $request)
	{
        $izin_id = $request->post('izin_id');
		$absen_id = DB::table('izin')->select('absen_id')->where('izin_id', $izin_id)->get()[0]->absen_id;
		// $delete = isset($absen_id);
		if( $absen_id) {

			DB::table('izin')->where('izin_id', $izin_id)->delete();
			DB::table('absensi_mahasiswa')->where('nomor', $absen_id)->delete();
			// $this->db->query('DELETE FROM tb_absen WHERE absen_id = '.$absen_id.'');

			return response()->json(['status'=> 200, 'message'=> 'Data Berhasil Dihapus']);
		} else {
			return response()->json(['status'=> 500, 'message'=> 'Data Gagal Dihapus']);
		}
		print_r($delete);
	}
}
