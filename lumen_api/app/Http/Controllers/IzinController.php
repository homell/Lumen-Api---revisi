<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// use App\Http\Controllers\AbsenController;

class IzinController extends Controller
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
	
	public function coba()
	{
		app('App\Http\Controllers\AbsenController')->absensi();
		return $absensi->data_scan;
		
	}

	public function izin(Request $request) {
		// $this->validate($request, [
		// 	'unggah_file' 	=> 'required|file|mimes:pdf|max_size:512',
		// 	'keterangan'	=> 'required'
		// ]);

		$nim 				= $request->post('nim');
		$alasan 			= $request->post('alasan');
		$keterangan 		= $request->post('keterangan');
		$tgl_izin 			= $request->post('tglizin');
		$tgl_izin_sampai 	= $request->post('tglizinSampai');
		$unggah_file		= $request->file('unggah_file');

		date_default_timezone_set('Asia/Jakarta');
		$tanggal 	= date("Y-m-d");
		$jam 		= date("H:i:s");
		$tanggal_izin = $tanggal. " ". $jam;

		//Location
		$longitude 	= $request->post('longitude');
		$latitude 	= $request->post('latitude');

		$data_jadwal = DB::table('kuliah')
					//   ->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					//   ->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
                    //   ->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					//   ->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					//   ->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
					  ->select('kuliah.nomor as jadwal_id', 'datamahasiswa.nomor as mahasiswa')
					  ->where('datamahasiswa.nrp', $nim)
					  ->where('kuliah.semester', 1)
					  ->get();

		foreach ($data_jadwal as $value) {
		if ($data_jadwal->isNotEmpty()) {
			if ($nim != NULL && $alasan != NULL && $keterangan != NULL) { //$this->upload->do_upload() == TRUE &&

				$name 		= $unggah_file->getClientOriginalName();
				$path_file	= $request->file('unggah_file')->storeAs('upload_izin', $name);
				
				$data_absen = DB::table('absensi_mahasiswa')
							->select('absensi_mahasiswa.kuliah')
							->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
							->where('datamahasiswa.nrp', $nim)
							->where('absensi_mahasiswa.kuliah', (int)$value->jadwal_id)
							->where('absensi_mahasiswa.tanggal', $tanggal)
							->get();
				if ($data_absen->count() > 0) {
					return response()->json(['status'=> 201, 'message'=> "Anda Sudah Absen"], 201);
				} else {
					$insert_absen = array(
						'mahasiswa' 	=> $value->mahasiswa,
						'kuliah'	 	=> (int)$value->jadwal_id,
						'tanggal' 		=> $tanggal,
						'status' 		=> $alasan
					);
					$last_id = DB::table('absensi_mahasiswa')->insertGetId($insert_absen, 'nomor');
					$insert_izin = array(
						'nrp' 			=> $nim,
						'absen_id' 		=> $last_id,
						'file_upload' 	=> $name,
						'alasan' 		=> $alasan,
						'keterangan' 	=> $keterangan,
						'tanggal' 		=> $tgl_izin,
						'sampai_tanggal'=> $tgl_izin_sampai,
						'status'		=> 'Send'
					);
					DB::table('izin')->insert($insert_izin);

		//========================================================================================//
					// $dsnNip = DB::table('kuliah')->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					// 		->select('kuliah.dosen as dosen_id', 'pegawai.nip as username')
					// 		->where('kuliah.nomor', $value->jadwal_id)
					// 		->get();
					$dsnNip = DB::table('kuliah')->select('kuliah.dosen as dosen_id', 'pegawai.nip as username')
							->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
							->where('kuliah.nomor', $value->jadwal_id)->get();
					$token = $this->DsnToken(isset($dsnNip[0]->username));
					$this->notif($request, $token);
					// $token = $dsnNip[0]->username;
					return response()->json(['status'=> 201, 'message'=> 'Berhasil Menambahkan Izin', 'token'=>$token]);
					
				} 
			} else {
				return response()->json(['status'=> 400, 'message'=> 'Gagal Menambahkan Izin'], 400);
			}
			} 
		}    
	}

	public function index(Request $request) 
	{
		$username = $request->input('username');

		$data_izin = DB::table('izin')
					->join('absensi_mahasiswa', 'absensi_mahasiswa.nomor', 'izin.absen_id')
					->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('datamahasiswa', 'datamahasiswa.nrp', 'izin.nrp')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->select('izin.*', 'datamahasiswa.nama', 'datamahasiswa.nrp as nim',
							DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),
							'matakuliah.matakuliah')
					->where('pegawai.nip', $username)->get();

		if( $data_izin->isNotEmpty() ) {
			return response()->json(['status'=> 200, 'result'=> $data_izin], 200);
		} else {
			return response()->json(['status'=> 500, 'message'=> 'Tidak Ada Mahasiswa Izin'], 500);
		}

	}

	public function deleteizin(Request $request)
	{
		$izin_id = $request->post('izin_id');
		$absen_id = DB::table('izin')->select('absen_id')->where('izin_id', $izin_id)->get();
		$delete = $absen_id[0]->absen_id;
		if( $delete) {

			DB::table('izin')->where('izin_id', $izin_id)->delete();
			// DB::table('absensi_mahasiswa')->where('nomor', $absen_id)->delete();
			// $this->db->query('DELETE FROM tb_absen WHERE absen_id = '.$absen_id.'');

			return response()->json(['status'=> 200, 'message'=> 'Data Berhasil Dihapus']);
		} else {
			return response()->json(['status'=> 500, 'message'=> 'Data Gagal Dihapus']);
		}
		print_r($delete);
	}

	
	public function DsnToken()
	{
		include 'firebase/dbconfig.php';

		$ref = "tokens/dosen/123455";
		$getToken = $database->getReference($ref)
    						 ->getValue();

		return $getToken['token'];
	}
	public function notif(Request $request, $token) {
		define( 'API_ACCESS_KEY', 'mykey');
        $nim = $request->post('nim');
		$curl = curl_init();
		$ids = '["'.$token.'"]';
        // $ids = '["dMrxr65rXrU:APA91bGuPpPNkGiXKVrHiH3Nm5jPj9mfVgZkiQ-NPlVVOEcY4pOxnkBayXuIWlvxL6xSnv3y09ewlVCxcCpxDUONYS9ion-hhO5tT5B_81TPBi_HSqcC9w9HWqnywMJaUYuA3mbbO1V7"]';
        // $id = '['.$ids.']';

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{"registration_ids" : '.$ids.',
              "notification" : {     
                "body"  :  " '.$nim.' Mengirim Surat izin", 
                "title" : "Surat izin Diterima", 
                }
            }',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: key=AAAAiMCqAc4:APA91bFbp43J1ivSpRJuYTBOK7wkOcKb60Q-9qE1CPmYOfZZ5QNDyWs035p5Nsnt1PNDdymMJIdEqMLkO-Zl1fBggTgM2YyaQ0PBGdQKDuJs0elp8W_BryrTJKfdXEKVpXcMeDV5wgyc"
        ),
        ));

        $response = curl_exec($curl);

		// curl_close($curl);
		$err = curl_error($curl);
        // echo $response;
	  }

	  public function suratizin(Request $request)
	  {
		$nim = $request->post('nim');
		$surat_izin = DB::table('izin')->select('*')->where('nrp', $nim)->get();

		if( $surat_izin->isNotEmpty()) {
			return response()->json(['status'=> 200, 'result'=> $surat_izin]);
		} else {
			return response()->json(['status'=> 500, 'message'=> 'Tidak Ada Surat Izin']);
		}

	  }	

	  public function ambildata_izin()
	  {
		$ambil_data = DB::table('izin')
						  ->join('absensi_mahasiswa', 'absensi_mahasiswa.nomor', 'izin.absen_id')
						  ->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
						  ->join('kelas', 'kelas.nomor', 'kuliah.kelas')
						  ->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
						  ->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
						  ->select('datamahasiswa.nrp', 'izin.tanggal', 'izin.sampai_tanggal',
								   DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),'matakuliah.matakuliah',
								   'izin.file_upload', 'izin.alasan')
						  ->where('izin.status', 'Approved')
						  ->get();
		return response()->json($ambil_data);
	  }
}