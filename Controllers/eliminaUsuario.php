<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo Usuario
$usuario = new Usuario();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/usuarios.php');
    exit;
} else {
    $id = $_POST['id'];
}
#Recepcion de datos $_POST

$id = $_POST['id'];
$usuario->set('id', $id);
$answer = $usuario->desactivaUsuario();

if($answer){
    echo "1";
}else{
    echo "0";
}
?>