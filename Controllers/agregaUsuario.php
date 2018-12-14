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
}else{
    $no = trim($_POST['no']);
    $nombre = trim($_POST['nombre']);
    $app = $_POST['app'];
    $apm = $_POST['apm'];
    $puesto = $_POST['puesto'];
    $correo = $_POST['correo'];
    $perfil = $_POST['perfil'];
    $area = $_POST['area'];
    $oficina = $_POST['oficina'];
    $password = $_POST['contrasena'];
}
#Recepcion de datos $_POST
$usuario->set('id', utf8_decode($no));
$usuario->set('nombre', utf8_decode($nombre));
$usuario->set('app', utf8_decode($app));
$usuario->set('apm', utf8_decode($apm));
$usuario->set('puesto', $puesto);
$usuario->set('correo', $correo);
$usuario->set('perfil', $perfil);
$usuario->set('password', addslashes(utf8_decode(sha1(md5($password)))));
$usuario->set('area', $area);
$usuario->set('oficina', $oficina);

$answer0 = $usuario->existenciaUsuario();
if($answer0){

    $answer = $usuario->registraUsuario();
    if($answer){
        echo "1";
    }else{
        echo "0";
    }

}else{
    echo "2"; //no se puede registrar el usuario, ya existe en la BD
}



?>