<?php
	include "../conexion.php";
	session_start();

	$idRuta = $_POST['ruta'];
	$idEmpresa = $_POST['empresa'];
	$sql = "call getVinculacionIndividual($idRuta, $idEmpresa)";
	$res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	$row = mysqli_fetch_assoc($res);
	$info[] = array("duracion" => $row["duracion"], "costo" => $row["costo"],
				    "discapacitado" => $row["discapacitado"],"horaI" => $row["horarioInicio"],"horaF" => $row["horarioFin"]);
	echo json_encode($info);
?>
