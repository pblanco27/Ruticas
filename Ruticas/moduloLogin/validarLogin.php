<?php	
	session_start();	
	
	include "conexion.php";
	$nombreClase = "Conexion";
	$conexion = new $nombreClase;
	
	$errores = $conexion->verificarUsuario($_POST["nombre_usuario"],
									       $_POST["clave"]);	
	$_SESSION["error_nombre_usuario_login"] = $errores["error_nombre_usuario"];
	$_SESSION["error_nombre_usuario_inexistente"] = $errores["error_nombre_usuario_inexistente"];
	$_SESSION["error_clave_login"] = $errores["error_clave"];	
	$_SESSION["error_clave_incorrecta"] = $errores["error_clave_incorrecta"];	
	$_SESSION["loginActivoTitulo"] = "active";
	$_SESSION["loginActivo"] = "block";	
	$_SESSION["registrarActivoTitulo"] = "";
	$_SESSION["registrarActivo"] = "none";	

	if (!isset($errores["error_nombre_usuario"]) &&
	    !isset($errores["error_nombre_usuario_inexistente"]) && 
		!isset($errores["error_clave"]) &&
		!isset($errores["error_clave_incorrecta"])){
		$_SESSION["nombre_usuario"] = $_POST["nombre_usuario"];
		header("Location:../start.php");
		//header("Location:paginaInicio.php");
	} else {		
		header("Location:index.php");
	}	
?>