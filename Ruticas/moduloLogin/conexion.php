<?php
	include "validacion.php";
	
	class Conexion {
		private $conexion = null;
		
		public function __construct(){
			$dbServerName = "35.232.166.32";
			$dbUsername = "cs";
			$dbPassword = "compusociedad";
			$dbName = "labWeb"; 
			$this->conexion = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName); 
			mysqli_set_charset($this->conexion,"utf8");
		}
		
		public function __destruct(){
			$this->conexion->close();
		}
		
		public function getConexion(){
			return $conexion;
		}	
		
		public function compararString($st1, $st2){
			return ($st1 == $st2);
		}
		
		public function buscarUsuario($nombreUsuario){
			$chequeo = "CALL checkUsuario('$nombreUsuario')";
				
			$res = $this->conexion->query($chequeo);
			$row = mysqli_fetch_assoc($res);
			
			if ($row['existe'] == 1){
				$res->close();
				$this->conexion->next_result();
				$chequeo = "CALL getClave('$nombreUsuario')";
			
				$res = $this->conexion->query($chequeo);
				$row = mysqli_fetch_assoc($res);

				return $row['contrasena'];				
			} else {
				return "";
			}
		}
		
		public function verificarUsuario($nombreUsuario, $claveIngresada){
			$nombreClase = "Validacion";
			$validador = new $nombreClase;
			
			$validador->validarLogin($nombreUsuario, $claveIngresada);
			$errores = $validador->getErrores();			
			
			if ($errores == []){
				$contrasena = $this->buscarUsuario($nombreUsuario);
				if ($contrasena == ""){
					$errores["error_nombre_usuario_inexistente"] = "El nombre de usuario ingresado no existe.";
				} else if ($contrasena != $claveIngresada){
					$errores["error_clave_incorrecta"] = "La contraseña ingresada no corresponde a dicho usuario.";						
				}	
			} 			
			return $errores;			
		}
		
		public function registrarUsuario($nombre,
										 $apellido1,
										 $apellido2,
										 $nombre_usuario,
										 $correo,
										 $num_celular,
										 $num_telefono,
										 $clave,
										 $confirmar_clave){
			$nombreClase = "Validacion";
			$validador = new $nombreClase;
			
			$validador->validarRegistro($nombre,
									   $apellido1,
									   $apellido2,
									   $nombre_usuario,
									   $correo,
									   $num_celular,
									   $num_telefono,									   
									   $clave,
									   $confirmar_clave);			
			$errores = $validador->getErrores();			
			
			if ($errores == []){
				$chequeo = "CALL checkUsuario('$nombre_usuario')";
				
				$res = $this->conexion->query($chequeo);
				$row = mysqli_fetch_assoc($res);
				
				if ($row['existe'] == 1){
					$errores["error_nombre_usuario_repetido"] = "El usuario ingresado ya existe. Pruebe con uno distinto.";
				} else {
					$res->close();
					$this->conexion->next_result();
					$registrar = "CALL registrarUsuario('$nombre',
														'$apellido1',
														'$apellido2',
														'$nombre_usuario',
														'$correo',
														'$num_celular',
														'$num_telefono',
														'$clave')";				
					$this->conexion->query($registrar);
				}				
			} 			
			return $errores;
		}
		
		public function cambiarClave($nombre_usuario, $clave_actual, $nueva_clave, $confirmar_clave){
			$nombreClase = "Validacion";
			$validador = new $nombreClase;
			
			$validador->validarCambioClave($nueva_clave, $confirmar_clave);
			$errores = $validador->getErrores();			
			
			if ($errores == []){
				$chequeo = "CALL getClave('$nombre_usuario')";
			
				$res = $this->conexion->query($chequeo);
				$row = mysqli_fetch_assoc($res);				
				
				if ($row['contrasena'] != $clave_actual){
					$errores["error_clave_incorrecta"] = "La contraseña ingresada no corresponde a dicho usuario.";						
				} else {
					$res->close();
					$this->conexion->next_result();
					$cambio = "CALL cambiarContrasena('$nombre_usuario', '$nueva_clave')";
					$this->conexion->query($cambio);
				}		
			} 			
			return $errores;			
		}
	}
?>