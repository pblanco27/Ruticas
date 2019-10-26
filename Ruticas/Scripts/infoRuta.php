<?php
	include "../conexion.php";
	session_start();
	if($_POST){
	  $idRuta = $_POST['ruta'];
	  $sql = "call getRutaIndividualTodos($idRuta)";
	  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));	  
	  $_SESSION['idRuta'] = $idRuta;
	  $users_arr = array();
	  $row = mysqli_fetch_assoc($res);
	  $users_arr[] = array("numeroRuta" => $row['numeroRuta'], "descripcion" => $row['descripcion'],
						   "nombrePartida" => $row['nombre'], "nombreDestino" => $row['nombre2'],
						   "idDistritoPartida" => $row['idDistritoPartida'], "idDistritoDestino" => $row['idDistritoDestino'],"activado" => $row['activado']);
	  echo json_encode($users_arr);
	}
?>
