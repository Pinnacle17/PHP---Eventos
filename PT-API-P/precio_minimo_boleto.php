<?php
    require("headers.php");
    require("BD.php");
    require("modelo/ClaseEvento.php");
    require("modelo/ClaseBoleto.php");
    require("modelo/ClasePromoFecha.php");
    $consulta_eventos_actuales = "SELECT *FROM evento WHERE estado_evento = '1'";
    $resultado_eventos_actuales = BD::consultaSelect($consulta_eventos_actuales);
    if(mysqli_num_rows($resultado_eventos_actuales) >= 1){
        while($eventos_actuales = mysqli_fetch_array($resultado_eventos_actuales)){
        $boletos_evento = Boleto::obtenerIdBoletoEvento($eventos_actuales["id_evento"]);
        while($while_boletos_evento = mysqli_fetch_array($boletos_evento)){
            $id_boleto = $while_boletos_evento["id_boleto"];
            $promo_fec = PromoFecha::buscarpromocion($id_boleto);
            if(mysqli_num_rows($promo_fec) == 1){
                while($while_promo_fec = mysqli_fetch_array($promo_fec)){
                    $precio_bol = $while_promo_fec["precio_fec"];
                    $cantidad_act_fec = $while_promo_fec["cantidad_act_fec"];
                }
                if($cantidad_act_fec < 0){
                    $precio_bol = $while_boletos_evento["precio_bol"];
                }
            }else{
                $precio_bol = $while_boletos_evento["precio_bol"];
            }
            Boleto::UpdatePrecioBoleto($precio_bol, $id_boleto);
            if(isset($precio_min_bol)){
                if($precio_min_bol > $precio_bol){
                    $precio_min_bol = $precio_bol;
                }
            }else{
                $precio_min_bol = $precio_bol;
            }
        }
        unset($precio_min_bol);
        Evento::UpdatePrecioEvento($precio_min_bol, $eventos_actuales["id_evento"]);
    }
    }
?>  