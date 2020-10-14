<?php 
  require("../headers.php");
  require("../conexion.php");

  $conexion = conexion();
  
  mysqli_query($conexion, "UPDATE usuario SET activo = '0' WHERE id_usuario = $_GET[id]") or die (mysqli_error($conexion));
  
  class Result {}

  $response = new Result();

  if(mysqli_error($conexion)){
      $response->resultado = 'ERROR';
  }
  else{
      $response->resultado = 'OK';
  }

  echo json_encode($response);
?>