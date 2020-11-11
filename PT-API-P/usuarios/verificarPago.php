<?php

    require('../headers.php');
    require('../conexion.php');
    require_once('../../vendor/autoload.php');

    $conexion = conexion();

    class Result {}
    $response = new Result();

    $id_usuario = mysqli_real_escape_string($conexion,$_GET['id_usuario']);
    $id_venta = mysqli_real_escape_string($conexion,$_GET['id_venta']);

    Openpay::setId('mdyezendqaez49nh3lmp');
    Openpay::setApiKey('sk_fc541a3702494747a9864a2597d7fea5');
    $openpay = Openpay::getInstance('mdyezendqaez49nh3lmp', 'sk_fc541a3702494747a9864a2597d7fea5', 'MX');

    $findDataRequest = array(
        'external_id' => strval($id_usuario)
    );
    $customerList = $openpay->customers->getList($findDataRequest);
    $customer = $customerList[0];
    
    $chargeDataRequest = array(
        'order_id' => $id_venta
    );
    $chargeList = $customer->charges->getList($chargeDataRequest);
    $charge = $chargeList[0];

    $pago = $charge->status;

    if($pago == "completed"){
        $consulta = "UPDATE venta SET pago = '1' WHERE id_venta = '$id_venta'";
        mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));
        $response->pago = "Pagado";
    }
    else{
        $response->pago = "Pendiente de Pago";
    }

    echo json_encode($response);
?>