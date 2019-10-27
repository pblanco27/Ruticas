<?php
include "../conexion.php";
session_start();
if($_POST){
  $fecha = $_POST['inputFecha'];
  $usuario = $_POST['selectUsuarios'];
  $area = $_POST['selectArea'];
  if($fecha == ""){
    $fecha = "-";
  }
  if($area == 0){
    $area = "-";
    echo "Entre";
  }else if ($area == 1) {
    $area = "Empresa";
  }else {
    $area = "Ruta";
  }
  $sql = "call getLog($usuario,'$area','$fecha')";
  echo $sql;
  $res = $conn->query($sql) or die ('Unable to execute query. '. mysqli_error($conn));
  $str = "";
  $table = "";
  while ($row = $res->fetch_array()) {
    $table .="
    <tr>
      <td>".$row['fecha']."</td>
      <td>".$row['nombreTabla']."</td>
      <td>".$row['accion']."
      <td>".$row['usuario']."</td>
    </tr>";
  }
  $_SESSION['tablaLog'] = $table;
  header("Location: ../log.php");
}
 ?>
