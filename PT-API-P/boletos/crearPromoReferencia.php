<?php
    //no pueden elegirse a si mismo los boletos ni haber dos promociones con los mismos boletos.
    require("../headers.php");
    require("../conexion.php"); 
    $conexion = conexion();

    $boleto = mysqli_real_escape_string($conexion, $_POST['boleto']);
    $boleto_referencia = mysqli_real_escape_string($conexion, $_POST['boletoReferencia']);
    $cantidad = mysqli_real_escape_string($conexion, $_POST['inventarioReferencia']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precioReferencia']);
    
    $consulta = "INSERT INTO promo_eve(precio_eve, cantidad_eve, cantidad_act_eve, fk_boleto_eve, fk_boleto_ref) VALUES ('$precio', '$cantidad', '$cantidad', '$boleto', '$boleto_referencia')";
    $registro = mysqli_query($conexion,$consulta) or die(mysqli_error($conexion));   

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
