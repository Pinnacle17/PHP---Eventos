<?php
    require("../headers.php");
    require("../BD.php");
    require("../conexion.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClasePromoRelacionado.php");
    require("../modelo/ClaseVenta.php");

    $conexion = conexion();
    class Result {}
    $response = new Result();
    
    $json = file_get_contents('php://input');
    $carrito = json_decode($json, true);

    $venta = $_GET['codigo'];
    $id_usuario = $_GET['id_usuario'];
    
    $elementosVenta = Venta::elementosVenta($venta, $id_usuario);
    $z = 0;//indica que no hay promociones
    if($elementosVenta == 2){
            $response->mensaje = "No existe la venta indicada";
            $response->estado = -1;
    }else{
        $cantidad_carrito = count($carrito);
        $cantidad_elementosVenta = count($elementosVenta);
        for($x = 0; $x<$cantidad_carrito; $x++){
            if($carrito[$x]['tipo'] == 0){
                for($y = 0;$y<$cantidad_elementosVenta; $y++){
                    if($elementosVenta[$y]["promo_ven"] == 0){
                        $promocion = PromoRelacionado::buscarpromocion($carrito[$x]["id_boleto"], $elementosVenta[$y]["id_boleto"]);
                        if($promocion == 2 || $promocion == 3){
                            break;
                        }else{
                            if($carrito[$x]['id_promo'] ==  $promocion['id_promo_eve']){
                                $response->mensaje = "Esta promocion ya fue aplicada.";
                                $response->estado = 0;
                                $z = 2;
                                break;
                            }else if($elementosVenta[$y]["cantidad_bol_promo"] > 0){
                                $cantidad = $carrito[$x]['cantidad'] - $elementosVenta[$y]["cantidad_bol_promo"];
                                if($cantidad > 0){
                                    $carrito[$x]['cantidad'] = $elementosVenta[$y]["cantidad_bol"];
                                    $carrito[$cantidad_carrito]['id_boleto'] = $carrito[$x]["id_boleto"];
                                    $carrito[$cantidad_carrito]['nombre'] = $carrito[$x]["nombre"];
                                    $carrito[$cantidad_carrito]['precio'] = $carrito[$x]["precio"];
                                    $carrito[$cantidad_carrito]['cantidad'] = $cantidad;
                                    $carrito[$cantidad_carrito]['limite'] = $carrito[$x]["limite"];
                                    $carrito[$cantidad_carrito]['id_promo'] = null;
                                    $carrito[$cantidad_carrito]['tipo'] = 0;
                                }
                                $carrito[$x]['precio'] = $promocion['precio_eve'];
                                $carrito[$x]['limite'] = $elementosVenta[$y]["cantidad_bol"];
                                $carrito[$x]['tipo'] = 3;
                                $carrito[$x]['id_promo'] =  $promocion['id_promo_eve'];
                                $carrito[$x]['id_boleto_ref'] = $elementosVenta[$y]["id_boleto"];
                                $carrito[$x]['id_venta_ref'] = $venta;
                                $z = 1;//indica que se agrego la promocion
                                break;
                            }else{
                                $response->mensaje = "Ya no quedan boletos en promocion en la venta seleccionada.";
                                $response->estado = 0;
                                $z = 2;
                                break;
                            }
                            
                        }
                    }
                }
            }
            if($z==1){
                break;
            }
        }        
        if($z==0){
            $response->mensaje = "La promoción no se encontro en la venta seleccionada.";
            $response->estado = 0;
        }else if($z==1){
            $response->estado = 1;
            $response->carrito = $carrito;
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