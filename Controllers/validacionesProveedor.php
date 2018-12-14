<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo Proveedor

$proveedor = new Proveedor();

if (!$_POST) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
}else{

    $rfc            = trim($_POST['rfc']);
    $razonsocial    = $_POST['razonsocial'];


    if($rfc == 'XEXX010101000') ## Validar cuando es Extranjero. Validar por Razon social ##
    {

        $proveedor->set('razonsocial', utf8_decode($razonsocial));
        $respuesta = $proveedor->razonSocialExistente();

        if(!$respuesta){
            echo "2"; ## Ya existe con esa razon social ##
        }else{
            echo "1"; ## No existe, puede continuar ##
        }

    }else ## Validar cuando es Nacional. Validar por RFC ##
    {
        $proveedor->set('rfc', utf8_decode($rfc));
        $respuesta = $proveedor->rfcExistente();

        if(!$respuesta){
            echo "3"; ## Ya existe con ese rfc##
        }else{
            echo "1"; ## No existe, puede continuar ##
        }

    }


}



?>