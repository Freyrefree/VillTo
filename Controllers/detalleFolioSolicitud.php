<?php
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo usuario

$idUsuario  = $_SESSION['_pid'];
$nombre     = $_SESSION['_pname'];
$nombreAll  = $_SESSION['_pnamefull'];
$perfil     = $_SESSION['_prol'];
$cecoEm     = $_SESSION['_ceco'];

$usuarioOBJ = new Usuario();
$usuarioOBJ->set('id',$idUsuario);
$usuarioOBJ->consultaUsuario();
$nombreGerneteCorreo    =  utf8_encode($usuarioOBJ->get('nombre'))." ".utf8_encode($usuarioOBJ->get('app'))." ".utf8_encode($usuarioOBJ->get('apm'));


//nombreContabilidadCorreo
//nombreTesoCorreo




$asignacion = new Asignacion();
$solicitud = new Solicitud();
$solicitud->set("id",$_POST['folio']);

$answer = $solicitud->detalleFolioSolicitud();
$data=array();
    $row = mysqli_fetch_array($answer);
    $moneda = "";
    $monedaPago = "";
    $estatus = "";
    $importancia = "";

    $asignacion->set("idusuario",$row['idu']);
    $asignacion->set("idgerente",$idUsuario);
    $registro = $asignacion->buscarGerente();

    if($row['moneda']=="Dolares"){
      $moneda='<strong>USD</strong>';
    }else if($row['moneda']=="Pesos"){
      $moneda='<strong>$</strong>';
    }else if($row['moneda']=="Euros"){
      $moneda='<strong>€</strong>';
    }

    if($row['monedaPago']=="Dolares"){
      $monedaPago='<strong>USD</strong>';
    }else if($row['monedaPago']=="Pesos"){
      $monedaPago='<strong>$</strong>';
    }else if($row['monedaPago']=="Euros"){
      $monedaPago='<strong>€</strong>';
    }

    if($row['estatus']=="pendiente"){
      $estatus='<i class="fa fa-hourglass-start red" aria-hidden="true"></i>';
    }else if($row['estatus']=="aceptado"){
      $estatus='<i class="fa fa-money green" aria-hidden="true"></i>';
    }else if($row['estatus']=="pagado"){
      $estatus='<i class="fa fa-check-circle blue" aria-hidden="true"></i>';
    }

    $estatus=$row['estatus'];

    if($row['importancia']=="si"){
      $importancia="Urgente";
    }

    if($perfil == 1){

      if($estatus =="pendiente"){

          $linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitud.php?id=".$_POST['folio']."&nombreGerenteCorreo=".$nombreGerneteCorreo.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
          $linkRechazaG = '<a href="'.URL . "Pagos/PreRechazo.php?id=".$_POST['folio']."&nombreGerenteCorreo=".$nombreGerneteCorreo.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>' ;
  
      }else if(($estatus == "Aceptado")){

        $linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitudContabilidadTXT.php?id=".$_POST['folio']."&nombreContabilidadCorreo=".$nombreGerneteCorreo.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
        $linkRechazaG = '<a href="'.URL . "Pagos/PreRechazoContabilidad.php?id=".$_POST['folio']."&nombreContabilidadCorreo=".$nombreGerneteCorreo.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>' ;
        
      }else if(($estatus == "Aceptado Contabilidad")){
  
        $linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitudTesoreria.php?id=".$_POST['folio']."&nombreTesoCorreo=".$nombreGerneteCorreo.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
        $linkRechazaG = '<a href="'.URL . "Pagos/PreRechazoTesoreria.php?id=".$_POST['folio']."&nombreTesoCorreo=".$nombreGerneteCorreo.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>' ;
  
      }else if(($estatus == "Pago Programado")){
        $linkAutorizaG = "";
        $linkRechazaG = "";           
      }
      
    }else{

      if($estatus =="pendiente"){

        if($perfil == 2){
          
          $linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitud.php?id=".$_POST['folio']."&nombreGerenteCorreo=".$nombreGerneteCorreo.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
          $linkRechazaG = '<a href="'.URL . "Pagos/PreRechazo.php?id=".$_POST['folio']."&nombreGerenteCorreo=".$nombreGerneteCorreo.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>' ;
        }else{
          $linkAutorizaG = "";
          $linkRechazaG = "";
        }
  
        
  
      }else if(($estatus == "Aceptado")){
  
        if($perfil == 5){
        //$linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitudContabilidad.php?id=".$_POST['folio'].'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
        $linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitudContabilidadTXT.php?id=".$_POST['folio']."&nombreContabilidadCorreo=".$nombreGerneteCorreo.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
        $linkRechazaG = '<a href="'.URL . "Pagos/PreRechazoContabilidad.php?id=".$_POST['folio']."&nombreContabilidadCorreo=".$nombreGerneteCorreo.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>' ;
        }else{
          $linkAutorizaG = "";
          $linkRechazaG = "";
        }
   
        
      }else if(($estatus == "Aceptado Contabilidad")){
  
        if($perfil == 6){
          $linkAutorizaG = '<a href="'.URL . "Pagos/AceptarSolicitudTesoreria.php?id=".$_POST['folio']."&nombreTesoCorreo=".$nombreGerneteCorreo.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
          $linkRechazaG = '<a href="'.URL . "Pagos/PreRechazoTesoreria.php?id=".$_POST['folio']."&nombreTesoCorreo=".$nombreGerneteCorreo.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:100px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>' ;
  
        }else{
  
          $linkAutorizaG = "";
          $linkRechazaG = "";
        }      
  
      }else if(($estatus == "Pago Programado")){
  
          $linkAutorizaG = "";
          $linkRechazaG = "";           
  
      }

    }
 
   


  

    $html = '<style type="text/css">
        #detalleFolio {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
          font-size: 13px;
        }
        #detalleFolio td, #detalleFolio th {
          border: 1px solid #ddd;
          padding: 5px;
        }
        #detalleFolio td.a {
          padding-top: 5px;
          padding-bottom: 5px;
          text-align: left;
          background-color: ;
          color: #000000;
        }

        
        #detalleFolio th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #F7D358;
          color: #000000;
        }
      </style>
      <table id="detalleFolio">
        <tr>
          <td class="a"><strong>Folio:</strong></td><td><strong>'.$row['id'].'</strong></td>
          <td class="a"><strong>Empresa:</strong></td><td>Villa Tours</td>
        </tr>
        <tr>
          <td class="a"><strong>Número de proveedor:</strong></td><td><strong>'.$row['numproveedor'].'</strong></td>
          <td class="a"><strong>Beneficiario:</strong></td><td>'.$row['proveedor'].'</td>
        </tr>
        <tr>
            <td class="a"><strong>Centro de costo:</strong></td><td>'.$row['cecos'].'</td>
            <td class="a"><strong></strong></td><td></td>
        </tr>
        <tr>
          <td class="a"><strong>Importe:</strong></td><td>'.$moneda." ".number_format($row['monto'],2,'.',',').'</td>
          <td class="a"><strong>Tipo Cambio:</strong></td><td>'.number_format($row['tipocambio'],2,'.',',').'</td>
        </tr>
        <tr>
          <td class="a"><strong>Importe Pago:</strong></td><td>'.$monedaPago." ".number_format($row['conversionPago'],2,'.',',').'</td>
          <td class="a"><strong>Fecha Solicitud:</strong></td><td>'.$row['fechasolicitud'].'</td>
        </tr>
        <tr>
          <td class="a"><strong>Fecha límite:</strong></td><td>'.$row['fechalimite'].'</td>
          <td class="a"><strong>Solicitante:</strong></td><td>'.$row['nombre']." ".$row['apellidoPaterno'].'</td>
        </tr>
        <tr>
          <td class="a"><strong>Estatus:</strong></td><td>'.$estatus.'</td>
          <td class="a"><strong>Tipo Solicitud:</strong></td><td>'.$row['tipoSolicitud'].'</td>
        </tr>
        <tr>     
          <td class="a"><strong>Concepto:</strong></td><td>'.$row['concepto'].'</td>
          
          <td class="a"><strong>Facturas:</strong></td><td>'.$row['facturas'].'</td>
        </tr>
        <tr>
          <td class="a"><strong>Monto Letra:</strong></td><td>'.utf8_encode($row['montoletra']).'</td>
          <td class="a"><strong>Forma Pago:</strong></td><td>'.$row['formapago'].'</td>          
        </tr>
        <tr>
            <td class="a"><strong>Banco:</strong></td><td>'.utf8_encode($row['banco']).'</td>
            <td class="a"><strong>Cuenta:</strong></td><td>'.$row['cuentaBanco'].'</td>            
        </tr>
        <tr>            
            <td class="a"><strong>Clabe Interbancaria:</strong></td><td>'.$row['clabeinter'].'</td>
            <td class="a"><strong>Referencia:</strong></td><td>'.utf8_encode($row['referencia1']).'</td>
        </tr>
        <tr>
            <td class="a"><strong>Motivo Rechazo / Cancelación:</strong></td>
            <td colspan="3">'.$row['motivoRechazo'].'</td>
        </tr>
        <tr>
        <td colspan="4" class="a" style="align:center">';

        if(($estatus == "Rechazado") || ($estatus == "Rechazado Contabilidad") || ($estatus == "Rechazado Tesoreria") || ($estatus == "Pago Programado") || ($estatus == "pagado")){

          $html.= "";
    
        }else{

          $html.= $linkAutorizaG.$linkRechazaG;
        }

        
      $html.='</td></tr></table>';
      echo $html; 

      // <tr>
      //     <td class="a"><strong>Banco:</strong></td><td>'.$row['banco'].'</td>
      //     <td class="a"><strong>Cuenta:</strong></td><td>'.$row['cuentaBanco'].'</td>
      // </tr>
      // <tr>
      //     <td class="a"><strong>clabe Interbancaria:</strong></td><td>'.$row['clabeinter'].'</td>
      //     <td class="a"><strong>Referencia:</strong></td><td>'.$row['referencia1'].'</td>
      // </tr>
      // <tr>
      //     <td class="a"><strong>Aba:</strong></td><td>'.$row['aba'].'</td>
      //     <td class="a"><strong>Swift:</strong></td><td>'.$row['swift'].'</td>
      // </tr>

    //   if($registro == true && strtolower($estatus) == "pendiente"){ #Gerencia
    //     $html.='
    //       <a href="'.$linkAutorizaG.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>
    //       <a href="'.$linkRechazaG.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>
    //       ';
    //   }

    //   if($idUsuario == "241" && $estatus == "Aceptado" && $importancia == "Urgente"){ #Direccion de Finanzas
    //     $html.='<a href="'.$linkAutorizaDF.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>';
    //     if($importancia == "Urgente"){
    //       $html.='<a href="'.$linkFiltraDF.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-filter" aria-hidden="true"></i> Filtrar</a>';
    //     }
    //     $html.='<a href="'.$linkRechazaDF.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>';
    //   }
    //   if($idUsuario == "267" && $estatus == "Revision DG"){ #Direccion General
    //     $html.='
    //     <a href="'.$linkAutorizaDG.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>
    //     <a href="'.$linkRechazaDG.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>
    //     ';
    //   }
    //   if($idUsuario == "254" || $idUsuario == "259" || $idUsuario == "264" || $idUsuario == "225"){ #CXP
    //     if($estatus == "aceptada" || $estatus == "Aceptado" || $estatus == "Aceptado DF" || $estatus == "Aceptado DG"){
    //       $html.='
    //       <a href="'.$linkAutorizaCXP.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Aceptar</a>
    //       <a href="'.$linkRechazaCXP.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar</a>
    //       ';
    //     }
    //   }
    // if($idUsuario == "225" || $idUsuario == "254" || $idUsuario == "241"){
    //   if($estatus != "Pago Programado"){
    //     $html.='<a href="#" onclick="modalCancelaSolicitud('.$row['id'].');" style="background-color:#CB4335;border:1px solid #CB4335;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Cancelar Solicitud</a>';  
    //   }
    // }
    // if($idUsuario == "225" || $idUsuario == "254" || $idUsuario == "241"){
    //   if($estatus == "Pago Programado"){
    //     $html.='<a href="'.$linkRechazaCXP.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;line-height:30px;text-align:center;text-decoration:none;width:150px;" target="_blank"><i class="fa fa-reply" aria-hidden="true"></i> Rechazar CXP</a>';
    //   }
    // }
?>