<?php 
	require __DIR__.'/vendor/autoload.php';

	use Kreait\Firebase\Factory;
	use Kreait\Firebase\ServiceAccount;

	$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/absensi-ed6fd-firebase-adminsdk-9iouf-c65964365d.json');
	$factory = (new Factory)
		->withServiceAccount($serviceAccount)
		->withDatabaseUri('https://absensi-ed6fd.firebaseio.com/')
		->create();

	$database = $factory->getDatabase();
?>