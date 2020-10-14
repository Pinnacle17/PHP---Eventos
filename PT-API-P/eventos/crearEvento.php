<?php
  require("../headers.php");
  require("../conexion.php");
  $conexion = conexion();
  
  $fecha = date('Y-m-d H:i:s');
  $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
  $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
  $descripcion = mysqli_real_escape_string($conexion, $_POST['desc']);
  $enlace = mysqli_real_escape_string($conexion, $_POST['enlace']);
  $hora_inicio_evento = mysqli_real_escape_string($conexion,$_POST['horario']['inicio']);
  $hora_fin_evento = mysqli_real_escape_string($conexion,$_POST['horario']['cierre']);
  $dia_inicio_evento = mysqli_real_escape_string($conexion,$_POST['fecha']['inicio']);
  $dia_fin_evento= mysqli_real_escape_string($conexion,$_POST['fecha']['cierre']);
  $orden_anuncio = mysqli_real_escape_string($conexion,$_POST['orden']);
  $nombre_busqueda = strtolower($nombre);

  $numimg = count($_FILES['imgsEvento']["name"]);
  $imgs = $_FILES['imgsEvento'];
  $icarousel = $_FILES['imgCarousel']['name'];
  $ruta_carousel = $_FILES['imgCarousel']['tmp_name'];
  $ievento = $_FILES['imgPrincipal']['name'];
  $ruta_ievento = $_FILES['imgPrincipal']['tmp_name'];

  $consulta_insert_evento = "INSERT INTO evento(
  nombre_evento,
  nombre_evento_busqueda,
  creacion_evento, 
  descripcion_evento,
  hora_inicio_evento,
  hora_conclusion_evento,
  dia_inicio_evento,
  dia_conclusion_evento,
  tipo_evento,
  estado_evento,  
  enlace_evento, 
  orden_anuncio, 
  visitas_evento) VALUES(
  '$nombre',  
  '$nombre_busqueda',  
  '$fecha', 
  '$descripcion',
  '$hora_inicio_evento',
  '$hora_fin_evento',
  '$dia_inicio_evento', 
  '$dia_fin_evento',
  '$tipo', 
  '0',
  '$enlace',
  '$orden_anuncio',
  '0')";

  mysqli_query($conexion, $consulta_insert_evento) or die (mysqli_error($conexion));

  $consulta_select_id = "SELECT id_evento FROM evento WHERE nombre_evento = '$nombre'";

  $registros = mysqli_query($conexion, $consulta_select_id) or die (mysqli_error($conexion));

  while ($resultado = mysqli_fetch_array($registros)){
      $id_evento = $resultado["id_evento"];
  }

  $carpeta_evento = "../../admin/assets/img/eventos/".$id_evento;
  mkdir($carpeta_evento, 0777, true);

  $carpeta_ievento = "../../admin/assets/img/eventos/".$id_evento."/"."principal";
  mkdir($carpeta_ievento, 0777, true);

  $carpeta_icarousel = "../../admin/assets/img/eventos/".$id_evento."/"."carousel";
  mkdir($carpeta_icarousel, 0777, true);

  $carpeta_imgs = "../../admin/assets/img/eventos/".$id_evento."/"."imgs";
  mkdir($carpeta_imgs, 0777, true);

  $dircarousel = $carpeta_icarousel."/".$icarousel;
  $direvento = $carpeta_ievento."/".$ievento;

  move_uploaded_file($ruta_carousel, $dircarousel);
  move_uploaded_file($ruta_ievento, $direvento);

  $dircarousel = $id_evento."/carousel"."/".$icarousel;
  $direvento = $id_evento."/principal"."/".$ievento;

  $consulta_update_evento = "UPDATE evento SET carousel_img = '$dircarousel', evento_img = '$direvento' WHERE id_evento = '$id_evento'";
  mysqli_query($conexion, $consulta_update_evento) or die (mysqli_error($conexion));

  for($x=0; $x<$numimg; $x++){

      $nombre_img = $imgs["name"][$x];
      $ruta_img = $imgs["tmp_name"][$x];

      $dir_imgs = $carpeta_imgs."/".$nombre_img;
      move_uploaded_file($ruta_img, $dir_imgs);  

      $dir_imgs = $id_evento."/imgs"."/".$nombre_img;

      $consulta_insert_imgs = "INSERT INTO imagen_eve (ruta_imagen_eve, fk_evento_img) VALUES('$dir_imgs' ,'$id_evento')";
      mysqli_query($conexion, $consulta_insert_imgs) or die(mysqli_error($conexion));
      
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