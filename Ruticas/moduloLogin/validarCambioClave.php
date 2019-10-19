<?php	
	session_start();	
	
	include "conexion.php";
	$nombreClase = "Conexion";
	$conexion = new $nombreClase;
	
	$errores = $conexion->cambiarClave($_SESSION["nombre_usuario"],
									   $_POST["clave_actual"],
									   $_POST["nueva_clave"],
									   $_POST["confirmar_clave"]);	
	$_SESSION["error_clave_actual"] = $errores["error_clave_incorrecta"];
	$_SESSION["error_nueva_clave"] = $errores["error_clave"];
	$_SESSION["error_confirmacion"] = $errores["error_confirmacion"];
	
	if (!isset($errores["error_clave_incorrecta"]) &&
		!isset($errores["error_clave"]) &&
		!isset($errores["error_confirmacion"])){
		$_SESSION["nuevo"] = 0;
		$_SESSION["mensaje"] = true;
		header("Location:paginaInicio.php");
	} else {
		$_SESSION["nuevo"] = 1;
		header("Location:paginaInicio.php");
	}
?>