<?php
    require("../headers.php");
    require("../BD.php");

    $consulta = "SELECT COUNT(*), SUM(cantidad_ven) FROM venta WHERE pago = '1'";
    $resultado = BD::consultaSelect($consulta);
    if(mysqli_num_rows($resultado) > 0){
        while ($row = mysqli_fetch_row($resultado)) {
            $resultado = $row[1]/$row[0];
            $resultado["cantidad_boletos"] = $row[1];
            $resultado["ventas"] = $row[0];
            $resultado["resultado"] = round($resultado);
        }
    }else{
        $resultado = null;
    }
    echo json_encode($resultado); 
    
?>