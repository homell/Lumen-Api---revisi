<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', 'AuthController@generatekey');
$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');

// Router dan Endpoint pada Lumen API untuk Mahasiswa
$router->post('loginmhs', 'AuthUserController@loginmahasiswa');
$router->get('jadwalmhs', 'JadwalController@jadwalmahasiswa');
$router->post('absensi', 'AbsenController@absensi');
$router->post('izin', 'IzinController@izin'); //--
$router->post('suratizin', 'IzinController@suratizin');
$router->post('deleteizin', 'IzinController@deleteizin');
$router->get('pilihmatkul', 'PilihmatkulController@pilihmatkul');
$router->get('histori', 'HistoriController@histori');
$router->get('filtermatkul', 'FiltermatkulController@filtermatkul');
$router->post('mhstoken', 'StoretokenmhsController@index');
$router->post('notif/{ids}', 'AbsenController@notif');
// $router->post('mhstokenpost', 'StoretokenmhsController@MhsToken_post');

// Router dan Endpoint pada Lumen API untuk Dosen
$router->post('logindsn', 'AuthUserController@logindosen');
$router->get('jadwaldsn', 'JadwalController@jadwaldosen');
$router->get('matakuliah', 'UbahjadwalController@matakuliah');
$router->put('pertemuan/{id_jadwal}', 'UbahjadwalController@pertemuan');
$router->get('historidsn', 'HistoridosenController@historidosen');
$router->put('ubahkehadiran/{absen_id}', 'HistoridosenController@ubahkehadiran_mhs');
$router->get('historimatkul', 'HistoridosenController@matkul');
$router->get('historikelas', 'HistoridosenController@kelas');
$router->get('historijurusan', 'HistoridosenController@jurusan');
$router->get('izindosen', 'IzindosenController@index');
$router->post('deleteizindsn', 'IzindosenController@deleteizin');
$router->put('changestatus/{nim}', 'PdfviewController@change_status');
$router->get('bacaizin/{nim}', 'PdfviewController@bacaizin');
$router->post('dsntoken', 'StoretokendsnController@index');

//Router Get Curl Ambil Data
$router->get('iddosen', 'JadwalController@id_dosen');
$router->post('status', 'CobaController@status');
$router->post('cek', 'CobaController@cek');
$router->get('ambildataruang', 'AmbildataController@ambildata_ruang');
$router->get('ambildatadosen', 'AmbildataController@ambildata_dosen');
$router->get('ambildatamhs', 'AuthUserController@ambildata_mhs');
$router->get('ambildatajadwal', 'JadwalController@ambildata_jadwal');
$router->get('ambildataabsen', 'AbsenController@ambildata_absen');
$router->get('ambildataalfa', 'AbsenController@ambildata_alfa');
$router->get('ambildataizin', 'IzinController@ambildata_izin');

