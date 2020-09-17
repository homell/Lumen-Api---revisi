<?php 
	include 'dbconfig.php';

	$ref = "tokens/";
	$getToken = $database->getReference($ref)
						 ->orderByChild("kelas")
			             ->equalTo("1A")

			             ->limitToFirst(1)
			             ->getSnapshot();

	print_r($getToken);
?>