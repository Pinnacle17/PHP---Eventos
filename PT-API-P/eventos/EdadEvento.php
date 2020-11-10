<?php
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    
    $id_evento = $_GET['id_evento'];
    
    $consulta = "SELECT venta.edad_ven, sum(venta.cantidad_ven) as cantidad 
                    FROM ele_ven 
                    join venta on ele_ven.fk_ventaele=venta.id_venta 
                    join boleto on ele_ven.fk_boletoele=boleto.id_boleto 
                    where boleto.fk_evento_bol=".$id_evento." 
                    group by(edad_ven)
                    ORDER BY cantidad DESC;";
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