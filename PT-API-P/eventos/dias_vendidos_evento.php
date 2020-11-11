<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseEvento.php");
    $id_evento = $_GET['id_evento'];
    $boletos = Boleto::obtenerIdBoletoEvento($id_evento);
    $final[0]['dia'] = "Lunes";
        $final[1]['dia'] = "Martes";
        $final[2]['dia'] = "Miercoles";
        $final[3]['dia'] = "Jueves";
        $final[4]['dia'] = "Viernes";
        $final[5]['dia'] = "Sabado";
        $final[6]['dia'] = "Domingo";
        $final[0]['cantidad'] = 0;
        $final[1]['cantidad'] = 0;
        $final[2]['cantidad'] = 0;
        $final[3]['cantidad'] = 0;
        $final[4]['cantidad'] = 0;
        $final[5]['cantidad'] = 0;
        $final[6]['cantidad'] = 0;
    if(mysqli_num_rows($boletos) > 0){
        while ($while = mysqli_fetch_array($boletos)){
            $elementoventa = Venta::buscarelementosventaboleto($while["id_boleto"]);
            if($elementoventa != null){
                $cantidadelementoventa = count($elementoventa);
                for($y = 0; $y<$cantidadelementoventa; $y++){
                $fecha = Venta::Diaventa($elementoventa[$y]["fk_ventaele"]);
                $dia = Evento::DiaSemanaEvento($fecha['fec_ven']);
                for($x=0; $x < 7; $x++){
                    if($final[$x]['dia'] == $dia){
                        $final[$x]['cantidad'] = $final[$x]['cantidad'] + $elementoventa[$y]["cantidad_bol"];
                        break;
                    }
                }
                }
            }
        }
           
    }else{
        $final = null;
    }
    echo json_encode($final);
    
?>