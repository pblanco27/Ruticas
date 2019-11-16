<?php
	include "../conexion.php";
	session_start();

	$idRuta = $_SESSION['idRuta'];
	$idEmpresa = $_SESSION['idEmpresa'];	
	$idUser = $_SESSION['idUser'];
	$sql = "call deshabilitarVinculacion($idEmpresa,$idRuta,$idUser)";
	$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	header("Location: ../asignarRuta.php");
?>
