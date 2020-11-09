<?php
    require('../headers.php');
    require('../conexion.php');
    require_once('../../vendor/autoload.php');

    $conexion = conexion();

    class Result {}
    $response = new Result();

    date_default_timezone_set('UTC');

    $nombre_usuario = mysqli_real_escape_string($conexion,$_POST['firstName']);
    $apellido_usuario = mysqli_real_escape_string($conexion,$_POST['lastName']);
    $correo = mysqli_real_escape_string($conexion,$_POST['correo']);
    $celular = mysqli_real_escape_string($conexion,$_POST['celular']);
    $id = mysqli_real_escape_string($conexion,$_POST['id_usuario']);
    
    $total = mysqli_real_escape_string($conexion,$_GET['total']);
    $order_id = mysqli_real_escape_string($conexion,$_GET['id_venta']);

    $fecha = mktime(0, 0, 0, date("m")  , date("d")+4, date("Y"));
    $fecha_limite = date('c', $fecha);

    Openpay::setId('mdyezendqaez49nh3lmp');
    Openpay::setApiKey('sk_fc541a3702494747a9864a2597d7fea5');
    $openpay = Openpay::getInstance('mdyezendqaez49nh3lmp', 'sk_fc541a3702494747a9864a2597d7fea5', 'MX');

    $findDataRequest = array(
        'external_id' => strval($id)
    );
    $customerList = $openpay->customers->getList($findDataRequest);

    $customer = $customerList[0];
    $cargoInfo = array(
        'order_id' => $order_id,
        'due_date' => $fecha_limite,
        'method' => 'store',
        'amount' => $total,
        'description' => 'Cargo a tienda');
        
    $cargo = $customer->charges->create($cargoInfo);

    $recibo = "https://sandbox-dashboard.openpay.mx/paynet-pdf/"."mdyezendqaez49nh3lmp"."/".$cargo->serializableData['payment_method']->reference;

    $consulta = "UPDATE venta SET link_pago = '$recibo' WHERE id_venta = '$order_id'";
    mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));
    

    if(mysqli_error($conexion)){
        $response->resultado = 'ERROR';
    }
    else{
        $response->resultado = 'OK';
    }
    echo json_encode($response); 
?>