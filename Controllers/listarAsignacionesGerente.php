<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');
include_once str_replace(DS,"/",ROOT.'Models/usuario.php');
$asignacion = new Asignacion();
$usuario = new Usuario();

if (!$_GET["idGerente"]) {
    exit;
}else{
    
    $idGerente = $_GET["idGerente"];

    $asignacion->set('idgerente', $idGerente);
    $answer  = $asignacion->listarAsignacionGerente();
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

        $idUsuario = $row['idusuario'];
        $usuario->set('id',$idUsuario);
        $usuario->consultaUsuario();
        $nombreUsuario = $usuario->get('nombre')." ".$usuario->get('app')." ".$usuario->get('apm');


        

        $data[] = array(
        'id'        => $row['id'],
        'numUsuario'=> $row['idusuario'],
        'usuario'   => utf8_encode($nombreUsuario),
        //'oficina' => utf8_encode($row['oficina']),
        'tipo'      => $tipo

        );
    }
    echo json_encode($data); 
}
?>