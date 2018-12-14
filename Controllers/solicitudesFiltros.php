<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');

$idUsuario = $_SESSION['_pid'];
$perfil = $_SESSION['_prol'];

$asignacion = new Asignacion();
//complemento
$complemento = "";
if($perfil == 2){#autorizador (supervisor) 
  $asignacion->set('idusuario', $idUsuario);
  $asignados  = $asignacion->listarAsignados();
  $complemento = "WHERE s.idusuario IN";
  $complemento.= " (".$idUsuario;
  while($fila = mysqli_fetch_array($asignados)){

    $complemento.= ",";
    $complemento.= $fila["idusuario"];

  }
  $complemento.= ")";
}else if(($perfil == 3)){ #ejecutivo empleado
    $complemento = "WHERE s.idusuario = '".$idUsuario."'";
}else if(($perfil == 4)){
    $complemento = "WHERE s.idusuario = '".$idUsuario."'";
}else if(($perfil == 1)){
    $complemento = "where";
}
//************************** */

//************************ */
$selectorFecha = @$_GET["selectorFecha"];
$solicitud = new Solicitud();
if ($selectorFecha == 1) 
{
    
    $fecha_inicio = @$_GET["fecha_inicio"];

    if ($fecha_inicio != '') {
        $fecha_inicio = date("d/m/Y", strtotime($fecha_inicio));
    } else {
        $fecha_inicio = '';
    }

    $fecha_fin = @$_GET["fecha_fin"];
    if ($fecha_fin != '') {
        $fecha_fin = date("d/m/Y", strtotime($fecha_fin));
    } else {
        $fecha_fin = '';
    }



    $estatus = @$_GET["estatus"];
    $solicitud->set("fecha_inicio", $fecha_inicio);
    $solicitud->set("fecha_fin", $fecha_fin);
    $solicitud->set("estatus", $estatus);
    $solicitud->set("complemento", $complemento);

    if ($fecha_inicio != '' && $fecha_fin != '' && $estatus == "0") {
        $answer  = $solicitud->filtrarSolicitudesFechas();
    } elseif ($fecha_inicio != '' && $fecha_fin != '' && $estatus != "0") {
        $answer  = $solicitud->filtrarSolicitudesFechasEstatus();
    } elseif ($fecha_inicio == '' && $fecha_fin == '' && $estatus == "0") {
        $solicitud->set("complemento", "");
        $answer  = $solicitud->listarSolicitudes();
    } elseif ($fecha_inicio == '' && $fecha_fin == '' && $estatus != "0") {
        $answer  = $solicitud->filtrarSolicitudesEstatus();
    }
}else if($selectorFecha == 2)
{
  $fecha_inicio = @$_GET["fecha_inicio"];

  if ($fecha_inicio != '') {
      $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
  } else {
      $fecha_inicio = '';
  }

  $fecha_fin = @$_GET["fecha_fin"];
  if ($fecha_fin != '') {
      $fecha_fin = date("Y-m-d", strtotime($fecha_fin));
  } else {
      $fecha_fin = '';
  }



  $estatus = @$_GET["estatus"];
  $solicitud->set("fecha_inicio", $fecha_inicio);
  $solicitud->set("fecha_fin", $fecha_fin);
  $solicitud->set("estatus", $estatus);
  $solicitud->set("complemento", $complemento);

  if ($fecha_inicio != '' && $fecha_fin != '' && $estatus == "0") {
      $answer  = $solicitud->filtrarSolicitudesFechaslim();
  } elseif ($fecha_inicio != '' && $fecha_fin != '' && $estatus != "0") {
      $answer  = $solicitud->filtrarSolicitudesFechasEstatuslim();
  } elseif ($fecha_inicio == '' && $fecha_fin == '' && $estatus == "0") {
        $solicitud->set("complemento", "");
      $answer  = $solicitud->listarSolicitudes();
  } elseif ($fecha_inicio == '' && $fecha_fin == '' && $estatus != "0") {
      $answer  = $solicitud->filtrarSolicitudesEstatus();
  }

}
//***

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
    $estatus = strtoupper($row['estatus']);

    if($row['importancia']=="si"){
      $importancia="<i class='fa fa-bookmark' style='color:#154360' aria-hidden='true'></i>";
    }
    $tipNo = 0;
    // if($row['tipoSolicitud'] == "Nomina") $tipNo = 1;
    $idsolicitante = $row['idusuario'];
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
      'factura'         => '<strong><a href="#" title="Facturas" class="linkIcono" onclick="facturas('.$row['id'].');"><i class="fa fa-folder-open folder" aria-hidden="true"></i></a></strong>',
      'comprobante'     => '<strong><a title="Comprobantes de Pago" href="#" class="linkIcono" onclick="comprobantes('.$row['id'].');"><i class="fa fa-file-text pdf" aria-hidden="true"></i></a></strong>',
      'vermas'          => '<strong><a title="Detalle" href="#" class="linkIcono" onclick="detallesolicitud('.$row['id'].');"><i class="fa fa-list" aria-hidden="true"></i></a></strong>'
      // ,'.$tipNo.'
      #"<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>",
    );
}
echo json_encode($data); 
?>