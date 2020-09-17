<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PdfviewController extends Controller
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

    public function bacaizin(Request $request) { //$id
		// $nim =  $request->uri->segment('2'); //3
		// $nim = $request->get('nim');
		$nim = '361755401137';
		$query = DB::table('izin')->select('file_upload')->where('nrp', $nim)
				// ->where('izin_id', $id)
				->get(); 
		$file_name = $query[0]->file_upload;
		$file = storage_path() . "/app/upload_izin/".$file_name;
		// $file_path = File::get(storage_path('whatever/file.txt'));
		
		// $file = $file_path.$file_name;
		header('Content-type:application/pdf');
		header('Content-Description:inline;;filename="'.$file.'"');
		header('Content-Transfer-Encoding:binary');
		header('Accept-Range:bytes');
		// $headers = [
		// 		'Content-Type' => 'application/pdf',
		// 		'Content-Description:inline;;filename="'.$file.'"',
		// 		'Content-Transfer-Encoding:binary',
		// 		'Accept-Range:bytes'
		// 	];
		$content = File::get($file);
		echo $content;
		// return response()->download($file, $file_name, $headers);
		// @readfile($file);
	}

	public function change_status(Request $request) {
		$nim 	= $request->post('nim');
		$status 	= array(
			'status' => $request->post('status')
		);
		// $status = $request->post('status');
        $change_status = DB::table('izin')->where('nrp', $nim)->update($status);
		if( $change_status ) {
            return response()->json(['status'=> 200, 'message'=> 'Success'], 200);
		} else {
            return response()->json(['status'=> 502, 'message'=> 'Update Failed'], 502);
		}
	}
}
