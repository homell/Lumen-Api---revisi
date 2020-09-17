<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UbahjadwalController extends Controller
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

    public function matakuliah(Request $request) {

		$username 	= $request->get('username');
		$matakuliah = $request->get('matakuliah');
		$kelas 		= $request->get('kelas');
		$minggu 	= $request->get('minggu');

		// $username = "'$username'";

		$q_matakuliah = '';
		if( isset($matakuliah) ) {
			$q_matakuliah = DB::table('matakuliah')->select('matakuliah')
							->where('matakuliah', $matakuliah);
		}

		$q_kelas = '';
		if( isset($kelas) ) {
			$q_kelas = DB::table('kelas')->select(DB::raw("concat(kelas, paralel) as kelas"))
					   ->where('kelas', $kelas);
		}

		// $q_minggu = '';
		// if( isset($minggu) ) {
		// 	$q_minggu = " and tb_jadwal.minggu = '$minggu'";
		// }
			$data_matakuliah = DB::table('kuliah')
							->join('matakuliah', 'matakuliah.nomor', 'kuliah.matakuliah')
							->join('kelas', 'kelas.nomor', 'kuliah.kelas')
							->join('pegawai', 'pegawai.nomor', 'kuliah.dosen')
							->join('ruang', 'ruang.nomor', 'kuliah.ruang')
							->join('jurusan', 'jurusan.nomor', 'kelas.jurusan')
							->select('kuliah.nomor as id', 'matakuliah.matakuliah', 
									DB::raw("to_date(kuliah.tglujian) as tanggal"),
									'kuliah.kehadiran as status', 'ruang.keterangan as ruangan',
									DB::raw("concat(kelas.kelas, kelas.paralel) as kelas"),
									'jurusan.alias', 'jurusan.jurusan')
							->where('nip', $username, [$q_matakuliah, $q_kelas])
							->where('kuliah.semester', 1)
							->orderBy('kuliah.nomor', 'ASC')->get();
		return response()->json(['status'=> 200, 'result'=> $data_matakuliah], 200);	
	}

	public function pertemuan(Request $request) {
		$id_jadwal 	= $request->put('id_jadwal');
		$tanggal 	= $request->put('tanggal');
		$dosen 		= $request->put('dosen');

		// $hari = date('D', strtotime($tanggal));

		// $var = '20-04-2012';
		$date = str_replace( '-', '-', $tanggal );
		$hari = date('D', strtotime( $date ) );
		$v_tanggal = date('Y-m-d', strtotime( $date ) );

		switch ($hari) {
			case 'Sun':
			$nama_hari = "Minggu";
			break;
			case 'Mon':			
			$nama_hari = "Senin";
			break;
			case 'Tue':
			$nama_hari = "Selasa";
			break;
			case 'Wed':
			$nama_hari = "Rabu";
			break;
			case 'Thu':
			$nama_hari = "Kamis";
			break;
			case 'Fri':
			$nama_hari = "Jumat";
			break;
			case 'Sat':
			$nama_hari = "Sabtu";
			break;
			default:
			$nama_hari = "";		
			break;
		}

		/** Format tanggal 0000-00-00 set dari Client, dan value btn untuk UI 00-00-0000 **/
		$status_edit = 'Pengganti';
		$data = array(
			'tglujian' 	 => $v_tanggal,
			'hari'	  	 => $nama_hari,	
			'kehadiran'  => $status_edit
		);

		// $this->db->where('jdwl_id', $id_jadwal);
		// $ubah_pertemuan = $this->db->update('tb_jadwal', $data);
		$ubah_pertemuan = DB::table('kuliah')->update($data)->where('nomor', $id_jadwal);

		if( $ubah_pertemuan ) {
			return response()->json(['status'=> 200, 'message'=>'Berhasil Mengupdate Data', 
									 'result'=> $data], 200);

			$token = $request->MhsToken($id_jadwal);
			$this->notif($token, $dosen);
		} else {
			return response()->json(['status'=> 502, 'message'=>'Gagal Update'],502); 
		}
	}

	public function MhsToken($id)
	{
		include 'firebase/dbconfig.php';

		// $getnim = $this->db->query('SELECT nim FROM tb_jdwl_mhs WHERE jadwal_id = '.$id.'')->result();
		$getnim = DB::table('kuliah')
                 ->join('kelas', 'kelas.nomor', 'kuliah.kelas')
                 ->join('datamahasiswa', 'datamahasiswa.kelas', 'kelas.nomor')        
                 ->select('datamahasiswa.nrp')
                 ->where('kuliah.nomor', $id)->get();
  		$nim = [];
  		$token = [];

  		foreach ($getnim as $data) {
  			array_push($nim, $data->nim);
  		}

  		foreach ($nim as $data) {
  			// echo $data;
  			$ref = "tokens/mahasiswa/".$data;
			$getToken = $database->getReference($ref)
    						 	 ->getValue();
    		array_push($token, $getToken['token']);
  		}


		return $token;
	}
	public function notif($ids, $dosen) {
		 define( 'API_ACCESS_KEY', 'mykey');
		 
	     $msg = array
	          (
	            'body'  => 'Jadwal Pertemuan Diubah',
	            'title' => 'Dosen '.$dosen.'',
	            'badge' => '1'
	          );
	    $fields = array
	            (
	                'registration_ids'      => $ids,
	                'priority' 				=> 'high',
	                'notification'  		=> $msg,
	            'badge' => '1'
	            );
	          
	    $headers = array
	            (
	                'Authorization: key=AAAACvL1XDA:APA91bEAnqsNEDB-YLC38EfvYQS7vyuZlxJpo7rgMUHokJzjVo7wYVaXPbtnlJdz1KsXJSI47VOxehslCytkx9R9yKBl_Uz59Ko-Gbx2_bzjA78p6QJRiFOWCsgzDYCwZOFRrAk62H04',
	                'Content-Type: application/json'
	            );
	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        // echo $result;
	        $err = curl_error($ch);
	  }
}