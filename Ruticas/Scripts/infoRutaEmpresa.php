<?php
	include "../conexion.php";
	session_start();
	if($_POST){
	  $idRuta = $_POST['ruta'];
	  $sql = "call getNombreEmpresaRutaActivado($idRuta)";
	  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));	  
      $_SESSION['idRuta'] = $idRuta;
      $info[] = array();
    while ($row = $res->fetch_array()){
        array_push($info,[$row["idEmpresa"],$row["nombre"]]);
    }
    $result[] = array("info" => $info);
	  echo json_encode($result);
	}
?>