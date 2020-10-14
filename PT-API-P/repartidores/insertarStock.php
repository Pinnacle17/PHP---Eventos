<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    $response = new Result();

    $id_boleto = mysqli_real_escape_string($conexion, $_POST['boleto']);
    $stock_boleto = mysqli_real_escape_string($conexion, $_POST['stock']);
    $id_repartidor = mysqli_real_escape_string($conexion, $_POST['id_repartidor']);
    $fecha = date('Y-m-d H:i:s');

    $consulta_select_boleto = "SELECT stock_repartidor FROM boleto WHERE id_boleto = '$id_boleto'";
    $resultado_consulta_select_boleto = mysqli_query($conexion, $consulta_select_boleto) or die (mysqli_error($conexion));

    $consulta_select_stockadm = "SELECT stockadm, stock_adm_act FROM stock_adm WHERE fk_boleto = '$id_boleto' AND fk_usuarioadm = '$id_repartidor'";
    $resultado_consulta_select_stockadm = mysqli_query($conexion, $consulta_select_stockadm) or die (mysqli_error($conexion));

    while ($while1 = mysqli_fetch_array($resultado_consulta_select_boleto)){
        $stock_repartidor = $while1["stock_repartidor"];
    }

    $stock_repartidor = $stock_repartidor - ($stock_boleto);
    $y = 0;
    if($stock_repartidor < 0){//comprobamos que exista el suficiente stock de boletos para dar a repartidores
        $stock_repartidor = $stock_repartidor*(-1);
        $response->estado = 0;
        $response->mensaje = "Error. No se encuentran suficientes boletos en el inventario, la cantidad de boletos excedentes es de: $stock_repartidor";
    }else{
        if(mysqli_num_rows($resultado_consulta_select_stockadm) == 1){
            while ($while2 = mysqli_fetch_array($resultado_consulta_select_stockadm)){
                $stock_adm = $while2["stockadm"];
                $stock_adm_act = $while2["stock_adm_act"];
            }

            $stock_adm = $stock_adm + ($stock_boleto);
            $stock_adm_act = $stock_adm_act + ($stock_boleto);
            
            if($stock_adm_act < 0){//comprobamos que el usuario tenga el suficiente stock de boletos que le vamos a eliminar
                $stock_adm_act = $stock_adm_act * (-1);
                $response->mensaje = "Error. El usuario no cuenta con la cantidad ingresada de boletos, la cantidad de boletos excedentes es de: $stock_adm_act";
                $response->estado = 0;
                $y = 1;
            }else{
                $consulta_update_stockadm = "UPDATE stock_adm SET stockadm='$stock_adm', stock_adm_act='$stock_adm_act' WHERE fk_boleto = '$id_boleto' AND fk_usuarioadm = '$id_repartidor'";
                mysqli_query($conexion, $consulta_update_stockadm) or die (mysqli_error($conexion));
            }
        }else{
            if($stock_boleto < 1){
                $response->mensaje = "Error. El usuario no cuenta con boletos cargados";
                $response->estado = 0;
                $y = 1;
            }else{
                $consulta_insert_stockadm = "INSERT INTO stock_adm(stockadm, stock_adm_act, fk_boleto, fk_usuarioadm) VALUES('$stock_boleto','$stock_boleto','$id_boleto','$id_repartidor')";
                mysqli_query($conexion, $consulta_insert_stockadm) or die (mysqli_error($conexion));
            }
        }
        if($y == 0){
            $consulta_update_boleto = "UPDATE boleto SET stock_repartidor = '$stock_repartidor' WHERE id_boleto = '$id_boleto'";
            mysqli_query($conexion, $consulta_update_boleto) or die (mysqli_error($conexion));

            $consulta_insert_historial_cargas = "INSERT INTO historial_cargas(
            stock_adm,
            fecha_historial,
            fk_boleto,
            fk_usuarioadm
            ) VALUES(
            '$stock_boleto',
            '$fecha',  
            '$id_boleto',
            '$id_repartidor')";
            mysqli_query($conexion, $consulta_insert_historial_cargas) or die (mysqli_error($conexion));
            /*if(isset($consulta_update_stockadm)){
                
            }*/
        }
    }
    
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
  
    echo json_encode($response); 
?>