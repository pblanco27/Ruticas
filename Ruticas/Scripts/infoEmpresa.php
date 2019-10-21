<?php
	include "../conexion.php";
	session_start();
	if($_POST){
	  $idEmpresa = $_POST['emp'];
	  $sql = "call getEmpresaIndividual($idEmpresa)";
	  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	  $_SESSION['idEmpresa'] = $idEmpresa;
	  $users_arr = array();
	  $row = mysqli_fetch_assoc($res);
	  $users_arr[] = array("contacto" => $row['contactoEmergencia'], "correo" => $row['correo']
							, "fisica" => $row['direccionFisica'], "horario1" => $row['horario1'], "horario2" => $row['horario2']
							, "lat" => $row['latitud'], "long" => $row['longitud']
							, "nombre" => $row['nombre'], "telefono" => $row['telefono']
							, "zona" => $row['zona'], "activado" => $row['activado']);
	  echo json_encode($users_arr);
	}
?>
