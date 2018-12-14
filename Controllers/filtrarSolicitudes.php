<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');

$idUsuario  = $_SESSION['_pid'];
$solicitud = new Solicitud();
$cadena = @$_GET["cadena"];
$solicitud->set("cadena",$cadena);
$answer  = $solicitud->filtarSolicitudes();
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
    $pos = strpos($row['estatus'], "Rechazado");

    if ($pos === false) {
      $estatus = strtoupper($row['estatus']);
    } else {
      // onclick="modifica('.$row['id'].');"
      $estatus = '<strong><a href="modificarSolicitud.php?cdns='.$row['id'].'" class="linkIcono" style="color:#E74C3C"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>'.strtoupper($row['estatus']).'</a></strong>';
      // $estatus = "<strong style='color:#E74C3C'>".$row['estatus']."</strong>";
    }

    if($row['importancia']=="si"){
      $importancia="<i class='fa fa-bookmark' style='color:#154360' aria-hidden='true'></i>";
    }
    $tipNo = 0;
    if($row['tipoSolicitud'] == "Nomina") $tipNo = 1;
    #VALIDACION TESORERIA
    #[218][YOLANDA GONZALEZ MONROY]
    $idsolicitante = $row['idusuario'];
    if($idUsuario == "218" && $idUsuario != $idsolicitante){
      if($estatus == "ACEPTADO" || $estatus == "ACEPTADO DF" || $estatus == "ACEPTADO DG" || $estatus == "PAGO PROGRAMADO" || $estatus == "PAGADO"){

        if($tipNo != 1){
          $data[] = array(
            'id'    => $importancia." ".$row['id'],
            'empresa'    => $row['razonSocial'],
            'tiposol' => $row['tipoSolicitud'],
            'numProveedor' => '<strong>'.$row['numproveedor'].'</strong>',
            'proveedor' => $row['proveedor'],
            'localizador' => $row['localizador'],
            'monedaImporte' => $moneda,
            'monto' => number_format($row['monto'],2,'.',','),
            'tipocambio' => number_format($row['tipocambio'],2,'.',','),
            'monedaPago' => $monedaPago,
            'montoPago' => number_format($row['conversionPago'],2,'.',','),
            'fechaSolicitud' => $row['fechasolicitud'],
            'fechaLimite' => $row['fechalimite'],
            'solicitante' => $row['nombre']." ".$row['apellidoPaterno'],
            'estatus' => $estatus,
            'factura' => '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].','.$tipNo.');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
            'comprobante' => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
            'vermas' => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
            #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
          );
        }else{
          if($idUsuario == "225" || $idUsuario == "241" || $idUsuario == "218" || $idUsuario == "246"){
            $data[] = array(
              'id'    => $importancia." ".$row['id'],
              'empresa'    => $row['razonSocial'],
              'tiposol' => $row['tipoSolicitud'],
              'numProveedor' => '<strong>'.$row['numproveedor'].'</strong>',
              'proveedor' => $row['proveedor'],
              'localizador' => $row['localizador'],
              'monedaImporte' => $moneda,
              'monto' => number_format($row['monto'],2,'.',','),
              'tipocambio' => number_format($row['tipocambio'],2,'.',','),
              'monedaPago' => $monedaPago,
              'montoPago' => number_format($row['conversionPago'],2,'.',','),
              'fechaSolicitud' => $row['fechasolicitud'],
              'fechaLimite' => $row['fechalimite'],
              'solicitante' => $row['nombre']." ".$row['apellidoPaterno'],
              'estatus' => $estatus,
              'factura' => '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].','.$tipNo.');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
              'comprobante' => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
              'vermas' => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
              #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
            );
          }
        }
      }
    }else{
      if($tipNo != 1){
        $data[] = array(
          'id'    => $importancia." ".$row['id'],
          'empresa'    => $row['razonSocial'],
          'tiposol' => $row['tipoSolicitud'],
          'numProveedor' => '<strong>'.$row['numproveedor'].'</strong>',
          'proveedor' => $row['proveedor'],
          'localizador' => $row['localizador'],
          'monedaImporte' => $moneda,
          'monto' => number_format($row['monto'],2,'.',','),
          'tipocambio' => number_format($row['tipocambio'],2,'.',','),
          'monedaPago' => $monedaPago,
          'montoPago' => number_format($row['conversionPago'],2,'.',','),
          'fechaSolicitud' => $row['fechasolicitud'],
          'fechaLimite' => $row['fechalimite'],
          'solicitante' => $row['nombre']." ".$row['apellidoPaterno'],
          'estatus' => $estatus,
          'factura' => '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].','.$tipNo.');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
          'comprobante' => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
          'vermas' => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
          #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
        );
      }else{
        if($idUsuario == "225" || $idUsuario == "241" || $idUsuario == "218" || $idUsuario == "246"){
          $data[] = array(
            'id'    => $importancia." ".$row['id'],
            'empresa'    => $row['razonSocial'],
            'tiposol' => $row['tipoSolicitud'],
            'numProveedor' => '<strong>'.$row['numproveedor'].'</strong>',
            'proveedor' => $row['proveedor'],
            'localizador' => $row['localizador'],
            'monedaImporte' => $moneda,
            'monto' => number_format($row['monto'],2,'.',','),
            'tipocambio' => number_format($row['tipocambio'],2,'.',','),
            'monedaPago' => $monedaPago,
            'montoPago' => number_format($row['conversionPago'],2,'.',','),
            'fechaSolicitud' => $row['fechasolicitud'],
            'fechaLimite' => $row['fechalimite'],
            'solicitante' => $row['nombre']." ".$row['apellidoPaterno'],
            'estatus' => $estatus,
            'factura' => '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].','.$tipNo.');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
            'comprobante' => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
            'vermas' => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
            #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
          );
        }
      }
      // $data[] = array(
      //   'id'    => $importancia." ".$row['id'],
      //   'empresa'    => $row['razonSocial'],
      //   'tiposol' => $row['tipoSolicitud'],
      //   'numProveedor' => '<strong>'.$row['numproveedor'].'</strong>',
      //   'proveedor' => $row['proveedor'],
      //   'localizador' => $row['localizador'],
      //   'monedaImporte' => $moneda,
      //   'monto' => number_format($row['monto'],2,'.',','),
      //   'tipocambio' => number_format($row['tipocambio'],2,'.',','),
      //   'monedaPago' => $monedaPago,
      //   'montoPago' => number_format($row['conversionPago'],2,'.',','),
      //   'fechaSolicitud' => $row['fechasolicitud'],
      //   'fechaLimite' => $row['fechalimite'],
      //   'solicitante' => $row['nombre']." ".$row['apellidoPaterno'],
      //   'estatus' => $estatus,
      //   'factura' => '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].','.$tipNo.');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
      //   'comprobante' => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
      //   'vermas' => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
      //   #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
      // );
    }
  #-----------------------------------------------------
  // $moneda = "";
  //   $monedaPago = "";
  //   $estatus = "";
  //   $importancia = "";
  //   $divisas = array(
  //     "DolaresAustralia" => "AUD",
  //     "Real" => "BRL",
  //     "DolaresCanada" => "CAD",
  //     "Euros" => "EUR",
  //     "DolaresFidji" => "FJD",
  //     "Libra" => "GBP",
  //     "Yen" => "JPY",
  //     "Pesos" => "MXN",
  //     "DolaresZelanda" => "NZD",
  //     "DolaresSingapur" => "SGD",
  //     "Baht" => "THB",
  //     "Dolares" => "USD",
  //     "Rand" => "ZAR",
  // );

  //   $moneda = $divisas[$row['moneda']];
  //   $monedaPago = $divisas[$row['monedaPago']];

  //   $pos = strpos($row['estatus'], "Rechazado");

  //   if ($pos === false) {
  //     $estatus= strtoupper($row['estatus']);
  //   } else {
  //     $estatus = '<strong><a href="modificarSolicitud.php?cdns='.$row['id'].'" class="linkIcono" style="color:#E74C3C"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>'.strtoupper($row['estatus']).'</a></strong>';
  //     // $estatus = "<strong style='color:#E74C3C'>".$row['estatus']."</strong>";
  //   }

  //   if($row['importancia']=="si"){
  //     $importancia="<i class='fa fa-bookmark' style='color:#154360' aria-hidden='true'></i>";
  //   }

  //   $data[] = array(

  //     'id'    => $importancia." ".$row['id'],
  //     'empresa'    => $row['razonSocial'],
  //     'tiposol' => $row['tipoSolicitud'],
  //     'numProveedor' => '<strong>'.$row['numproveedor'].'</strong>',
  //     'proveedor' => $row['proveedor'],
  //     'localizador' => $row['localizador'],
  //     'monedaImporte' => $moneda,
  //     'monto' => number_format($row['monto'],2,'.',','),
  //     'tipocambio' => number_format($row['tipocambio'],2,'.',','),
  //     'monedaPago' => $monedaPago,
  //     'montoPago' => number_format($row['conversionPago'],2,'.',','),
  //     'fechaSolicitud' => $row['fechasolicitud'],
  //     'fechaLimite' => $row['fechalimite'],
  //     'solicitante' => $row['nombre']." ".$row['apellidoPaterno'],
  //     'estatus' => $estatus,
  //     'factura' => '<strong><a title="Facturas" href="#" class="linkIcono" onclick="facturas('.$row['id'].');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
  //     'comprobante' => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
  //     'vermas' => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
  //     #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
  //   );
}
echo json_encode($data); 
?>