<?php
    require("../headers.php");
    require("../modelo/ClaseEvento.php");
    $consulta = "SELECT cantidad_ven, fec_ven FROM venta WHERE pago = '1'";
    $resultado = BD::consultaSelect($consulta);
    if(mysqli_num_rows($resultado) >= 1){
        $final[0]['dia'] = "Lunes";
        $final[1]['dia'] = "Martes";
        $final[2]['dia'] = "Miercoles";
        $final[3]['dia'] = "Jueves";
        $final[4]['dia'] = "Viernes";
        $final[5]['dia'] = "Sabado";
        $final[6]['dia'] = "Domingo";
        while ($while = mysqli_fetch_array($resultado)){
            $fecha = $while['fec_ven'];
            $cantidad = $while['cantidad_ven'];
            $dia = Evento::DiaSemanaEvento($fecha);
            for($x=0; $x < 7; $x++){
                if($final[$x]['dia'] == $dia){
                    $final[$x]['cantidad'] = $final[$x]['cantidad'] + $cantidad;
                }
            }
        }
        return $final;
    }else{
        echo json_encode(null);
    }    
    
?>