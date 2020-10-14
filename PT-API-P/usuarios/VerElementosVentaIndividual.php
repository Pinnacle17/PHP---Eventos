<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $id_venta = $_GET['id_venta'];

    $ventas = Venta::buscarelementosventa($id_venta);
    if($ventas != null){
        $numeroventas = count($ventas);
        for($x = 0; $x<$numeroventas; $x++){
            $resultado[$x]['id_ele'] = $ventas[$x]['id_ele'];
            $resultado[$x]['id_boleto'] = $ventas[$x]['fk_boletoele'];
            $datos = Boleto::obtenerNombreDescripcionBoleto($resultado[$x]['id_boleto']);
            $resultado[$x]['nombre'] = $datos['nombre'];
            $resultado[$x]['descripcion'] = $datos['descripcion_boleto'];
            $resultado[$x]['cantidad_bol'] = $ventas[$x]['cantidad_bol'];
            $resultado[$x]['precio_bol_ven'] = $ventas[$x]['precio_bol_ven'];
            $resultado[$x]['sub_bol'] = $ventas[$x]['sub_bol'];
            $promo = $ventas[$x]['tipo_promo'];
            if($promo == 3){
                $resultado[$x]['promocion'] = "Promocion por Compra Pasada";
            }else if($promo == 2){
                $resultado[$x]['promocion'] = "Promocion por Codigo Ingresado";
            }else{
                $resultado[$x]['promocion'] = "Precio Normal";
            }
        }
        echo json_encode($resultado);
    }else{
        $mensaje = "No hay elementos registrados";
        echo json_encode($mensaje);
    }
    

?>