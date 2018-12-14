<?php

include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/usuario.php');
$usuario = new Usuario();
$answer  = $usuario->listarGerentes();
$data=array();
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC
     echo '<option value="'.$row['id'].'|'.$row['nombre']." ".$row['apellidoPaterno'].'">'.$row['nombre']." ".$row['apellidoPaterno'].'</option>';
}

?>