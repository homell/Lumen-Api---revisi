<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoretokendsnController extends Controller
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
		include 'firebase/dbconfig.php';

		$token  = $request->post('token');
		$nip 	= $request->post('nip');

		$data = array(
						'token' 			=> $token,
					);

		$ref = "tokens/dosen/".$nip;
		$postdata = $database->getReference($ref)->set($data);


		if ($postdata) {
	        $message = "success";
	    } else {
	        $message = "failed";
	    }
        return response()->json(['status'=> 201, 'message'=> $message], 201);
	}

	public function DsnToken(Request $request)
	{
		include 'firebase/dbconfig.php';

		$nip = $request->post('nip');
		$ref = "tokens/dosen/".$nip;
		$getToken = $database->getReference($ref)
    						 ->getValue();

		print_r($getToken['token']);
  //   	$arr = [$getToken];
		// print_r($arr);
	}
}
