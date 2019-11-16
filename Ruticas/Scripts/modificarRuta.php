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
		$idDistritoPartida= $_POST['idDistritoPartida'];
		$idDistritoDestino= $_POST['idDistritoDestino'];
		$listo= $_POST['listo'];
		$idRuta = $_POST["idRuta"];

		$puntos = $_POST['puntos'];
		$puntosDecodificados = json_decode($puntos,true);
		$cantidadPuntos = sizeof($puntosDecodificados);
		$latitudInicial = $puntosDecodificados[0]["_latlng"]["lat"];
		$longitudInicial = $puntosDecodificados[0]["_latlng"]["lng"];
		$latitudFinal = end($puntosDecodificados)["_latlng"]["lat"];
		$longitudFinal = end($puntosDecodificados)["_latlng"]["lng"];
		$nombres = $_POST['nombres'];
		$nombresPuntos = json_decode($nombres,true);

		if ($distritoPartida == 0 && $distritoDestino == 0){
			$distritoPartida = $idDistritoPartida;
			$distritoDestino = $idDistritoDestino;
		} else if ($distritoPartida == 0 && $distritoDestino != 0){
			$distritoDestino = $idDistritoDestino;
		} else {
			$distritoPartida = $idDistritoPartida;
		}
		
		if ($listo){
			$sql = "call editarRuta('$numero','$descripcion',$latitudInicial,$longitudInicial,$latitudFinal,$longitudFinal,$idUser,$distritoPartida, $distritoDestino, $idRuta)";			
			$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
			$conn->next_result();
			
			$sql = "call eliminarParadas($idRuta)";
			$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
			$conn->next_result();
			
			for ($i = 0; $i < sizeof($puntosDecodificados); $i++) {
				$latitud = $puntosDecodificados[$i]["_latlng"]["lat"];
				$longitud = $puntosDecodificados[$i]["_latlng"]["lng"];
				$descripcion = $nombresPuntos[$i+1];			
				$sql = "call crearParada($idRuta,$longitud,$latitud,$idUser,'$descripcion')";
				$conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
			}
			header("Location: ../editarRuta.php");
		} else {
			$_SESSION["error_listo"] = "Ingrese la ruta en el mapa y marque la casilla correspondiente";
			header("Location: ../editarRuta.php");
		}
	}
?>