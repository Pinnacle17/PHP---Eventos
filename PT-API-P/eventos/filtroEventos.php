<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();
    
    $estado = mysqli_real_escape_string($conexion, $_POST['estado']);
    $precio_min = mysqli_real_escape_string($conexion, $_POST['precioMin']);
    $precio_max = mysqli_real_escape_string($conexion, $_POST['precioMax']);
    $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);

    $cant_filtro = 0;
    if($estado != ''){
        $filtro[$cant_filtro] = " estado_evento = '$estado'";
        $cant_filtro++;
    }
    if($precio_min  != ''){
        $filtro[$cant_filtro] = " precio_eve >= '$precio_min'";
        $cant_filtro++;
    }
    if($precio_max != ''){
        $filtro[$cant_filtro] = " precio_eve <= '$precio_max'";
        $cant_filtro++;
    }
    if($tipo != ''){
        $filtro[$cant_filtro] = " tipo_evento = '$tipo'";
        $cant_filtro++;
    }
    if($cant_filtro >= 1){
        $consulta = "SELECT * FROM evento WHERE".$filtro[0];
        if($cant_filtro > 1){
            for($x = 1; $x < $cant_filtro; $x++){
                $consulta = $consulta." AND".$filtro[$x];
            }
        }
        $registros = mysqli_query($conexion, $consulta);

        $eventos = [];
        while ($resultado = mysqli_fetch_array($registros)){
            $eventos[] = $resultado;
        }

        if($eventos == false){
            echo json_encode(0);
        }
        else{
            $json = json_encode($eventos);
            echo $json;
        }
    }
    else{
        echo json_encode(null);
    }

?>