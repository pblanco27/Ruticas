<?php
	session_start();
	$_SESSION["mostrarMensaje"] = false;

	include "conexion.php";
			
	$nombreP = $_POST["nombre"];
	$apellidoP = $_POST["apellido"];
	$telP = $_POST["tel"];
	$correoP = $_POST["correo"];
	$usuarioP =	$_POST["usuario"];
	$contrasenaP = $_POST["contrasena"];	
	$errorUsuario = "";
	$errorEmail = "";
	$revUser = "CALL checkUsername('$usuarioP')";
	$contadorUser = 0;
			
	
	if ($mysqli->multi_query($revUser)) {
		// almacenar primer juego de resultados 
		if ($result = $mysqli->store_result()){
			while ($row = $result->fetch_array()){	
				$contadorUser = $row["iduser"];
			}
			$result->free();
		}
	}
	$mysqli->close();
	
	include "conexion.php";			
	$revEmail = "CALL checkEmail('$correoP')";
	$contadorEmail = 0;
	if ($mysqli->multi_query($revEmail)) {
		// almacenar primer juego de resultados 
		if ($result = $mysqli->store_result()){
			while ($row = $result->fetch_array()){	
				$contadorEmail = $row["idPerson"];
			}
			$result->free();
		}
	}
	$mysqli->close();
	include "conexion.php";
	if($contadorUser != 0 && $contadorEmail != 0){
		$errorUsuario = "Nombre de usuario ya existe";
		$errorEmail = "Correo ya existente";
		$_SESSION["errorUsuario"] = $errorUsuario;
		$_SESSION["errorEmail"] = $errorEmail;
		header("location:signup.php");
	}
	else if($contadorUser != 0){
		$errorUsuario = "Nombre de usuario ya existe";
		$_SESSION["errorUsuario"] = $errorUsuario;
		$_SESSION["errorEmail"] = "";
		header("location:signup.php");
	}else if($contadorEmail != 0){
		$errorEmail = "Correo ya existente";
		$_SESSION["errorEmail"] = $errorEmail;
		$_SESSION["errorUsuario"] = "";
		header("location:signup.php");
	}
	else{
		$logUser = "CALL newUser('$usuarioP','$contrasenaP');";
		$logPerson = "CALL newPerson('$nombreP','$apellidoP','$telP','$correoP')";
	
		$mysqli->query($logUser); 
		$mysqli->query($logPerson); 
		header("location:login.php");

	}
	
$mysqli->close();
?>