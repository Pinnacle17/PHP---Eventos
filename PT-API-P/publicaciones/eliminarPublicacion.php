<?php 
  require("../headers.php");
  require("../conexion.php");

  $conexion = conexion();
  
  mysqli_query($conexion, "DELETE FROM publicacion WHERE id_publicacion=$_GET[id_publicacion]") or die (mysqli_error($conexion));
  
  class Result {}

  $response = new Result();
  $response->resultado = 'OK';

  echo json_encode($response); 
?>