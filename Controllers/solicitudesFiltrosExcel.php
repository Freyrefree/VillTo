<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Solicitudes.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);



include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');

$id_Usuario = $_SESSION['_pid'];
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
//***********************************************************
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

//$answer  = $solicitud->filtarSolicitudes();
$codigohtml = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
#exceltbl {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#exceltbl td, #exceltbl th {
    border: 1px solid #ddd;
    padding: 8px;
}

#exceltbl th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #428bca;
    color: white;
}
</style>
</head>
<body>
<table id="exceltbl">
<tr>
            <th colspan="14"><center>Listado Solicitudes</center></th>
</tr>
        <tr>
            <th>Número Folio</th>
            <th>Empresa</th>
            <th>Tipo Solicitud</th>
            <th>No Proveedor</th>
            <th>Proveedor</th>
            <th>Moneda Importe</th>
            <th>Monto</th>
            <th>Tipo Cambio</th>
            <th>Moneda Pago</th>
            <th>Monto Pago</th>
            <th>Fecha Solicitud</th>
            <th>Fecha Limite</th>
            <th>Solicitante</th>
            <th>Estatus</th>
        </tr> ';
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC

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


    $codigohtml .= '<tr>';
    $codigohtml .= '<td>'.$importancia." ".$row['id'].'</td>';
    $codigohtml .= '<td>'.utf8_encode($row['oficina']).'</td>';
    $codigohtml .= '<td>'.$row['tipoSolicitud'].'</td>';
    $codigohtml .= '<td>'.'<strong>'.$row['numproveedor'].'</strong>'.'</td>';
    $codigohtml .= '<td>'.$row['proveedor'].'</td>';
    $codigohtml .= '<td>'.$moneda.'</td>';
    $codigohtml .= '<td>'.number_format($row['monto'],2,'.',',').'</td>';
    $codigohtml .= '<td>'.number_format($row['tipocambio'],2,'.',',').'</td>';
    $codigohtml .= '<td>'.$monedaPago.'</td>';
    $codigohtml .= '<td>'.number_format($row['conversionPago'],2,'.',',').'</td>';
    $codigohtml .= '<td>'.$row['fechasolicitud'].'</td>';
    $codigohtml .= '<td>'.$row['fechalimite'].'</td>';
    $codigohtml .= '<td>'.utf8_encode($row['nombre'])." ".utf8_encode($row['apellidoPaterno']).'</td>'; 
    $codigohtml .= '<td>'.$estatus.'</td>';
    $codigohtml .= '</tr>';
    

}
$codigohtml .= '</table></body></html>';
echo $codigohtml;
?>
