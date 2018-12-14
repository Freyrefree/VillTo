<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/area.php'); #Modelo Usuario
$area = new Area();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/Areas.php');
    exit;
}else{
    $nombreArea = trim($_POST['nombreArea']);
    $ceco = trim($_POST['ceco']);
}
#Recepcion de datos $_POST

#utf8_decode()
$area->set('nombreArea', $nombreArea);
$area->set('ceco', $ceco);

$answer = $area->registraArea();

if($answer){
    echo "1";
}else{
    echo "0";
}
?>