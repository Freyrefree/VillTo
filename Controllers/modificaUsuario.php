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
    $key = $_POST['key'];
    $keyold = $_POST ['keyold'];
    $nombre = $_POST['nombre'];
    $app = $_POST['app'];
    $apm = $_POST['apm'];
    $puesto = $_POST['puesto'];
    $correo = $_POST['correo'];
    $perfil = $_POST['perfil'];
    $area = $_POST['area'];
    $oficina = $_POST['oficina'];
    if(!$_POST['contrasena']){$password = "";}else{$password = $_POST['contrasena'];}
}
#Recepcion de datos $_POST

$usuario->set('id', $key);
$usuario->set('nombre', utf8_decode($nombre));
$usuario->set('app', utf8_decode($app));
$usuario->set('apm', utf8_decode($apm));
$usuario->set('correo', $correo);
$usuario->set('puesto', utf8_decode($puesto));
$usuario->set('perfil', $perfil);
$usuario->set('oficina', $oficina);
if($password=="") $usuario->set('password', $password); else $usuario->set('password', addslashes(utf8_decode(sha1(md5($password)))));
$usuario->set('area', $area);


if($key == $keyold){// Sólo entra aquí si no se modificó el No de usuario ejemplo 12345 = 12345 

    $answer = $usuario->modificaUsuario();
    if($answer){
        echo "1";
    }else{
        echo "0";
    }

}else{ //Si se modifica el usaurio ejemplo 12345 = 54321 -> false

    $answer0 = $usuario->existenciaUsuarioUpdate();
    if($answer0){

        $answer = $usuario->modificaUsuario();
        if($answer){
            echo "1";
        }else{
            echo "0";
        }

    }else{
        echo "2"; //no se puede registrar el usuario, ya existe en la BD
    }


}





?>