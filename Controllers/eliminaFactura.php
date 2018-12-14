<?php 
include_once '../app/config.php'; #Configuracion

if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
}else{
    $factura = $_POST['rutaFactura'];
    chmod($factura, 0777);
    unlink($factura);
    echo 1;
}

?>