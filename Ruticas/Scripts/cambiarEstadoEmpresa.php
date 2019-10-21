<?php
	include "../conexion.php";
	session_start();
	unset($_SESSION["error_telefono"]);
	unset($_SESSION["error_contacto"]);
	unset($_SESSION["error_lats"]);
	$idEmpresa = $_SESSION['idEmpresa'];
	$idUser = $_SESSION['idUser'];
	$sql = "call deshabilitarEmpresa($idEmpresa,$idUser)";
	$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	header("Location: ../editarEmpresa.php");
?>
