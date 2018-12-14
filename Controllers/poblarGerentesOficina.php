<?php

include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/usuario.php');
$usuario = new Usuario();

$idUsuario = $_POST['id_usuario'];
$usuario->set('id',$idUsuario);



#obtener la oficina del usuario
$usuario->obtenerOficina();
$oficina = $usuario->get('oficina');
#

$usuario->set('oficina',$oficina);
$answer  = $usuario->listarGerentesoficina();
//$data=array();


while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC
     //echo '<option value="'.$row['id'].'|'.$row['nombre']." ".$row['apellidoPaterno'].'">'.$row['nombre']." ".$row['apellidoPaterno'].'</option>';
     $data[] = array(
         'id'               => $row['id'],
         'nombre'           => $row['nombre'],
         'apellidoPaterno'  => $row['apellidoPaterno'],
         'apellidoMaterno'  => $row['apellidoMaterno']
     );
}

echo json_encode($data);

?>