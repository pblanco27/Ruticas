<?php
	include "../conexion.php";
	session_start();

	$idRuta = $_POST['ruta'];
	$idEmpresa = $_POST['empresa'];	
	$sql = "call getVinculacion($idRuta, $idEmpresa)";
	$res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	$row = mysqli_fetch_assoc($res);
	$vinculacion[] = array("existe" => $row["res"]);
	echo json_encode($vinculacion);
?>
