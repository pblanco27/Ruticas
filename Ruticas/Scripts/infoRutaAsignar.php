<?php
	include "../conexion.php";
	session_start();
	if($_POST){
	  $idRuta = $_POST['ruta'];
	  $sql = "call getRutasIndividual($idRuta)";
	  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));	  
	  $_SESSION['idRuta'] = $idRuta;
	  $users_arr = array();
	  $row = mysqli_fetch_assoc($res);
	  $users_arr[] = array("numeroRuta" => $row['numeroRuta'], "descripcion" => $row['descripcion'],
						   "nombrePartida" => $row['nombre'], "nombreDestino" => $row['nombre2']);
	  echo json_encode($users_arr);
	}
?>
