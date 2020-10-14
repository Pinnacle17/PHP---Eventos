<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion(); 
    
    class Result {}
    
    $response = new Result();
    
    $boleto = mysqli_real_escape_string($conexion, $_POST['id_boleto']);
    $cantidad = mysqli_real_escape_string($conexion, $_POST['inventario']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $fec_ini = mysqli_real_escape_string($conexion, $_POST['fechaInicio']);
    $fec_fin = mysqli_real_escape_string($conexion, $_POST['fechaFin']);

    $consulta = "SELECT fk_evento_bol FROM boleto WHERE id_boleto = '$boleto'";
    $registro = mysqli_query($conexion, $consulta)  or die(mysqli_error($conexion));
    while ($fila=mysqli_fetch_array($registro)) {
        $id_evento=$fila["fk_evento_bol"];
    }

    $consulta = "SELECT * FROM evento WHERE id_evento = '$id_evento'";
    $registro = mysqli_query($conexion, $consulta)  or die(mysqli_error($conexion));
    while ($fila=mysqli_fetch_array($registro)) {
        $inicio=$fila["dia_inicio_evento"];
        $conclusion=$fila["dia_conclusion_evento"];
    }
    
    if(($inicio <= $fec_ini) && ($conclusion >= $fec_fin)){
        $consulta = "SELECT * FROM promo_fec WHERE fk_boleto_fec = '$boleto' AND fec_ini_pro <= '$fec_ini' AND fec_fin_pro >= '$fec_fin'";
        $registro2 = mysqli_query($conexion, $consulta)  or die(mysqli_error($conexion));
        if(mysqli_num_rows($registro2) >= 1){
            $response->mensaje = "No se puede agregar esta promocion, ya hay una existente con estos parametros";
            $response->estado = 0;
        }else{
            $consulta = "INSERT INTO promo_fec(fec_ini_pro, fec_fin_pro, precio_fec, cantidad_fec, cantidad_act_fec, fk_boleto_fec) VALUES ('$fec_ini','$fec_fin','$precio','$cantidad','$cantidad', '$boleto')";
            $registro = mysqli_query($conexion, $consulta)  or die(mysqli_error($conexion));
        }
    }else{
        $response->mensaje = "La fecha ingresada esta fuera de el rango de las fechas del evento";
        $response->estado = 0;
    }
    
  
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    echo json_encode($response); 
  
?>