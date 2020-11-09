<?php
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();
    $id_evento = mysqli_real_escape_string($conexion, $_POST['id']);
    
    if(!empty($_FILES['imgs'])){
        $numimg = count($_FILES['imgs']["name"]);
        $consulta_select_imgs = "SELECT *FROM imagen_eve WHERE fk_evento_img  = '$id_evento'";
        $resultado = mysqli_query($conexion, $consulta_select_imgs) or die(mysqli_error($conexion));
        $numimagenes = mysqli_num_rows($resultado);
        $total = $numimagenes + $numimg - 30;
        if($total > 0){
            $mensaje = "Se excede por ".$total." imagenes generales";
            echo json_encode($mensaje);
        }else{
            echo json_encode(true);   
        }
    }else{
        echo json_encode(true);
    }
?>