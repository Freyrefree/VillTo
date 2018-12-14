<?php
include_once '../app/config.php'; #Configuracion
// echo str_replace("world","Peter","Hello world!");
#                 Hello Peter!

include_once str_replace(DS,"/",ROOT.'Models/proveedor.php');


$proveedor = new Proveedor();
$answer  = $proveedor->listarProveedores();
$data=array();
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC

  //$numproveedor = utf8_encode($row['numproveedor']);
  $numproveedor = utf8_encode($row['id']);
  $numproveedor = '"'.$numproveedor.'"';
  $archivo_caratula = utf8_encode($row['archivo_caratula']);
  $archivo_caratula = '"'.$archivo_caratula.'"';
  $archivo_cedula = utf8_encode($row['archivo_cedula']);
  $archivo_cedula = '"'.$archivo_cedula.'"';

  $c_pais = utf8_encode($row['pais']);
  $proveedor->set('c_pais',$c_pais);
  $respuesta  = $proveedor->consultaNombrePais();
  $nombre_pais = $proveedor->get('nombre_pais');
  $indica = "";
  if($row['activo'] == "re")
  {
    $indica = "<i class='fa fa-certificate' style='color:#BA4A00' aria-hidden='true' ></i>";
  }

    $data[] = array(
    	
      'id'    => $indica.$row['id'],
      'numproveedor' => $row['numproveedor'],
      'rfc' => utf8_encode($row['rfc_taskid']),
      'razonsocial' => utf8_encode($row['razon_social']),      
      'direccion' => utf8_encode($row['direccion']),      
      'cp' => utf8_encode($row['cp']),
      'aliascomercial' => utf8_encode($row['alias_comercial']),
      'pais' => utf8_encode($nombre_pais),
      'email' => utf8_encode($row['correo']),
      'contacto' => utf8_encode($row['contacto']),
      'tel1' => utf8_encode($row['tel']),
      'tel2' => utf8_encode($row['tel2']),      
      'activo' => utf8_encode($row['activo']),
      'tipo' => utf8_encode($row['tipo']),
      'operacion' => "<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:cuentas(".$row['id'].")' class='azul'><i class='fa fa-university' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:archivos(".$row['id'].",".$numproveedor.",".$archivo_caratula.",".$archivo_cedula.")' class='azul'><i class='fa fa-file-text' aria-hidden='true'></i></a>"
      
     
     );
}

echo json_encode($data); 
?>