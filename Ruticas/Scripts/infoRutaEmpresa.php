<?php
	include "../conexion.php";
	session_start();
	if($_POST){
	  $idRuta = $_POST['ruta'];
	  $sql = "call getNombreEmpresaRuta($idRuta)";
	  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));	  
      $_SESSION['idRuta'] = $idRuta;
      $nombres[] = array();
    while ($row = $res->fetch_array()){
        array_push($nombres,$row["nombre"]);
    }
    $result[] = array("nombres" => $nombres);
	  echo json_encode($result);
	}
?>