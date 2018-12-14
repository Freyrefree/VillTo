<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/cuenta.php');

$cuenta = new Cuenta();

$datosProvier = $_POST['proveedor'];

$provier = explode("|",$datosProvier);

$cuenta->set('id', trim($provier[0]));

$answer  = $cuenta->listarCuentas();

$data=array();
while($row = mysqli_fetch_array($answer))
{
    $idCuenta =  $row['id'];
    $banco = utf8_encode($row['banco']);
    $cuenta = utf8_encode($row['num_cuenta']);
    $arraypais[] = array("id" => $idCuenta,"banco" => $banco, "cuenta" => $cuenta);
}

echo json_encode($arraypais); 
?>