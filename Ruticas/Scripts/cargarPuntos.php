<?php
	include "../conexion.php";
	session_start();

	if($_POST){
		$idRuta = $_POST['ruta'];

		$sql = "call getParadas($idRuta)";
		$res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
		$puntos[] = array();
		$descripcion[] = array();
		while ($row = $res->fetch_array()){
			array_push($puntos, [$row["latitud"], $row["longitud"]]);
			array_push($descripcion, $row["descripcion"]);
		}
		$res->close();
		$result[] = array("puntos" => $puntos, "descripcion" => $descripcion);
		echo json_encode($result);
	}
?>
