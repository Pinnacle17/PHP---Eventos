<?php //fijate en las lineas 20 y 52
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    class Result {}
    $response = new Result();

    $codigo = mysqli_real_escape_string($conexion, $_GET['codigo']);

    $id_pro_cod = null;
    $fk_boleto_cod = null;
    $cantidad_cod = null;
    $precio_cod = null;

    $consulta_select_promocod = "SELECT * FROM promo_cod WHERE codigo = '$codigo'";
    $result = mysqli_query($conexion,$consulta_select_promocod) or die (mysqli_error($conexion));

    if(mysqli_num_rows($result) >= 1){

        while ($while = mysqli_fetch_array($result)){
            $id_pro_cod = $while["id_pro_cod"];
            $fk_boleto_cod = $while["fk_boleto_cod"];
            $cantidad_cod = $while["cantidad_act_cod"];
            $precio_cod = $while["precio_cod"];
        }
        if($cantidad_cod < 1){
            $response->estado = 0;
            $response->mensaje = "El código ingresado ya no cuenta con boletos en promocion";//no se encontro el codigo ingresado
        }else{
            $consulta_select_boleto = "SELECT nom_bol FROM boleto WHERE id_boleto='$fk_boleto_cod'";
            $result2 = mysqli_query($conexion,$consulta_select_boleto);
    
            while ($while2 = mysqli_fetch_array($result2)){
                $nom_bol = $while["nom_bol"];
            }
    
            $response->estado = 1;
            $response->id = $id_pro_cod;
            $response->nombre = $nom_bol;
            $response->boleto = $fk_boleto_cod;
            $response->cantidad = $cantidad_cod;
            $response->precio = $precio_cod;
            }

        
    }else{
        $response->estado = 0;
        $response->mensaje = "El código ingresado no existe";//no se encontro el codigo ingresado
    }

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    echo json_encode($response); 
?>