<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseEvento.php");
    require("../modelo/ClaseBoleto.php");
    $select_eventos=Evento::obtenerDatosEvento(1);
    $x = 0;
    while($while_select_eventos = mysqli_fetch_array($select_eventos)){
        $id_evento[$x] = $while_select_eventos["id_evento"];
        ++$x;
    }
    for($y = 0; $y<$x; $y++){
        $boletos_evento = Boleto::obtenerIdBoletoEvento($id_evento[$y]);
        $precio_min_bol = 1000000000;
        while($while_boletos_evento = mysqli_fetch_array($boletos_evento)){
            $id_boleto = $while_boletos_evento["id_boleto"];
            $promo_fec = Boleto::obtenerPromo_fecBoleto($id_boleto);
            if(mysqli_num_rows($promo_fec) == 1){
                while($while_promo_fec = mysqli_fetch_array($promo_fec)){
                    $precio_bol = $while_promo_fec["precio_fec"];
                }
            }else{
                $precio_bol = $while_boletos_evento["precio_bol"];
            }
            Boleto::UpdatePrecioBoleto($precio_bol, $id_boleto);
            if($precio_min_bol > $precio_bol){
                $precio_min_bol = $precio_bol;
            }
        }
        UpdatePrecioEvento($precio_min_bol, $id_evento[$y]);
    }
?>  