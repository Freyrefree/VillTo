<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');
#parametros requeridos
$asignacion = new Asignacion();

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/usuarios.php');
    exit;
} else {
    $id = $_POST['id'];
}
#Recepcion de datos $_POST

$asignacion->set('id', $id);
$answer = $asignacion->eliminaAsignacion();

if($answer){
    echo "1";
}else{
    echo "0";
}
?>