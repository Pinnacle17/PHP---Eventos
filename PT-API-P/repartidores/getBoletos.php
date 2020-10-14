<?php
    require("../headers.php");
    require("../conexion.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");

    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM stock_adm WHERE fk_usuarioadm=$_GET[id_rep] AND stock_adm_act != 0");

    $boletos = [];
    $id_boleto = null;
    $x= 0;
    while ($resultado = mysqli_fetch_array($registros)){
        $boletos[] = $resultado;
        $id_boleto = $resultado["fk_boleto"];
        $boletos[$x]["nombre_boleto"] = Boleto::obtenerNombreBoleto($id_boleto);
        $x++;
        
    }
    $json = json_encode($boletos);

    echo $json;
?>