<?php
	include "../conexion.php";
	session_start();

	if($_POST){
		$idDistrito = $_POST['id_distrito'];

		$sql = "call getRutaDistrito($idDistrito)";
		$res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
		$ids[] = array();
		while ($row = $res->fetch_array()){
			array_push($ids, $row["idRuta"]);
		}
		$res->close();
		$conn->next_result();
		$result[] = array("ids" => $ids);
		echo json_encode($result);
	}
?>