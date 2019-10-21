<?php
	include "../conexion.php";
	session_start();
	
	if(!empty($_POST['idProvincia'])){
		$idProvincia = $_POST['idProvincia'];
		$sql_obtener_cantones = "CALL obtenerCantones('$idProvincia');";
		
		$cantonOption="";
		if ($conn->multi_query($sql_obtener_cantones)) {
			if ($result = $conn->store_result()){
				while ($row = $result->fetch_array()){
					$cantonOption.='<option value="'.$row["idCanton"].'">'.$row["nombre"].'</option>';
				}
				$result->free();
			}
		}		
		if($cantonOption!=""){
			echo '<option value="">Seleccione un cantón</option>'.$cantonOption;
		}else{
			echo '<option value="">No hay cantones disponibles</option>';
		}		
	} else if(!empty($_POST['idCanton'])){
		$idCanton = $_POST['idCanton'];
		$sql_obtener_distrito = "CALL obtenerDistritos('$idCanton');";
		
		$distritoOption="";
		if ($conn->multi_query($sql_obtener_distrito)) {
			if ($result = $conn->store_result()){
				while ($row = $result->fetch_array()){
					$distritoOption.='<option value="'.$row["idDistrito"].'">'.$row["nombre"].'</option>';
				}
				$result->free();
			}
		}		
		if($distritoOption!=""){
			echo '<option value="">Seleccione un distrito</option>'.$distritoOption;
		}else{
			echo '<option value="">No hay distritos disponibles</option>';
		}
	}
?>
