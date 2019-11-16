<?php
	include "../conexion.php";
	session_start();
	unset($_SESSION["error_listo"]);

	if($_POST){
		$idUser = $_SESSION['idUser'];
		$numero= $_POST['numero'];
		$descripcion= $_POST['descripcion'];
		$distritoPartida= $_POST['distritoPartida'];
		$distritoDestino= $_POST['distritoDestino'];
		$listo= $_POST['listo'];

		$puntos = $_POST['puntos'];
		
		$puntosDecodificados = json_decode($puntos,true);
		$cantidadPuntos = sizeof($puntosDecodificados);
		$latitudInicial = $puntosDecodificados[0]["_latlng"]["lat"];
		$longitudInicial = $puntosDecodificados[0]["_latlng"]["lng"];
		$latitudFinal = end($puntosDecodificados)["_latlng"]["lat"];
		$longitudFinal = end($puntosDecodificados)["_latlng"]["lng"];
		
		$nombres = $_POST['nombres'];
		$nombresPuntos = json_decode($nombres,true);
		
		if ($listo){
			$sql = "call crearRuta('$numero','$descripcion',$latitudInicial,$longitudInicial,$latitudFinal,$longitudFinal,$idUser,$distritoPartida, $distritoDestino)";
			$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
			$conn->next_result();
			$sql = "call getMaxRuta()";
			$res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
			$row = mysqli_fetch_assoc($res);
			$idRuta = $row['MAX(idRuta)'];
			$res->close();
			$conn->next_result();
			for ($i = 0; $i < sizeof($puntosDecodificados); $i++) {
				$latitud = $puntosDecodificados[$i]["_latlng"]["lat"];
				$longitud = $puntosDecodificados[$i]["_latlng"]["lng"];
				$descripcion = $nombresPuntos[$i+1];			
				$sql = "call crearParada($idRuta,$longitud,$latitud,$idUser,'$descripcion')";
				$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
			}
			header("Location: ../crearRuta.php");
		} else {
			$_SESSION["error_listo"] = "Ingrese la ruta en el mapa y marque la casilla correspondiente";
			header("Location: ../crearRuta.php");
		}
	}
?>
