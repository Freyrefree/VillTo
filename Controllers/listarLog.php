<?php
include_once '../app/config.php'; #Configuracion
// echo str_replace("world","Peter","Hello world!");
#                 Hello Peter!
// echo str_replace(DS,"/",ROOT.'Models/usuario.php');
include_once str_replace(DS,"/",ROOT.'Models/log.php');
// include_once URL.'Models/usuario.php';
$log = new Log();
$folio = @$_GET['id'];
$log->set('folio',$folio);
$answer  = $log->listarLog();
$data=array();
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC

    $data[] = array(
        'id' => $row['id'],
        'folio' => $row['folio'],
        'responsable' => $row['responsable'],
        'descripcion' => utf8_encode($row['descripcion']),
        'fecha' => $row['fecha']
    );
}

echo json_encode($data); 
?>