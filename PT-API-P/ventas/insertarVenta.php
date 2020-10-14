<?php
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    include_once("../modelo/ClaseBoleto.php");
    include_once("../modelo/ClaseVenta.php");
    include_once("../modelo/ClaseUsuario.php");
    include_once("../modelo/ClasePromoFecha.php");
    include_once("../modelo/ClasePromoRelacionado.php");
    include_once("../modelo/ClasePromoCodigo.php");

    $conexion = conexion();
    $json = file_get_contents('php://input');
    $carrito = json_decode($json, true);

    class Result {}
    $response = new Result();

    $id_usuario = $_GET["id_usuario"];
    $cantidad_carrito = count($carrito);
    $errores = 0;
    
    $f = 0;
    for($w = 0; $w<$cantidad_carrito; $w++){//recorreremos el arrglo para ver boletos repetidos
        $info_boleto = Boleto::obtenerInfoBoleto($carrito[$w]['id_boleto']);
        while($while_info_boleto = mysqli_fetch_array($info_boleto)){
            $precioboleto[$w] = $while_info_boleto["precio_actual_boleto"];
            $stock_act_boleto[$w] = $while_info_boleto["stock_act_boleto"]; 
        } 
        if((empty($carrito[$w]['detectado']))){//si el campo detectado del carrito esta declarado, significa que ya se reviso
                $carrito2[$f]['id_boleto'] = $carrito[$w]['id_boleto'];
                $carrito2[$f]['cantidad'] = $carrito[$w]['cantidad'];
                $carrito2[$f]['nombre'] = $carrito[$w]['nombre'];
                $carrito2[$f]['stock_boleto'] = $stock_act_boleto[$w];
            for($t=$w+1; $t<$cantidad_carrito; $t++){
                if(empty($carrito[$t]['detectado'])){
                    if($carrito2[$f]['id_boleto'] == $carrito[$t]['id_boleto']){
                    $carrito[$t]['detectado'] = true;
                    $carrito2[$f]['cantidad'] = $carrito2[$f]['cantidad'] + $carrito[$t]['cantidad'];
                    }
                }
            }
            $f++;
        } 
    }
    $cantidad_carrito2 = count($carrito2);
    for($s = 0; $s<$cantidad_carrito2; $s++){
        $boletosref = $carrito2[$s]['stock_boleto'] - $carrito2[$s]['cantidad'];
        if($boletosref < 0){
            $boletosref = $boletosref * (-1);
            $mensajes[$errores] = "Su compra de el boleto ".$carrito[$s]['nombre']." excede por ".$boletosref." la cantidad disponible";
            $errores++;
        } 
    }

    for($x=0;$x<$cantidad_carrito;$x++){
        
        if($carrito[$x]['tipo'] == 0){
            if($precioboleto[$x] != $carrito[$x]['precio']){
                $mensajes[$errores] = "el precio del boleto ".$carrito[$x]['nombre']." no es valido, porfavor elimine el boleto y vuelvalo a ingresar";
                $errores++;
            }
        }
        if($carrito[$x]['tipo'] == 2){
            $promocod = Boleto::ConsultaPromoCodigo($carrito[$x]['id_promo'], $carrito[$x]['cantidad'], $carrito[$x]['precio']);
            if(mysqli_num_rows($promocod) < 1){
                $mensajes[$errores] = "el precio en promocion por codigo ingresado del boleto ".$carrito[$x]['nombre']." no es valido";
                $errores++;

            }else{
                while($while_info_codigo = mysqli_fetch_array($promocod)){
                    $stock = $while_info_codigo["cantidad_act_cod"]; 
                }
                if($carrito[$x]['cantidad'] > $stock){
                    $mensajes[$errores] = "la cantidad de boletos ingresada es mayor a las que se tiene en promocion, usted tiene actualmente derecho a  ".$stock." boletos en promocion con el codigo que ingreso";  
                    $errores++;
                }

            }
        }

        if($carrito[$x]['tipo'] == 3){
            $estado = Boleto::ConsultaPromoRelacionado($carrito[$x]['id_promo'], $carrito[$x]['precio'], $carrito[$x]['cantidad']);
            $estado2 = Venta::elementosVenta($carrito[$x]['id_venta_ref'], $id_usuario);
            if((mysqli_num_rows($estado) != 1) || ($estado2 == 2)){
                if($estado2 == 2){
                    $mensajes[$errores] = "La promocion en el boleto ".$carrito[$x]['nombre']." no es valida";
                    $errores++;
                }
                if(mysqli_num_rows($estado) != 1){
                    $mensajes[$errores] = "La promocion de el boleto ".$carrito[$x]['nombre']." no es valida";
                    $errores++;
                }
            }else{
                $elementosestado2 = count($estado2);
                for($z=0;$z<$elementosestado2;$z++){
                    if($estado2[$z]['id_boleto'] == $carrito[$x]['id_boleto_ref']){
                        if(intval($estado2[$z]['cantidad_bol_promo']) < intval($carrito[$x]['cantidad'])){
                            $mensajes[$errores] = "la cantidad de boletos ingresada es mayor a las que se tiene en promocion, usted tiene actualmente derecho a ".$estado2[$z]['cantidad_bol_promo']." boletos en promocion";
                            $errores++;
                            break;
                        }else{
                            break;
                        }
                    }
                    if(($z == ($elementosestado2 - 1))){
                        $mensajes[$errores] = "No es valida la promocion del boleto ".$carrito[$x]['nombre'];
                        $errores++;
                    }
                }
            }
        }

        /**/
    }
        
    if($errores == 0){
        $edad = Usuario::Edad($id_usuario); 

        $id_venta = Venta::InsertarVenta($id_usuario, 0, 0, $edad, 0, 0, 0);
        $subtotal_venta = 0;
        $cantidad_boletos = 0;
        for($x=0;$x<$cantidad_carrito;$x++){
            $precio_bol_ven = $carrito[$x]['precio'];
            $cantidad_bol = intval($carrito[$x]['cantidad']);
            $tipo_promo = $carrito[$x]['tipo'];
            
            $subtotal = $cantidad_bol * $precio_bol_ven;

            if($tipo_promo == 3){
                $promo_ven = 1;
                $id_promobol = $carrito[$x]['id_promo'];
                $id_promovenref = $carrito[$x]['id_venta_ref'];
                $id_promobolref = $carrito[$x]['id_boleto_ref'];
                Venta::UpdateStockpromoeleven($id_promobolref, $cantidad_bol, $id_promovenref);
                PromoRelacionado::UpdateStockpromoRelacionado($id_promobol, $cantidad_bol);
            }
            if($tipo_promo == 2){
                $promo_ven = 1;
                $id_promobol = $carrito[$x]['id_promo'];
                $id_promovenref = null;
                $id_promobolref = null;
                PromoCodigo::UpdateStockpromoCodigo($id_promobol, $cantidad_bol);
            }
            if($tipo_promo == 0){
                $promo_ven = 0;
                $id_promobol = null;
                $id_promovenref = null;
                $id_promobolref = null;
                $pos_promo_fec = PromoFecha::buscarpromocion($carrito[$x]['id_boleto']);
                if(mysqli_num_rows($pos_promo_fec) >= 1){
                    while($while_info_promofec = mysqli_fetch_array($pos_promo_fec)){
                        $cantidad_act_fec = $while_info_promofec["cantidad_act_fec"];
                        $id_promo = $while_info_promofec["id_promo_fec"];
                    }
                    $cantidad_act_fec = $cantidad_act_fec - $cantidad_bol;
                    PromoFecha::UpdateStockPromoFec($id_promo, $cantidad_act_fec);
                }

            }
            Boleto::UpdateStockBoleto($carrito[$x]['id_boleto'], $carrito[$x]['cantidad']);
            Venta::InsertarElementoVenta($cantidad_bol, $precio_bol_ven, $subtotal, $promo_ven, $tipo_promo, $id_promobol, $id_promovenref, $carrito[$x]['id_boleto'], $id_venta, $id_promobolref);
            $subtotal_venta = $subtotal_venta + $subtotal;
            $cantidad_boletos = $cantidad_boletos + $cantidad_bol;
        }
        Venta::UpdateVenta($id_venta, $subtotal_venta, $cantidad_boletos);
        $response->estado = 1;

    }else{
        $response->mensajes = $mensajes;
        $response->estado = 0;
    }
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }else{
        $response->resultado = 'OK';
    }
    echo json_encode($response); 
?>