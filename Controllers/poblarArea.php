<?php

include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/area.php');
$area = new Area();
$answer  = $area->listarAreas();
$data=array();
$selected = "";
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC
    if($row['id'] == $idarea){ $selected = "selected";}
    echo '<option value="'.$row['id'].'"'.$selected.'>'.utf8_encode($row['nombreArea']).'</option>';
    $selected = "";
}

?>