<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/banco.php');

$banco = new Banco();

$nombrebanco = $_POST['nombrebanco'];

$banco->set('banco', $nombrebanco);
$banco->datosBanco();

$claveSantander = $banco->get('claveSantander');
$claveSat = $banco->get('claveSat');
echo $claveSantander."[_]".$claveSat;

?>