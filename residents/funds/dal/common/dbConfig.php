<?php
// Change this to your connection info.
if ($_SERVER['DOCUMENT_ROOT'] == 'C:\inetpub\wwwroot') {
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = 'password';
	$DATABASE_NAME = 'nyms_fin_db';
} else {
	$DATABASE_HOST = '160.153.133.77';
	$DATABASE_USER = 'nyms_fin_db_user';
	$DATABASE_PASS = 'L0nd0n!23';
	$DATABASE_NAME = 'nyms_fin_db';
}
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
?>