<?php
function logs($folio,$responsable,$descripcion){
    $retorno = false;
    include_once '../app/config.php'; #Configuracion
    include_once str_replace(DS, "/", ROOT . 'Models/log.php'); #Modelo Proveedor
    $log = new Log();

    $log->set('folio', utf8_decode($folio));
    $log->set('responsable', utf8_decode($responsable));
    $log->set('descripcion', utf8_decode($descripcion));

    if($log->registraLog()){
        $retorno = true;
    }else{
        $retorno = false;
    }

    return $retorno;
}
?>