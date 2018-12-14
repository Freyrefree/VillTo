<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo Proveedor
$proveedor = new Proveedor();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
}else{
    $id=$_POST['id'];
}
#Recepcion de datos $_POST

$proveedor->set('id',$id);
$proveedor->consultaProveedor();
$numproveedor=$proveedor->get('numproveedor');
echo $numproveedor;

?>


