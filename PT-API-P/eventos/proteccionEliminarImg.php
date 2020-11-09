<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();
    $id_evento = mysqli_real_escape_string($conexion, $_GET['id_evento']);
    $consulta_select_imgs = "SELECT *FROM imagen_eve WHERE fk_evento_img  = '$id_evento'";
    $resultado = mysqli_query($conexion, $consulta_select_imgs) or die(mysqli_error($conexion));
    $numimagenes = mysqli_num_rows($resultado);
    $total = $numimagenes - 1;
    if($total < 5){
        $mensaje = "No se pueden eliminar la imagen, debe de haber minimo 5";
        echo json_encode($mensaje);
    }else{
        echo json_encode(true);   
    }
?>