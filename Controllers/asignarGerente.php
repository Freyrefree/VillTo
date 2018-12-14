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
}else{
    $idusuario = trim($_POST['idusuario']);
    $datosgerente = trim($_POST['gerente']);
    $gerente = explode('|',$datosgerente); # Division de datos gerente [ id | Nombre Apellido ]
    $tipoAsignacion = $_POST['tipoAsignacion'];
}
#Recepcion de datos $_POST

$asignacion->set('idusuario', $idusuario);
$asignacion->set('idgerente', $gerente[0]);
$asignacion->set('nombreGerente', $gerente[1]);
$asignacion->set('tipo',$tipoAsignacion);


#verificar si se puede asignar (sólo debe existir un tipo de gerente ya se operador o proveedor, no puede haber 2 asignaciones iguales)
$verifica = $asignacion->verificaAsignacion();
if(mysqli_num_rows($verifica) > 0){

    echo "3"; //Ya existe una asignación

}else{

    $answer = $asignacion->asignarGerente();
    if($answer){
        echo "1";
    }else{
        echo "0";
    }

}



?>