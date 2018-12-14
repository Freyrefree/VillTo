<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo proveedor

$proveedor = new Proveedor();
#parametros requeridos
// $tipoSP = @$_GET["tipo"];
// $tipoProv = "";
// switch ($tipoSP) {
//     case "Pre-Pago":
//         $tipoProv="'Operaciones'";
//         break; 
//     case "Comisiones":
//         $tipoProv="'Comisiones'";
//         break; 
//     case "Servicios":
//         $tipoProv="'Servicios'";
//         break;
//     case "Vencimiento Proveedores":
//         $tipoProv="'Operaciones','Servicios'";
//         break;
//     case "BSP":
//         $tipoProv="'BSP'";
//         break;
//     case "Impuestos":
//         $tipoProv="'Impuestos'";
// }

// $proveedor->set("tipo",$tipoProv);
$answer= $proveedor->listarProveedoresAuto();
$proveedores=array();
while($row = mysqli_fetch_array($answer)) {

    // $proveedores[] = $row['id']." | ".$row['numproveedor']." | ".$row['razon_social'];
    $proveedores[] = $row['id']." | ".$row['numproveedor']." | ".utf8_decode($row['razon_social']);
}

print_r(json_encode($proveedores));

?>