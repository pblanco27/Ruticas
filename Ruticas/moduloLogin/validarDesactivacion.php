<?php	
	session_start();	
	
	include "../conexion.php";

	$nombre_usuario = $_SESSION["nombre_usuario"];
	$idUsuario = $_SESSION['idUser'];
	$seguro= $_POST['seguro'];
	
	$chequeo = "CALL getClave('$nombre_usuario')";
	$res = $conn->query($chequeo);
	$row = mysqli_fetch_assoc($res);
	
	if ($seguro){
		if ($row['contrasena'] != sha1($_POST["clave_actual"])){
			$_SESSION["error_clave_incorrecta"] = "La contraseña ingresada no corresponde a dicho usuario.";
			header("Location:../start.php");
		} else {
			$res->close();
			$conn->next_result();
			
			$desactivar = "CALL desactivarUsuario($idUsuario)";
			$conn->query($desactivar);
			header("Location:../index.php");
		}
	} else {
		$_SESSION["error_seguro"] = "Debe marcar la casilla correspondiente indicando que está seguro.";
		header("Location: ../start.php");
	}
?>