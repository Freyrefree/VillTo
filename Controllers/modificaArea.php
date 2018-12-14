<?php

#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/area.php'); #Modelo Usuario
$area = new area();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/areas.php');
    exit;
}else{
    $id = $_POST['id'];
    $nombreArea = $_POST['nombreArea'];
    $ceco = $_POST['ceco'];
}
#Recepcion de datos $_POST

$area->set('id', $id);
$area->set('nombreArea', $nombreArea);
$area->set('ceco', $ceco);

$answer = $area->modificaArea();

if($answer){
    echo "1";
}else{
    echo "0";
}
?>