<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $consulta = "SELECT edad_ven, cantidad_ven FROM venta";
    $resultado = BD::consultaSelect($consulta);
    if(mysqli_num_rows($resultado) >= 1){
        $elementos = 0;
        while ($while = mysqli_fetch_array($resultado)){
            $edad = $while["edad_ven"];
            $cantidad = $while["cantidad_ven"];
            if($edades[$edad]['cantidad'] == null){
                $edades[$edad]['cantidad'] = $cantidad;
            }else{
                $edades[$edad]['cantidad'] = $edades[$edad]['cantidad'] + $cantidad;
            }
        }
        return $edades;
    }else{
        return null;
    }
    
?>