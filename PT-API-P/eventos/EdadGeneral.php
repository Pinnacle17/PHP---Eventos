<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $consulta = " SELECT edad_ven, sum(cantidad_ven) as cantidad FROM venta group by(edad_ven)";
    $resultado = BD::consultaSelect($consulta);
    if(mysqli_num_rows($resultado) >= 1){
        $elementos = 0;
        $edades = [];
        $x=0;
        while ($while = mysqli_fetch_array($resultado)){
            $edad = $while["edad_ven"];
            $cantidad = $while["cantidad"];
            
            $edades[$x]["edad"]=$edad;
            $edades[$x]["cantidad"]=intval($cantidad);
            $x++;
        }
    }else{
        $edades = null;
    }
    
    echo json_encode($edades)
?>