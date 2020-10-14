<?php 
  require("../headers.php");
  require("../conexion.php");
  $conexion = conexion();

  $id_evento =  mysqli_real_escape_string($conexion, $_GET['id']);

  $carpeta_evento = "../../admin/assets/img/eventos";

  $carpeta_ievento = "../../admin/assets/img/eventos/".$id_evento."/"."principal";

  $carpeta_icarousel = "../../admin/assets/img/eventos/".$id_evento."/"."carousel";

  $carpeta_imgs = "../../admin/assets/img/eventos/".$id_evento."/"."imgs";

  $consulta = "SELECT carousel_img, evento_img FROM evento WHERE id_evento='$id_evento'";
  $imgtablaevento = mysqli_query($conexion,$consulta);

  $consulta = "SELECT ruta_imagen_eve FROM imagen_eve WHERE fk_evento_img='$id_evento'";
  $imgextevento = mysqli_query($conexion,$consulta);

  $consulta = "DELETE FROM evento WHERE id_evento= '$id_evento'";
  mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

  $rutacarousel = null;
  $rutaevento = null;
  $ruta_imagen_eve = null; 
  
  if (mysqli_error($conexion)) {
    $mensaje = "No se puede eliminar el evento, en dado caso que lo desee dejar de publicar cancelelo";

  }else{

    while ($fila=mysqli_fetch_array($imgtablaevento)) {
      $rutacarousel=$fila["carousel_img"];
      $ruta_borrar_carousel = $carpeta_evento."/".$rutacarousel; 
      unlink("$ruta_borrar_carousel");
      rmdir($carpeta_icarousel);
      $rutaevento=$fila["evento_img"];
      $ruta_borrar_evento = $carpeta_evento."/".$rutaevento;
      unlink("$ruta_borrar_evento");
      rmdir($carpeta_ievento);
    }

    while ($fila=mysqli_fetch_array($imgextevento)) {
      $ruta_imagen_eve=$fila["ruta_imagen_eve"];
      $ruta = $carpeta_evento."/".$ruta_imagen_eve;
      unlink("$ruta");
    }
    rmdir($carpeta_imgs);
    sleep(1);
    rmdir($carpeta_evento."/".$id_evento);
  }

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