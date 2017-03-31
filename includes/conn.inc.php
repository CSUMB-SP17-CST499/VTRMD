<?php
function createConn() {
	$db_user = 'user';
	$db_pass = 'password';
	$db_dsn = 'mysql:host=localhost;dbname=ciam1324';
	$conn = new PDO($db_dsn, $db_user, $db_pass);
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}
?>
