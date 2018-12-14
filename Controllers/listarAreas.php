<?php
include_once '../app/config.php'; #Configuracion
// echo str_replace("world","Peter","Hello world!");
#                 Hello Peter!
// echo str_replace(DS,"/",ROOT.'Models/usuario.php');
// include_once 'Models/area.php';
include_once str_replace(DS,"/",ROOT.'Models/area.php');

// include_once URL.'Models/usuario.php';
$area = new Area();
$answer  = $area->listarAreas();
$data=array();
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC

    $data[] = array(
      'id'    => $row['id'],
      'nombreArea' => utf8_encode($row['nombreArea']),
      'ceco' => $row['ceco'],
      'Tool' => "<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
    );
}

echo json_encode($data); 
?>