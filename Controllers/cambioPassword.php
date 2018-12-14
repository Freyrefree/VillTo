<?php
include_once '../app/config.php'; #Configuracion

include_once str_replace(DS,"/",ROOT.'Models/usuario.php');
$usuario = new Usuario();

$idUsuario      = $_POST['cambioid'];
$correo         = $_POST['usuario']; 
$actual         = $_POST['actual'];
$actual         = sha1(md5($actual));
$nueva          = $_POST['nueva'];
$confirmacion   = $_POST['confirmacion'];

if($nueva == $confirmacion){

    $usuario->set('email',$correo);
    $usuario->set('password',$actual);
    $answer = $usuario->validaExistenciaUsuario();
    if($answer){
        $psencrpt = sha1(md5($nueva));
        $usuario->set('id',$idUsuario);
        $usuario->set('password',$psencrpt);
        $answer2=$usuario->actulizaPSW();
        if($answer2){
            echo 1;
        }else{
            echo 3;//Error query
        } 
        

    }else{
        echo 0; //usuario no existe en bd
    }

}else{

    echo 2; //contraseñas no son iguales

}




?>