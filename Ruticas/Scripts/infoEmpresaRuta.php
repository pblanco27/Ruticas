<?php
	include "../conexion.php";
	session_start();
	if($_POST){
        $idEmpresa = $_POST['emp'];
	  $sql = "call getNombreRutaEmpresa($idEmpresa)";
	  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));	  
      $_SESSION['idRuta'] = $idRuta;
      $nombres[] = array();
      $ids[] = array();
    while ($row = $res->fetch_array()){
        array_push($nombres,$row["numeroRuta"]);
        array_push($ids,$row["idRuta"]);
    }
    $result[] = array("nombres" => $nombres,"ids" => $ids);
	  echo json_encode($result);
	}
?>