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

    //$idusuario = trim($_POST['idusuario']);
    $idUsuario = trim($_POST['idUsuario']);

    //$data[] = array();

    $asignacion->set('idusuario',$idUsuario);
    $respuesta = $asignacion->consultaTipoSolicitud();

    if(mysqli_num_rows($respuesta) > 1){

        while($row = mysqli_fetch_array($respuesta)){
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

            $data[] = array(
            'identificadorTipo' => $row['tipo'],
            'tipo'              => $tipo);
        }

    }else{

        while ($row = mysqli_fetch_array($respuesta)) {
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

            $data[] = array(
            'identificadorTipo' => $row['tipo'],
            'tipo' => $tipo);
        }
    }
    //echo count($data);

    echo json_encode($data);

}
?>