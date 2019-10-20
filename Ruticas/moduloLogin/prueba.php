<?php
	$dbServerName = "104.196.172.139";
	$dbUsername = "root";
	$dbPassword = "electiva2019";
	$dbName = "labWeb"; 
	$mysqli = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName); 
	
	if ($mysqli->connect_errno) {
	    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		echo "Conexión establecida exitosamente";
	}
?>