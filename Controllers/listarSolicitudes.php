<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');
$asignacion = new Asignacion();
$solicitud = new Solicitud();

$idUsuario = $_SESSION['_pid'];
$perfil = $_SESSION['_prol'];
//complemento
$complemento = "";

if($perfil == 2){#autorizador (supervisor) 
  $asignacion->set('idusuario', $idUsuario);
  $asignados  = $asignacion->listarAsignados();
  $complemento = "WHERE s.idusuario IN";
  $complemento.= " ("."'".$idUsuario."'";
  while($fila = mysqli_fetch_array($asignados)){

    $complemento.= ",";
    $complemento.= "'".$fila["idusuario"]."'";

  }
  $complemento.= ")";
}else if(($perfil == 3)){ # Ejecutivo 
    $complemento = "WHERE s.idusuario = '".$idUsuario."'";
}else if(($perfil == 4)){ # Empleado
  $complemento = "WHERE s.idusuario = '".$idUsuario."'";
}else if(($perfil == 1)){ # Administrador
    $complemento = "";
}else if($perfil == 5){ #Contabilidad
  $complemento = "WHERE s.idusuario = '".$idUsuario."' OR s.estatus = 'Aceptado' OR s.estatus = 'Aceptado Contabilidad' OR s.estatus = 'Pago Programado' OR s.estatus = 'pagado'";

}else if($perfil == 6){ #Tesorería
  $complemento = "WHERE s.idusuario = '".$idUsuario."' OR s.estatus = 'Aceptado Contabilidad' OR s.estatus = 'Pago Programado' OR s.estatus = 'pagado'";
}
//************************** */
//$complemento = "WHERE s.idusuario = ".$idUsuario;
$empresa = "Villa Tours";
 $solicitud->set("complemento",$complemento);
$answer  = $solicitud->listarSolicitudes();
//echo $answer;
//exit;
$data=array();
while($row = mysqli_fetch_array($answer)){
      $moneda = "";
      $monedaPago = "";
      $estatus = "";
      $importancia = "";
      $divisas = array(
      "DolaresAustralia" => "AUD",
      "Real" => "BRL",
      "DolaresCanada" => "CAD",
      "Euros" => "EUR",
      "DolaresFidji" => "FJD",
      "Libra" => "GBP",
      "Yen" => "JPY",
      "Pesos" => "MXN",
      "DolaresZelanda" => "NZD",
      "DolaresSingapur" => "SGD",
      "Baht" => "THB",
      "Dolares" => "USD",
      "Rand" => "ZAR",
  );

    $moneda = $divisas[$row['moneda']];
    $monedaPago = $divisas[$row['monedaPago']];

      $estatus = strtoupper($row['estatus']);

## validar si hay archivos en carpeta de comprobantes ##

$contadorComprobantes = 0;

$folderRaiz = "Pagos/Comprobantes/";
$folderComprobantes = "../".$folderRaiz.$row['id'];


if(is_dir($folderComprobantes)){

    $directorio = opendir($folderComprobantes); //ruta de las Facturas
    
    while ($archivo = readdir($directorio)){ #Obtenemos todos los archivos contenidos

        if($archivo != "." && $archivo != '..'){          

              $contadorComprobantes++;
        }

    }
}

if($contadorComprobantes > 0){

  if($perfil != 5){

    if($estatus == strtoupper("Pago Programado") || $estatus == strtoupper('pagado')){
  
      $iconComprobante = '<strong class=" si "><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>';
    
    }else{
      $iconComprobante='<strong class=" no "></strong>';      
    }
  }else{
    $iconComprobante='<strong class=" no "></strong>';
  }

}else{

  if($perfil != 5){

    if($estatus == strtoupper("Pago Programado") || $estatus == strtoupper('pagado')){
  
      $iconComprobante = '<strong class=" no "><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdfEmpty" aria-hidden="true"></i></a></strong>';
    
    }else{
      $iconComprobante='<strong class=" no "></strong>';      
    }
  }else{
    $iconComprobante='<strong class=" no "></strong>';
  }

}










    $txt = $row['txt'];
    if($txt == ''){
      $iconTXT = '<strong><a title="TXT" href="#" class="linkIcono"><i class="fa fa-file txtEmpty no " aria-hidden="true"></i></a></strong>';
    }else{

      $iconTXT = '<strong><a title="TXT" href="#" class="linkIcono" onclick="txt('.$row['id'].');"><i class="fa fa-file si " aria-hidden="true"></i></a></strong>';
    }

    if($row['importancia']=="si"){
      $importancia="<i class='fa fa-bookmark' style='color:#154360' aria-hidden='true'></i>";
    }
    $tipNo = 0;
    // if($row['tipoSolicitud'] == "Nomina") $tipNo = 1;
    $idsolicitante = $row['idusuario'];



## verificar contenido de carpeta Facturas ##

    $contadorFacturas = 0;

    $folderRaiz = "Pagos/Facturas/";
    $folderFacturas = "../".$folderRaiz.$row['id'];


    if(is_dir($folderFacturas)){

        $directorio = opendir($folderFacturas); //ruta de las Facturas
        
        while ($archivo = readdir($directorio)){ #Obtenemos todos los archivos contenidos

            if($archivo != "." && $archivo != '..'){

                $array = explode('.', $archivo);
                $extension = $array[count($array) - 1];

                if($extension != "zip"){

                  $contadorFacturas++;

                }

            }

        }
    }

  if($contadorFacturas > 0){

    $iconFacturas = '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].');"><i class="fa fa-folder-open folder si " aria-hidden="true"></i></a></strong>';
  }else{

    $iconFacturas = '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].');"><i class="fa fa-folder folderEmpty no " aria-hidden="true"></i></a></strong>';
    
  }

  ## ****************************************************** ##
    





    $data[] = array(
      'id'              => $importancia." ".$row['id'],
      'empresa'         => utf8_encode($row['oficina']),//$empresa,#$row['razonSocial'],
      'tiposol'         => $row['tipoSolicitud'],
      'numProveedor'    => '<strong>'.$row['numproveedor'].'</strong>',
      'proveedor'       => $row['proveedor'],
      'localizador'     => $row['localizador'],
      'monedaImporte'   => $moneda,
      'monto'           => number_format($row['monto'],2,'.',','),
      'tipocambio'      => number_format($row['tipocambio'],2,'.',','),
      'monedaPago'      => $monedaPago,
      'montoPago'       => number_format($row['conversionPago'],2,'.',','),
      'fechaSolicitud'  => $row['fechasolicitud'],
      'fechaLimite'     => $row['fechalimite'],
      'solicitante'     => utf8_encode($row['nombre'])." ".utf8_encode($row['apellidoPaterno']),
      'estatus'         => $estatus,
      'factura'         => $iconFacturas,
      'comprobante'     => $iconComprobante,
      'txt'             => $iconTXT,
      'vermas'          => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
      // ,'.$tipNo.'
      #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
    );
}
echo json_encode($data); 
?>