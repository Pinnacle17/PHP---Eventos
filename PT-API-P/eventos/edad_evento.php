<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    $id_evento = $_GET['id_evento'];
    $boletos = Boleto::obtenerIdBoletoEvento($id_evento);
    if(mysqli_num_rows($boletos) > 0){
        $resultado = [];
        while ($while = mysqli_fetch_array($boletos)){
            $elementoventa = Venta::buscarelementosventaboleto($while["id_boleto"]);
            if($elementoventa != null){
                $cantidadelementoventa = count($elementoventa);
                for($y = 0; $y<$cantidadelementoventa; $y++){
                    $edad = Venta::Edadventa($elementoventa[$y]["fk_ventaele"]);
                    if($edad != null){
                        $edad = $edad["edad_ven"];
                        if(!(isset($resultado[$edad]['cantidad']))){
                            $resultado[$edad]['cantidad'] = $elementoventa[$y]["cantidad_bol"];
                        }else{
                            $resultado[$edad]['cantidad'] = $resultado[$edad]['cantidad'] + $elementoventa[$y]["cantidad_bol"];
                        }
                    }
                }
            }
        }
           
    }else{
        $resultado = null;
    }
    if(!(isset($resultado))){
        $resultado = null;
    }
    echo json_encode($resultado);  
?>