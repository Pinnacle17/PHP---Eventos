<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseEvento.php");
    $consulta = "SELECT SUM(cantidad_ven), fec_ven FROM venta WHERE pago = '1' GROUP BY fec_ven";
    $resultado = BD::consultaSelect($consulta);
    if(mysqli_num_rows($resultado) > 0){
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
        while ($row = mysqli_fetch_row($resultado)) {
            $dia = Evento::DiaSemanaEvento($row[1]);
            for($x=0; $x < 7; $x++){
                if($final[$x]['dia'] == $dia){
                    $final[$x]['cantidad'] = $final[$x]['cantidad'] + $row[0];
                    break;
                }
            }
        }

    }else{
        $resultado = null;
    }


?>