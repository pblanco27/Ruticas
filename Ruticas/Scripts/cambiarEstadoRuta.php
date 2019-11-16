<?php
	include "../conexion.php";
	session_start();
	$idRuta = $_SESSION['idRuta'];
	$idUser = $_SESSION['idUser'];
	$sql = "call deshabilitarRuta($idRuta,$idUser)";
	$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	header("Location: ../editarRuta.php");
?>