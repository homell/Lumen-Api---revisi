<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthUserController extends Controller
{
    public function __construct()
    {

    }

    public function ambildata_mhs() {
        $ambil_data = DB::table('datamahasiswa')
					  ->join('kelas', 'kelas.nomor', 'datamahasiswa.kelas')
					  ->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					  ->select('datamahasiswa.nrp', 'datamahasiswa.nama',
							   DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),
							   'jurusan.jurusan')
                      ->get();
		return response()->json($ambil_data);

	}

	public function loginmahasiswa(Request $request) {

		$nim 		= $request->post('nim');
		$password 	= $request->post('password');

		if ( $nim != NULL && $password != NULL) {	

				$data_user = DB::table('datamahasiswa')
							->where('nrp', $nim)->where('password', $password)->get();
				if($data_user->count() > 0) {

					$data = $data_user->all();
					$message = "Login Berhasil";
					return response()->json([
						"status"=> 200, "message"=> $message, "result"=> $data
					], 200);
				} 
				else {
					$message = "Nim atau Password Salah";
					return response()->json([
						"status"  => 403,
						"message" => $message
					]);
				}	
			} 
		else {
			return response()->json([
				'status'=> 500, 'message'=> 'Data Tidak Boleh Kosong'
			], 500);
		}
	}

	public function logindosen(Request $request) {

		$username = $request->post('username');
		$password = $request->post('password');

		if( isset( $username ) && isset( $password ) ) {
			$data_dosen = DB::table('pegawai')
						->where('nip', $username)->where('password', $password);

			if( $data_dosen->count() > 0 ) {
				$data = $data_dosen->get();
				return response()->json([
					'status'=> 200, 'message'=> 'Login Berhasil', 'result'=> $data
				]);
			} else {
				return response()->json([
					'status'=> 400, 'message'=> 'Username atau Password Salah'
				]);
			}
		} else {
			return response()->json([
				'status'=> 500, 'message'=> 'Data Tidak boleh Kosong'
			]);
		}
	}
}
    
