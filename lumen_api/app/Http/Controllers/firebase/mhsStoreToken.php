<?php
	include 'dbconfig.php';

	$token = $_POST['token'];
	$kelas = $_POST['kelas'];

	$data = [
		'token' => $token,
		'kelas' => $kelas
	];

	$ref = "tokens/";
	$postdata = $database->getReference($ref)->push($data);

	if ($postdata) {
        echo "success";
    } else {
        echo "failed";
    }

?>