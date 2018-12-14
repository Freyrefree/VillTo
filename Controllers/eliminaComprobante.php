<?php 
include_once '../app/config.php'; #Configuracion

if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
}else{
    $comprobante = $_POST['rutaComprobante'];
    chmod($comprobante, 0777);
    unlink($comprobante);
    echo 1;
}

?>