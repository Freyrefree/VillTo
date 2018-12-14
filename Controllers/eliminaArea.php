<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/area.php');

$area = new Area();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/Areas.php');
    exit;
} else {
    $id = $_POST['id'];
}
#Recepcion de datos $_POST

$id = $_POST['id'];
$area->set('id', $id);
$answer = $area->eliminaArea();

if($answer){
    echo "1";
}else{
    echo "0";
}
?>