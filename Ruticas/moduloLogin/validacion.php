<?php
	class Validacion {		
		private $errores = [];
	
		public function __construct(){}
		
		public function __destruct(){}
		
		public function getErrores(){
			return $this->errores;
		}
		
		public function limpiarErrores(){
			$this->errores = [];
		}
		
		public function validarLogin($nombre_usuario, $clave){
			$this->limpiarErrores();
			$this->validarNombreUsuario($nombre_usuario);
			$this->validarClave($clave);			
		}	
		
		public function validarRegistro($nombre,
										$apellido1,
										$apellido2,
										$nombre_usuario,
										$correo,
										$num_celular,
										$num_telefono,									   
										$clave,
										$confirmar_clave){
			$this->limpiarErrores();			
			$this->validarNombre($nombre);
			$this->validarApellido1($apellido1);
			$this->validarApellido2($apellido2);			
			$this->validarNombreUsuario($nombre_usuario);
			$this->validarCorreo($correo);			
			$this->validarNumCelular($num_celular);
			$this->validarNumTelefono($num_telefono);			
			$this->validarClave($clave);	
			$this->validarConfirmacion($clave, $confirmar_clave);			
		}
		
		public function validarCambioClave($clave, $confirmar_clave){
			$this->limpiarErrores();			
			$this->validarClave($clave);	
			$this->validarConfirmacion($clave, $confirmar_clave);			
		}	
		
		public function validarNombre($nombre){
			if ($nombre == "") {
				$this->errores["error_nombre"] = "El nombre no puede ir vacío.";
			} else if (!preg_match("/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]*$/", $nombre) || (strlen($nombre)>45)) {
				$this->errores["error_nombre"] = "El nombre solo debe contener letras, y debe ser de máximo 45 caracteres.";
			}
		}
		
		public function validarApellido1($apellido1){
			if ($apellido1 == "") {
				$this->errores["error_apellido1"] = "El primer apellido no puede ir vacío.";
			} else if (!preg_match("/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]*$/", $apellido1) || (strlen($apellido1)>45)) {
				$this->errores["error_apellido1"] = "El primer apellido solo debe contener letras, y debe ser de máximo 45 caracteres.";
			}			
		}
		
		public function validarApellido2($apellido2){
			if ($apellido2 == "") {
				$this->errores["error_apellido2"] = "El segundo apellido no puede ir vacío.";
			} else if (!preg_match("/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ]*$/", $apellido2) || (strlen($apellido2)>45)) {
				$this->errores["error_apellido2"] = "El segundo apellido solo debe contener letras, y debe ser de máximo 45 caracteres.";
			}
		}
		
		public function validarNombreUsuario($nombre_usuario){
			if ($nombre_usuario == "") {
				$this->errores["error_nombre_usuario"] = "El nombre de usuario no puede ir vacío.";
			} else if(!preg_match("/^[a-zA-Z0-9]*$/",$nombre_usuario)|| (strlen($nombre_usuario)>45)){
				$this->errores["error_nombre_usuario"] = "El nombre de usuario solo debe contener letras (sin tildes) y números, y debe ser de máximo 45 caracteres.";
			}
		}
		
		public function validarCorreo($correo){
			if ($correo == "") {
				$this->errores["error_correo"] = "El correo no puede ir vacío.";
			} else if(!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",$correo)|| (strlen($correo)>45)){
				$this->errores["error_correo"] = "El correo debe contener letras (sin tildes) y números, un arroba y un dominio, de máximo 45 caracteres.";
			}
		}	
		
		public function validarNumCelular($num_celular){
			$num_celular = str_replace(' ', '', $num_celular);
			if ($num_celular == "") {
				$this->errores["error_num_celular"] = "El número de celular no puede ir vacío.";
			} else if(!preg_match("/^\+[0-9]*$/",$num_celular) ||(strlen($num_celular)>45)){
				$this->errores["error_num_celular"] = "El número de celular solo debe contener números (a excepción del + del código de área), y debe ser de máximo 45 caracteres.";
			}
		}
		
		public function validarNumTelefono($num_telefono){
			$num_telefono = str_replace(' ', '', $num_telefono);
			if ($num_telefono == "") {
				$this->errores["error_num_telefono"] = "El número de teléfono no puede ir vacío.";
			} else if(!preg_match("/^\+[0-9]*$/",$num_telefono) ||(strlen($num_telefono)>45)){
				$this->errores["error_num_telefono"] = "El número de teléfono solo debe contener números (a excepción del + del código de área), y debe ser de máximo 45 caracteres.";
			}
		}	
		
		public function validarClave($clave){
			if ($clave == "") {	
				$this->errores["error_clave"] = "La clave no puede ir vacía.";
			} else if(!preg_match("/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,45}$/",$clave) || (strlen($clave))>45 || (strlen($clave))<8 ){
				$this->errores["error_clave"] = "La contraseña solo debe ser una combinación de letras mayúsculas, minúsculas (sin tildes) y números, de mínimo 8 caracteres y máximo 45.";
			}
		}
		
		public function validarConfirmacion($clave, $clave2){
			if ($clave2 == ""){
				$this->errores["error_confirmacion"] = "La confirmación de contraseña no puede ir vacía.";
			} else if ($clave != $clave2){
				$this->errores["error_confirmacion"] = "Las contraseñas ingresadas no coinciden.";
			}
		}
	}
?>
