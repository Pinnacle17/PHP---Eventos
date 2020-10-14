<?php
    //mostrara las ventas que estan en proceso
    require("../headers.php");
    require("../BD.php");
    require("../modelo/ClaseBoleto.php");
    require("../modelo/ClaseVenta.php");
    require("../modelo/ClaseRepartidor.php");
    include_once("../modelo/ClaseUsuario.php");
    
    $id_usuario = $_GET['id_repartidor'];

    $entregas = Repartidor::VerEntregas($id_usuario, 1);
    
    if($entregas == null){
        echo json_encode(null);
    }
    else{
        $numeroentregas = count($entregas);
        for($x=0;$x<$numeroentregas; $x++){
            $venta = Venta::buscarventa($entregas[$x]["fk_venta_ent"]);
            $usuario = Usuario::DatosUsuario($venta["fk_usuario_ven"]);
    
            $resultado[$x]['id_venta'] = $entregas[$x]["fk_venta_ent"];
            $resultado[$x]['celular'] = $usuario['celular'];
            $resultado[$x]['celular_ext'] = $usuario['celular_ext'];
            $resultado[$x]['nombre'] = $usuario['nombre'];
        }
        
        echo json_encode($resultado);
    }

?>