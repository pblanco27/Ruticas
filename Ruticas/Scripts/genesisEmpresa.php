<?php
include "../conexion.php";
session_start();
unset($_SESSION["error_telefono"]);
unset($_SESSION["error_contacto"]);
unset($_SESSION["error_lats"]);
if($_POST){
  $nombre= $_POST['nombre'];
  $zona= $_POST['zona'];
  $direccion= $_POST['direccion'];
  $latitud= $_POST['latitud'];
  $longitud= $_POST['longitud'];
  $correo= $_POST['correo'];
  $horaInicio= $_POST['horaInicio'];
  $horaFin= $_POST['horaFin'];
  $idEmpresa = $_SESSION['idEmpresa'];
  $idUser = $_SESSION['idUser'];
  if($latitud == '' || $longitud == ''){
    $_SESSION["error_lats"] = "Debe de seleccionar un punto en el mapa.";
    header("Location: ../crearEmpresa.php");
  }
  $num_telefono = $_POST['telefono'];
  $num_telefono = str_replace(' ', '', $num_telefono);
  if(!preg_match("/^\+[0-9]*$/",$num_telefono)){
    $_SESSION["error_telefono"] = "El número de teléfono solo debe contener números (a excepción del + del código de área), y debe ser de máximo 45 caracteres.";
    header("Location: ../crearEmpresa.php");
  }
  $num_telefonoC = $_POST['contacto'];
  $num_telefonoC = str_replace(' ', '', $num_telefonoC);
  if(!preg_match("/^\+[0-9]*$/",$num_telefonoC)){
    $_SESSION["error_contacto"] = "El número de teléfono solo debe contener números (a excepción del + del código de área), y debe ser de máximo 45 caracteres.";
    header("Location: ../crearEmpresa.php");
  }
  if(!isset($errores["error_telefono"]) && !isset($errores["error_contacto"])){
    $sql = "call crearEmpresa('$nombre','$zona','$direccion',$latitud,$longitud,'$num_telefono','$correo','$num_telefonoC',$idUser,$horaInicio,$horaFin)";
    $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
    header("Location: ../crearEmpresa.php");
  }
}
?>
