<?php
    require("../headers.php");
    require("../BD.php");
    include_once("../modelo/ClaseBoleto.php");
    include_once("../modelo/ClaseVenta.php");
    include_once("../modelo/ClaseRepartidor.php");

    $id_venta = $_GET['id_venta'];
    $id_usuario = $_GET['id_repartidor'];

    class Result {}
    $response = new Result();

    //$venta = Venta::buscarelementosventa($id_venta);
    $venta2 = Venta::buscarelementosventa($id_venta);
    $stockrepartidor = Repartidor::StockUsuario($id_usuario);
    $consulta = "SELECT *FROM entrega WHERE fk_venta_ent = '$id_venta'";
    $entrega = BD::consultaSelect($consulta);
    if($venta2 == null){
        $response->estado = 0;
        $errores = 1;
        $mensajes[0] = "No existe la venta.";
        $response->mensajes = $mensajes;
    }else if($stockrepartidor == null){
        $response->estado = 0;
        $errores = 1;
        $mensajes[0] = "El usuario no cuenta con stock ingresado.";
        $response->mensajes = $mensajes;
    }else if(mysqli_num_rows($entrega) == 0){
        $errores = 0;
        $elementosventa = count($venta2);
        //$venta2 = $venta;
        $t = 0;
        $numstockrepartidor = count($stockrepartidor);
        $i = 0;
        //$venta3[0]["cantidad_bol"] = $venta2[0]["cantidad_bol"];
        //$venta3[0]["fk_boletoele"] = $venta2[0]["fk_boletoele"];
        for($x = 0; $x < $elementosventa; $x++){
            if(isset($venta2[$x]["revisado"])){
             
            }else{
                for($y = $x+1; $y < $elementosventa; $y++){
                    if($i == 0){
                      $i = 1;
                      $venta2[$t]["cantidad_bol"] = $venta2[$x]["cantidad_bol"];
                      $venta2[$t]["fk_boletoele"] = $venta2[$x]["fk_boletoele"];
                      $venta2[$x]["revisado"] = true;
                    }
                if(($venta2[$x]["fk_boletoele"] == $venta2[$y]["fk_boletoele"]) AND (empty($venta2[$y]["revisado"]))){
                    $venta2[$y]["revisado"] = true;
                        $venta2[$t]["cantidad_bol"] = $venta2[$t]["cantidad_bol"] + $venta2[$y]["cantidad_bol"];
                        $venta2[$y]["revisado"] = true;
                }  
            }
            $i = 0;
            $t = $t + 1;
            }
        }
        
        
        
        for($x = 0; $x < $t; $x++){
            for($y = 0; $y < $numstockrepartidor; $y++){
                if($venta2[$x]["fk_boletoele"] == $stockrepartidor[$y]["fk_boleto"]){
                    if($stockrepartidor[$y]["stock_adm_act"] >= $venta2[$x]["cantidad_bol"]){
                        break;
                    }else{
                        $faltantes = $venta2[$x]["cantidad_bol"] - $stockrepartidor[$y]["stock_adm_act"];
                        $boleto = Boleto::obtenerDatosBoleto($venta2[$x]["fk_boletoele"]);
                        $nombre = $boleto["nom_bol"];
                        $mensajes[$errores] = "Faltan ".$faltantes." boletos del el boleto ".$nombre." para tomar la venta";
                        $errores++;
                        break;
                    }
                }
                if($y == ($numstockrepartidor - 1)){
                    $boleto = Boleto::obtenerDatosBoleto($venta2[$x]["fk_boletoele"]);
                    $nombre = $boleto['nom_bol'];
                    $mensajes[$errores] = "No se encuentra stock de el boleto ". $nombre;
                    $errores++;
                }
    
            }
        }
        if($errores == 0){
            $venta = Venta::buscarelementosventa($id_venta);
            $elementosventa = count($venta);
            $numstockrepartidor = count($stockrepartidor);
            for($x = 0; $x < $t; $x++){
                for($y = 0; $y < $numstockrepartidor; $y++){
                    if($venta2[$x]['fk_boletoele'] == $stockrepartidor[$y]['fk_boleto']){
                        //usleep(1000000);
                        $stock = $stockrepartidor[$y]['stock_adm_act'] - $venta2[$x]["cantidad_bol"];
                        Repartidor::UpdateStockUsuario($stock, $venta2[$x]['fk_boletoele'], $id_usuario);
                        //break;                    
                    }
                }
            }
            
            Repartidor::CrearRegistroEntrega($id_venta, $id_usuario, 1);
            Repartidor::UpdateEstadoEntregaVenta($id_venta, 1);
            $response->estado = 1;
            //$response->mensajes = $mensajes;
            
        }else{
            $response->estado = 0;
            $response->mensajes = $mensajes;
        }
    }else{
        $response->estado = 0;
        $errores = 1;
        $mensajes[0] = "Esta venta ya ha sido tomada.";
        $response->mensajes = $mensajes;
    }

    echo json_encode($response);

        
?>