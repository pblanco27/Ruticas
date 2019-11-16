<?php	
	session_start();	
	
	include "conexion.php";
	$nombreClase = "Conexion";
	$conexion = new $nombreClase;
	
	$errores = $conexion->registrarUsuario($_POST["nombre"],
									       $_POST["apellido1"],
									       $_POST["apellido2"],
									       $_POST["nombre_usuario"],
									       $_POST["correo"],
									       $_POST["num_celular"],
									       $_POST["num_telefono"],
									       $_POST["clave"],
									       $_POST["confirmar_clave"]);										   
	$_SESSION["error_nombre"] = $errores["error_nombre"];
	$_SESSION["error_apellido1"] = $errores["error_apellido1"];	
	$_SESSION["error_apellido2"] = $errores["error_apellido2"];
	$_SESSION["error_nombre_usuario"] = $errores["error_nombre_usuario"];
	$_SESSION["error_nombre_usuario_repetido"] = $errores["error_nombre_usuario_repetido"];
	$_SESSION["error_correo"] = $errores["error_correo"];
	$_SESSION["error_num_celular"] = $errores["error_num_celular"];
	$_SESSION["error_num_telefono"] = $errores["error_num_telefono"];
	$_SESSION["error_clave"] = $errores["error_clave"];
	$_SESSION["error_confirmacion"] = $errores["error_confirmacion"];
	$_SESSION["registrarActivoTitulo"] = "active";
	$_SESSION["registrarActivo"] = "block";	
	$_SESSION["loginActivoTitulo"] = "";
	$_SESSION["loginActivo"] = "none";	
	
	if (!isset($errores["error_nombre"]) &&
	    !isset($errores["error_apellido1"]) &&
		!isset($errores["error_apellido2"]) &&
		!isset($errores["error_nombre_usuario"]) &&
		!isset($errores["error_nombre_usuario_repetido"]) &&
		!isset($errores["error_correo"]) &&
		!isset($errores["error_num_celular"]) &&
		!isset($errores["error_num_telefono"]) &&
		!isset($errores["error_clave"]) &&
		!isset($errores["error_confirmacion"])){
		$_SESSION["mensajeRegistro"] = true;
		$_SESSION["loginActivo"] = "block";
		$_SESSION["loginActivoTitulo"] = "active";
		$_SESSION["registrarActivo"] = "none";
		$_SESSION["registrarActivoTitulo"] = "";
	} else {	
		$_SESSION["loginActivo"] = "none";
		$_SESSION["loginActivoTitulo"] = "";
		$_SESSION["registrarActivo"] = "block";	
		$_SESSION["registrarActivoTitulo"] = "active";
	}	
	header("location:index.php");
?>