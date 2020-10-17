<?php
    require("../headers.php");
    require("../conexion.php");

    $conexion = conexion();
    $estado = mysqli_real_escape_string($conexion, $_POST['']);
    $precio_min = mysqli_real_escape_string($conexion, $_POST['']);
    $precion_max = mysqli_real_escape_string($conexion, $_POST['']);
    $tipo = mysqli_real_escape_string($conexion, $_POST['']);
    $cat_filtro = 0;
    if(!empty($estado)){
        $filtro[$cat_filtro] = " estado_evento = '$estado'";
        $cat_filtro++;
    }
    if(!empty($precio_min)){
        $filtro[$cat_filtro] = " precio_eve >= '$precion_max'";
        $cat_filtro++;
    }
    if(!empty($precion_max)){
        $filtro[$cat_filtro] = " precio_eve <= '$precion_max'";
        $cat_filtro++;
    }
    if(!empty($tipo)){
        $filtro[$cat_filtro] = " tipo_evento = '$tipo'";
        $cat_filtro++;
    }
    if($cat_filtro >= 1){
        $consulta = "SELECT *FROM evento WHERE".$filtro[0];
        if($cat_filtro > 1){
            for($x = 1; $x < $cat_filtro; $x++){
                $consulta = $consulta." AND".$filtro[$x];
            }
        }
        $registros = mysqli_query($conexion, $consulta);

        while ($resultado = mysqli_fetch_array($registros)){
            $eventos[] = $resultado;
        }
        $json = json_encode($eventos);
        echo $json;
    }
    $json = json_encode(null);//no mandaste nada, retorna 0
    echo $json;

?>