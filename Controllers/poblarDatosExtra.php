<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo Proveedor
$proveedor = new Proveedor();

$datosProvier = $_GET['proveedor'];
$provier = explode("|",$datosProvier);

$proveedor->set('id', trim($provier[0]));

$proveedor->consultaProveedor();

$aba=$proveedor->get('aba');
$swift=$proveedor->get('swift');

echo $aba."|".$swift;

?>