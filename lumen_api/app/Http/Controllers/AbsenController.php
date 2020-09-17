<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
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

    public function absensi(Request $request) {
		$nim 	   	= $request->post('nim');
		$data_scan 	= $request->post('dataqr');
		
		date_default_timezone_set('Asia/Jakarta');
		
		$tanggal	=  date("Y-m-d"); 
		// $tanggal	= date("Y-m-d H:i:s");
		$tgl_pilih = substr($data_scan, 0, 10); //Mengambil data sebagian
		$qrcode = substr($data_scan, 10);
		$data_jadwal = DB::table('kuliah')
					->join('kelas', 'kelas.nomor', 'kuliah.kelas')
					->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')
					->join('ruang', 'ruang.nomor', 'kuliah.ruang')
					->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
					->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
					->select('kuliah.nomor as jadwal_id', 'datamahasiswa.nomor as mahasiswa_id', 'ruang.keterangan')
					->where('datamahasiswa.nrp', $nim)
					->where('ruang.keterangan', $qrcode)
					->where('kuliah.semester', 1)
					// ->where($tanggal, '2020-09-1')
					->get();
		// return $data_jadwal;
		if($tanggal > $tgl_pilih) {
			return response()->json(['status'=>500,'message'=>'Absensi Gagal']);
		}
		foreach ($data_jadwal as $value) {
		if ( $data_jadwal->isNotEmpty()) {
			$data_absen = DB::table('absensi_mahasiswa')
						->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
						->where('datamahasiswa.nrp', $nim)
						->where('absensi_mahasiswa.kuliah', $value->jadwal_id)
						->where('absensi_mahasiswa.tanggal', '>=', $tgl_pilih)
						->get();

			if ( $data_absen->isNotEmpty()) {	
				return response()->json(['status'=>403, 'message'=>'Anda Sudah Absen']);
			} else {
				$status = 'Hadir';
				$data = array(
					"mahasiswa" => $value->mahasiswa_id,
					"kuliah" 	=> (int)$value->jadwal_id,
					"tanggal"	=> $tanggal,
					// "jam"		=> $jam,
					"status"	=> $status
				);

				$last_id = DB::table('absensi_mahasiswa')->insertGetId($data, 'nomor');
//===========================================================================================================//

				// $dsnNip = DB::table('kuliah')->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
				// 			->select('kuliah.dosen as dosen_id', 'pegawai.nip as username')
				// 			->where('kuliah.nomor', (int)$value->jadwal_id)->get();
				$dsnNip = DB::table('kuliah')->select('kuliah.dosen as dosen_id', 'pegawai.nip as username')
							->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
							->where('kuliah.nomor', $value->jadwal_id)->get();
				$token = $this->DsnToken(isset($dsnNip[0]->username));
				// $token = $dsnNip[0]->username;
				$this->notif($request, $token);
				return response()->json([
					'status'	=> 200, 
					'message'	=> 'Absensi berhasil',
					'result'	=> $data, 
					'id'		=> $last_id,
					'token'		=> $token
				]);
			}
		} else {
			return response()->json(['status'=>500,'message'=>'Absensi Gagal']);
		}
	}
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
                "body"  :  " '.$nim.' Berhasil Melakukan Presensi", 
                "title" : "Presensi Diterima", 
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
	  }
	
	  public function ambildata_absen()
	  {
		$ambil_data = DB::table('absensi_mahasiswa')
						->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
						->join('kelas', 'kelas.nomor', 'kuliah.kelas')
						->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
						->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
						->select('datamahasiswa.nrp', 'datamahasiswa.nama', 'absensi_mahasiswa.tanggal', 
								DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),'matakuliah.matakuliah',
								'absensi_mahasiswa.status')
						// ->where('absensi_mahasiswa.status', 'Hadir')
						->get();
		return response()->json($ambil_data);
	  }

	  public function ambildata_alfa()
	  {
		$ambil_data = DB::table('absensi_mahasiswa')
						->join('kuliah', 'kuliah.nomor', 'absensi_mahasiswa.kuliah')
						->join('kelas', 'kelas.nomor', 'kuliah.kelas')
						->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
						->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
						->join('datamahasiswa', 'datamahasiswa.nomor', 'absensi_mahasiswa.mahasiswa')
						->select('datamahasiswa.nrp', 'datamahasiswa.nama', 'absensi_mahasiswa.tanggal', 
								DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),'matakuliah.matakuliah',
								'absensi_mahasiswa.status', 'pegawai.nama as dosen')
						->whereIn('absensi_mahasiswa.status', ['Hadir', 'Izin', 'Dispensasi', 'Sakit'])
						->get();
				foreach ($ambil_data as $value) {
					if (count([$value->nrp]) <= 11) {
						$prosentase	= (double)(($ambil_data->count()* 100)/ 14);
						$data = array(
						'dosen'			=> $value->dosen,
						'prosentase'	=> $prosentase,
						'kehadiran'		=> count([$value->nrp]),
						'data'			=> $ambil_data
					);
						return response()->json([$data]);
					} 	
				}
	  }
}
