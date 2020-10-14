<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");

    $id_usuario = $_GET['id_usuario'];

    $cantidad_boletos = $_POST['cantidad'];
    $id_boleto = $_POST['boleto'];
    $precio_boleto = $_POST['precio'];

    class Result {}
    $response = new Result();
    
    $stockrepartidor = Repartidor::StockUsuario($id_usuario);
    $elementosstockrepartidor = count($stockrepartidor);

    $errores = 0;
    for($y = 0; $y < $elementosstockrepartidor; $y++){
        if($id_boleto == $stockrepartidor[$y]['fk_boleto']){
            if($stockrepartidor[$y]['stock_adm_act'] >= $cantidad_boletos){
                $stock = $stockrepartidor[$y]['stock_adm_act'] - $cantidad_boletos;
                break;
            }else{
                $faltantes = $cantidad_boletos - $stockrepartidor[$y]['stock_adm_act'];
                $boleto = Boleto::obtenerDatosBoleto($id_boleto);
                $nombre = $boleto['nom_bol'];
                $mensaje[$errores] = "Faltan ".$faltantes." boleto(s) del boleto ".$nombre." para tomar la venta";
                $errores++;
                break;
            }
        }
        if($y == ($elementosstockrepartidor - 1)){
            $boleto = Boleto::obtenerDatosBoleto($id_boleto);
            $nombre = $boleto['nom_bol'];
            $mensaje[$errores] = "No se encuentra stock de el boleto ". $nombre;
            $errores++;
        }
    }
    if($errores == 0){
        $subtotal = $cantidad_boletos * $precio_boleto;
        $id_venta = Venta::InsertarVenta($id_usuario, 1, 1, null, $subtotal, $cantidad_boletos, 1);
        Repartidor::UpdateStockUsuario($stock, $id_boleto, $id_usuario);
        Boleto::UpdateStockBoleto($id_boleto, $cantidad_boletos);
        Venta::InsertarElementoVenta($cantidad_boletos, $precio_boleto, $subtotal, 0, 4, null, null, $id_boleto, $id_venta, null);
        Repartidor::CrearRegistroEntrega($id_venta, $id_usuario, 2);
        $response->estado = 1;
    }else{
        $response->mensajes = $mensaje;
        $response->estado = 0; 
    }

    echo json_encode($response)
    
?>