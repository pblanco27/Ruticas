<?php
	include "../conexion.php";
	session_start();
	$idEmpresa = $_SESSION['idEmpresa'];
	$idUser = $_SESSION['idUser'];
	$sql = "call deshabilitarEmpresa($idEmpresa,$idUser)";
	$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	header("Location: ../editarEmpresa.php");
?>
