<?php
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");

    $conexion = conexion();
    
    class Result {}
    $response = new Result();
    
    $id_venta = $_GET['id_venta'];

    $venta = Venta::buscarventa($id_venta);
    $registroentrega = Repartidor::ConsultaEntrega($id_venta);
    $consulta2 = "SELECT *FROM venta WHERE id_venta = '$id_venta' AND pago = '1'";
    $pago = BD::consultaSelect($consulta2);
    if($venta == null){
        $mensaje = "La venta con el id indicado no existe";
        $response->estado = 0;
    }else if(mysqli_num_rows($pago) == 0){
        $mensaje = "No se ha confirmado el pago de la venta que se intenta tomar.";
        $response->estado = 0;
    }else if(mysqli_num_rows($registroentrega) == 0){
        $elementosventa = Venta::buscarelementosventa($id_venta);
        $numerodeelementos = count($elementosventa);
        for($x = 0;$x < $numerodeelementos; $x++){
            $entrega[$x]['id_boleto'] = $elementosventa[$x]['fk_boletoele'];
            $entrega[$x]['cantidad'] = $elementosventa[$x]['cantidad_bol'];
            $boleto = Boleto::obtenerDatosBoleto($elementosventa[$x]['fk_boletoele']);
            $entrega[$x]['nombre_boleto'] = $boleto['nom_bol'];
        }
        $response->estado = 1;
        $response->entrega = $entrega;
    }else{
        $mensaje = "Esta venta ya ha sido tomada";
        $response->estado = -1;
    }

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';//error de conexion
    }
    else if(isset($mensaje)){
        $response->mensaje = $mensaje;//No se encontro la venta o ya fue tomada
    }
    else{
        $response->resultado = 'OK';
    }

    echo json_encode($response);//Envia la venta
?>