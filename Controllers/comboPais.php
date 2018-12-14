<?php
include_once '../app/config.php'; #Configuracion
// echo str_replace("world","Peter","Hello world!");
#                 Hello Peter!

include_once str_replace(DS,"/",ROOT.'Models/proveedor.php');


$proveedor = new Proveedor();
$answer  = $proveedor->comboPais();
$data=array();
while($row = mysqli_fetch_array($answer))
{
    $c_pais = utf8_encode($row['c_pais']);
    $nombre_pais = utf8_encode($row['nombre']);

    $arraypais[] = array("c_pais" => $c_pais, "nombre_pais" => $nombre_pais);
    
}

echo json_encode($arraypais); 
?>