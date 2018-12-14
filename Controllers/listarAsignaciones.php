<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');
$asignacion = new Asignacion();

if (!$_GET["idusuario"]) {
    exit;
}else{
    
    $idusuario = $_GET["idusuario"];

    $asignacion->set('idusuario', $idusuario);
    $answer  = $asignacion->listarAsignacion();
    $data=array();
    while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC
        $tipo = $row['tipo'];

        switch ($tipo) {
            case 1:
                $tipo = "Operadores";
                break;
            case 2:
                $tipo = "Proveedores";
                break;
            default:
                $tipo = "udefinded";
        }

        $idGerente = $row['idgerente'];
        $asignacion->set('idGerente',$idGerente);
        $asignacion->nombreGerente();
        $nombreGerente = utf8_encode($asignacion->get('nombreGerente'));

        $data[] = array(
        'id'        => $row['id'],
        'noUsuario' => $row['idgerente'],
        'gerente'   => $nombreGerente,
        'tipo'      => $tipo,
        //'oficina'   => utf8_encode($row['oficina']),
        'Tool'      => "&nbsp;&nbsp;&nbsp;<a href='javascript:eliminarAsignacion(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
    
        );
    }
    echo json_encode($data); 
}
?>