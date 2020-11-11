<?php
    require("../headers.php");
    require("../BD.php");

    $consulta = "SELECT SUM(cantidad_ven), edad_ven FROM venta WHERE pago = '1' GROUP BY edad_ven";
    $resultado = BD::consultaSelect($consulta);
    $edad = [];
    if(mysqli_num_rows($resultado) > 0){
        while ($row = mysqli_fetch_row($resultado)) {
            $edad[$row[1]]["cantidad"] = $row[0];
        }
    }else{
        $edad = null;
    }
    echo json_encode($edad); 
    
?>