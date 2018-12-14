<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/cuenta.php');

$cuenta = new Cuenta();

$bancoCuenta = $_POST['bancoCuenta'];

$Arrcuenta = explode("|",$bancoCuenta);

$cuenta->set('id', trim($Arrcuenta[0]));
$cuenta->obtieneClabeInterbancaria();

$nocuenta       = $cuenta->get('num_cuenta');
$banco          = $cuenta->get('banco');
$clabe          = $cuenta->get('clabeInterbancaria');
$clavesat       = $cuenta->get('claveSAT');
$santander      = $cuenta->get('codigoSantander');
echo $nocuenta."[_]".$banco."[_]".$clabe."[_]".$clavesat."[_]".$santander;

?>