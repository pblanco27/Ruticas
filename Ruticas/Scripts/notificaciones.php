<?php
	include "../conexion.php";
	session_start();
	if($_POST){
      $nombre = $_POST['nombre'];
      $lat = $_POST['latitud'];
      $long = $_POST['longitud'];
      $idUser = $_SESSION['idUser'];
	  $sql = "call crearNotificacion('$nombre',$lat,$long,$idUser)";
	  $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
	  $users_arr = array();
	  $row = mysqli_fetch_assoc($res);
	  $users_arr[] = array();
	  echo json_encode($users_arr);
	}
?>