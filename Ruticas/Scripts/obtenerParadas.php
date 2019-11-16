<?php
	include "../conexion.php";
	session_start();

	$sql = "call getParadasTodas()";
	$res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	$paradas[] = array();
	while ($row = $res->fetch_array()){
		array_push($paradas, [$row["idRuta"], $row["latitud"], $row["longitud"], $row["descripcion"]]);
	}
	$res->close();
	$result[] = array("paradas" => $paradas);
	echo json_encode($result);
?>