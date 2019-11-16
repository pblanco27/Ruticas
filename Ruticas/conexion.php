<?php
	$dbServerName = "104.196.172.139";
	$dbUsername = "root";
	$dbPassword = "electiva2019";
	$dbName = "labWeb";
	$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

	/*
	if ($conn->connect_errno) {
	    echo "Falló la conexión a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	} else {
	 	echo "Conexión establecida exitosamente";
	}
	*/
	mysqli_set_charset($conn,"utf8");
?>
