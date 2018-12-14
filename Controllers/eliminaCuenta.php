<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/cuenta.php'); #Modelo Cuenta
$cuenta = new Cuenta();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
} else {
    $id = $_POST['id'];
}
#Recepcion de datos $_POST

$id = $_POST['id'];
$cuenta->set('id', $id);
$answer = $cuenta->eliminaCuenta();

if($answer){
    echo "1";
}else{
    echo "0";
}
?>