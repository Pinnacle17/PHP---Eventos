<?php
    require("../headers.php");
    require("../conexion.php");
    require_once('../../vendor/autoload.php');
    $conexion = conexion();

    Openpay::setId('mdyezendqaez49nh3lmp');
    Openpay::setApiKey('sk_fc541a3702494747a9864a2597d7fea5');
    $openpay = Openpay::getInstance('mdyezendqaez49nh3lmp', 'sk_fc541a3702494747a9864a2597d7fea5', 'MX');

    $id_fb = mysqli_real_escape_string($conexion,$_POST['id']);
    $correo =  mysqli_real_escape_string($conexion,$_POST['correo']);
    $celular =  mysqli_real_escape_string($conexion,$_POST['celular']);
    $celularext =  mysqli_real_escape_string($conexion,$_POST['celularExt']);
    $nacimiento =  mysqli_real_escape_string($conexion,$_POST['nacimiento']);

    $nombre = mysqli_real_escape_string($conexion,$_GET['nombre']);
    $apellido = mysqli_real_escape_string($conexion,$_GET['apellido']);

    $consulta = "UPDATE usuario SET correo = '$correo', celular = '$celular', celular_ext = '$celularext', fec_nac = '$nacimiento', tipo_usuario = '1' WHERE id_facebook = '$id_fb'";
    //EJECUTA LA SENTENCIA SQL
    mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));

    $consultaS = "SELECT id_usuario FROM usuario WHERE id_facebook = '$id_fb'";
    //EJECUTA LA SENTENCIA SQL
    $resultado = mysqli_query($conexion,$consultaS) or die (mysqli_error($conexion));

    while($res = mysqli_fetch_array($resultado)){
        $id = $res['id_usuario'];
    }

    $customerData = array(
        'external_id' => $id,
        'name' => $nombre,
        'last_name' => $apellido,
        'email' => $correo,
        'phone_number' => $celular);
    $customer = $openpay->customers->add($customerData);

    class Result {}
    
    $response = new Result();
    
    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
        $response->correo = $correo;
        $response->celular = $celular;
    }
  
    echo json_encode($response);

?>