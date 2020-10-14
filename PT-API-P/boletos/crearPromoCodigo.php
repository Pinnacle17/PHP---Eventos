<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $codigo = mysqli_real_escape_string($conexion, $_POST['codigo']);
    $stock = mysqli_real_escape_string($conexion, $_POST['inventario']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $boleto = mysqli_real_escape_string($conexion, $_POST['id_boleto']);

    $consulta = "INSERT INTO promo_cod(codigo, cantidad_cod, cantidad_act_cod, precio_cod, fk_boleto_cod) VALUES ('$codigo','$stock','$stock','$precio','$boleto')";
    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
    
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
