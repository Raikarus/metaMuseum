<?php
	require 'config.php';
	$conn = "hostaddr={$host} port=5432 dbname={$dbname} user={$user} password={$dbpassword}";
	$dbconn = pg_connect($conn);
?>