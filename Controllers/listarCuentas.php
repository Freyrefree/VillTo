<?php
include_once '../app/config.php'; #Configuracion
// echo str_replace("world","Peter","Hello world!");
#                 Hello Peter!
// echo str_replace(DS,"/",ROOT.'Models/cuenta.php');
include_once str_replace(DS,"/",ROOT.'Models/cuenta.php');

// include_once URL.'Models/cuenta.php';


#Recepcion de datos $_POST
if (!$_GET) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
}else{
    $key = @$_GET['id'];   //Lleva @ porque se requiere actulizar la lista sin envío de ID
    // if($key == ""){
    //   exit;
    // }
}
#Recepcion de datos $_POST
$cuenta = new Cuenta();
$cuenta->set('id', $key);
$answer  = $cuenta->listarCuentas();
$data=array();
while($row = mysqli_fetch_array($answer,MYSQLI_ASSOC)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC

    $data[] = array(
    	
      'id'    => $row['id'],
      'num_cuenta' => utf8_encode($row['num_cuenta']),
      'banco' => utf8_encode($row['banco']),
      'clabeinter' => utf8_encode($row['clabeInterbancaria']),
      'claveSAT' => utf8_encode($row['clave_sat']),
      'codSantader' => utf8_encode($row['codigo_santander']),
      'divisa' => utf8_encode($row['divisa']),

      'operacion' => "<a href='javascript:eliminarCuenta(".$row['id'].",".$key.")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>"      
     
     );

}

echo json_encode($data); 
?>