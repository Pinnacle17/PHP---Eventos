<?php
    require("../headers.php");
    require("../conexion.php");
    $conexion = conexion();

    $registros = mysqli_query($conexion, "SELECT * FROM boleto WHERE fk_evento_bol = $_GET[id_evento]");

    if(mysql_num_rows($registros) > 0){
        $boletos = [];
        while ($resultado = mysqli_fetch_array($registros)){
            $boletos[] = $resultado;
        }
    }else{
        $boletos = null;
    }
    echo json_encode($boletos);

?>