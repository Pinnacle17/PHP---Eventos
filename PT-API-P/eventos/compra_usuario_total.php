<?php
    require("../headers.php");
    require("../BD.php");

    $consulta = "SELECT COUNT(*), SUM(cantidad_ven) FROM venta WHERE pago = '1'";
    $resultado = BD::consultaSelect($consulta);
    if(mysqli_num_rows($resultado) > 0){
        while ($row = mysqli_fetch_row($resultado)) {
            $compras["cantidad_boletos"] = $row[1];
            $compras["ventas"] = $row[0];
            $compras["resultado"] = $compras["cantidad_boletos"]/$compras["ventas"];
        }
    }else{
        $compras = null;
    }
    echo json_encode($compras); 
    
?>