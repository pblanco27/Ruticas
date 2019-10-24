<?php
	include "../conexion.php";
	session_start();

	if($_POST){
	  $idEmpresa     = $_POST['empresa'];
	  $idRuta        = $_POST['ruta'];
	  $costo         = $_POST['costo'];
	  $duracion      = $_POST['duracion'];
	  $discapacitado = $_POST['discapacitado'];
	  $tipo          = $_POST['tipoVinculacion'];
	  $idUser        = $_SESSION['idUser'];
		$horaI 				 = $_POST['horaStart'];
		$horaF 				 = $_POST['horaEnd'];

	  if(!preg_match("/^[0-9]*$/",$costo)){
		$_SESSION["error_costo"] = "El costo solo debe contener números.";
	  }
	  if(!preg_match("/^[0-9]*$/",$duracion)){
		$_SESSION["error_duracion"] = "La duración solo debe contener números.";
	  }
	  if(!isset($_SESSION["error_costo"]) && !isset($_SESSION["error_duracion"])){
		if ($discapacitado){
			$discapacitado = 1;
		} else {
			$discapacitado = 0;
		}
		if ($tipo == "1"){
			$sql = "call actualizarVinculacion($idEmpresa, $idRuta, $duracion, $costo, $discapacitado, $idUser,'$horaI','$horaF')";
		} else {
			$sql = "call linkearRutaEmpresa($idEmpresa, $idRuta, $costo, $duracion, $discapacitado, $idUser,'$horaI','$horaF')";
		}
		$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	  }
	  header("Location: ../asignarRuta.php");
	}
?>
