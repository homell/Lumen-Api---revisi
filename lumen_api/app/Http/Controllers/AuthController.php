<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
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

    public function generatekey()
    {
        return Str::random(32);
    }

    public function notif(Request $req)
    {   
        define( 'API_ACCESS_KEY', 'mykey');
        $nim = $req->post('nim');
        $curl = curl_init();
        $ids = '["dMrxr65rXrU:APA91bGuPpPNkGiXKVrHiH3Nm5jPj9mfVgZkiQ-NPlVVOEcY4pOxnkBayXuIWlvxL6xSnv3y09ewlVCxcCpxDUONYS9ion-hhO5tT5B_81TPBi_HSqcC9w9HWqnywMJaUYuA3mbbO1V7"]';

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

        curl_close($curl);
        echo $response;

    }
  
}