<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="" type="image/vnd.microsoft.icon" />
    <title>Villa Tours | Pagos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <script src="../js/jquery-3.1.1.js"></script>
    
    <script type="text/javascript" src="../js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <style>
    .titulo{
            color: #F2F2F2;
            padding: 15px;
        }
    </style>
</head>

<?php

#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo usuario
include_once str_replace(DS, "/", ROOT . 'Controllers/log.php'); #Log de actividad
$solicitud = new Solicitud();
$usuarioOBJ = new Usuario();
#parametros requeridos


$usuarioS = @$_GET['nombreGerenteCorreo'];

$idSolicitud = $_GET["id"];
$solicitud->set('id', $idSolicitud);
$answer  = $solicitud->buscarSolicitud();

$row = mysqli_fetch_array($answer);
    #validacion estatus salir si ya se autorizo por el nivel actual
    $estatus = $row["estatus"];
    if($estatus == "Aceptado" || $estatus == 'Rechazado' || $estatus == 'Aceptado Contabilidad' || $estatus == 'Rechazado Contabilidad' || $estatus == 'Pago Programado' || $estatus == 'Rechazado Tesoreria'){
        echo '<body>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                        <h5 style="float:left">Solicitudes / Pagos / Autorización / Gerencia</h5>
                        <div class="col-md-3" style="text-align: right;float:right;">
                        </div>
                    </div>
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <h4><i class="fa fa-hand-paper-o" aria-hidden="true"></i> La solicitud de pago con el Folio: <strong>'.$idSolicitud.', </strong> Ya se encuentra en estatus '.$estatus.' </h4>
                                <br><br>
                                <small class="form-text text-muted">Revisar el listado de solicitudes para conocer el estatus de la solicitud.</small>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </body>
    </html>';
    exit;
    }
    #validacion estatus salir si ya se autorizo por el nivel actual

    $fecha = $row["fechasolicitud"];
    $usuario = $row["nombre"]." ".$row["apellidoPaterno"];
    $proveedor = $row['proveedor'];
    $cecos = $row["cecos"];
    $localizador = $row["localizador"];

    $tipoSolicitud = $row["tipoSolicitud"];
    

    $concepto = $row["concepto"];
    $monto = $row["monto"];
    $moneda = $row["moneda"];
    $tipocambio = $row["tipocambio"];

    $monedaPago = $row["monedaPago"];
    $conversionPago = $row["conversionPago"];

    $formapago=$row["formapago"];
    $montoletra = $row["montoletra"];
    $fechalimite = $row["fechalimite"];
    $facturas = $row["facturas"];
    $importancia = $row["importancia"];
    $motivoUrgente = $row["motivoUrgente"];

    #Datos Bancarios Nacional
    $banco = $row["banco"];
    $cuentaBanco = $row["cuentaBanco"]; 
    $referencia1 = $row["referencia1"];
    $clabeinter = $row["clabeinter"];   
    
    #Datos Bancarios Extrangero
    $aba   = $row["aba"];
    $swift = $row["swift"];

    


    


    ############## CORREO y nombre para notificar a  CONTABILIDAD ###############
    $usuarioOBJ->usuarioContabilidad();
    $receptor = $usuarioOBJ->get('correoContabilidad');
    $nombre = utf8_encode($usuarioOBJ->get('nombre'))." ".utf8_encode($usuarioOBJ->get('app'))." ".utf8_encode($usuarioOBJ->get('apm'));

    $asunto = "Aceptación Pago | Gerencia | Folio: ".$idSolicitud." | Solicitante: ".$usuario.".";
    
        //$receptor = 'dgutierrez@aiko.com.mx';
        //$nombre = "Diego";
    ######################################

    ########################################### Nombre Gerente que aceptará la solicitud !!!!! ####################
    $nombreContaCorreo    =  utf8_encode($usuarioOBJ->get('nombre'))." ".utf8_encode($usuarioOBJ->get('app'))." ".utf8_encode($usuarioOBJ->get('apm'));

    if($importancia == "si"){

    }else{
        $linkAutoriza = URL . "Pagos/AceptarSolicitudContabilidadTXT.php?id=".$idSolicitud."&nombreContabilidadCorreo=".$nombreContaCorreo;
        $linkRechaza =  URL . "Pagos/PreRechazoContabilidad.php?id=".$idSolicitud."&nombreContabilidadCorreo=".$nombreContaCorreo;
        $tipoRechazo = "Rechazar";

        $encript= base64_encode($idSolicitud);
        $linkDescarga = URL . "Pagos/descargaFacturas.php?id=".$encript;
    }

    $html = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>
        <center>
            <table width="100%" style=" font-family: Arial, Helvetica, sans-serif; ">
            <tr>
            </tr>
            <tr >
                <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
                    <font color="#FAFAFA" size="4px">
                        ACEPTACIÓN SOLICITUD DE PAGO
                    </font>
                </td>
            </tr>
            </table>
            <table width="100%" style="font-family: Arial, Helvetica, sans-serif; ">
            <tr>
                <td colspan="2" style="height: 10px; color:#575756; font-size: 13px;">
                </td>
            </tr>
            <tr>
        <td style="height: 20px; font-size: 16px;">
        <font color="#003366">
            <p align="justify">
            Estimado(a),
            </p>	
            <p>
                Por medio del presente correo, se le notifica que se ha aceptado una solicitud de pago con la siguiente información

            </p>	
            <table width="100%" border="0" style="font-family: Arial, Helvetica, sans-serif; ">
                <!--align="center"-->
            <tr>
                <td width="30%" ><font color="#003366"><strong> Fecha de Solicitud: <strong></font></td>
                <td width="70%" ><strong> '.$fecha.' <strong></td>
            </tr>
            <tr>
                <td width="30%" ><font color="#003366"><strong> Solicitante: <strong></font></td>
                <td width="70%" ><strong> '.$usuario.' <strong></td>
            </tr>
            <tr>
                <td width="30%" ><font color="#003366"><strong> Tipo de Solicitud: <strong></font></td>
                <td width="70%" ><strong> '.$tipoSolicitud.' <strong></td>
            </tr>
            <tr>
                <td width="30%" ><font color="#003366"><strong> Folio Solicitud: <strong></font></td>
                <td width="70%" ><strong> '.$idSolicitud.' <strong></td>
            </tr>
            <tr><td><br> </td><td><br> </td></tr>

            <!--<tr>  
                <td class=""><font color="#003366">Localizador:</font></td>
                <td class="">'.$localizador.'</td>
            </tr>-->

            <tr>  
                <td class=""><font color="#003366">Proveedor:</font></td>
                <td class="">'.$proveedor.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Centros de costos:</font></td>
                <td class="">[ '.$cecos.' ]</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Concepto de pago:</font></td>
                <td class="">'.$concepto.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Monto de pago:</font></td>
                <td class="">$ '.number_format((float)$monto,2,'.',',').'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Tipo de cambio:</font></td>
                <td class="">$ '.number_format((float)$tipocambio,2,'.',',').'</td>
            </tr>
            <tr>
                <td class=""><font color="#003366">Monto en letra:</font></td>
                <td class="">'.$montoletra.'</td>
            </tr>
            <tr>
                <td colspan="2"><font color="#003366"><br> <strong> Información Pago: </strong></font></td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Proveedor:</font></td>
                <td class="">'.$proveedor.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Moneda para pago:</font></td>
                <td class="">'.$monedaPago.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Monto para pago:</font></td>
                <td class="">$ '.number_format((float)$conversionPago,2,'.',',').'</td>
            </tr>
            <tr>
                <td class=""><font color="#003366">Factura(s):</font></td>
                <td class="">'.$facturas.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Fecha limite de pago:</font></td>
                <td class="">'.$fechalimite.'</td>
            </tr>';
            if(trim($importancia) != ""){
                $html.='<tr>  
                <td class=""><font color="#003366"><strong> Motivo Urgente: </strong></font></td>
                <td class=""><strong>'.$motivoUrgente.'</strong></td>
                </tr>';
            }
            $html.='<tr>
                <td colspan="2"><font color="#003366"><br> <strong> Datos Bancarios: </strong></font></td>
            </tr>
            <tr>
                <td colspan="2"><font color="#003366"><hr></font></td>
            </tr>'; 

            ## Validaciones para comprobar los campos que se registraron en la creaciond e la solicitud ##

            if ($banco!="") {

                $html.='
                <tr>  
                    <td class=""><font color="#003366">Banco:</font></td>
                    <td class="">'.$banco.'</td>
                </tr>';
            }


            if ($cuentaBanco!="") {
                $html.='<tr>  
                    <td class=""><font color="#003366">Cuenta:</font></td>
                    <td class="">'.$cuentaBanco.'</td>
                </tr>';
            }

            if ($referencia1!="") {

                $html.='<tr>  
                    <td class=""><font color="#003366">Referencia:</font></td>
                    <td class="">'.$referencia1.'</td>
                </tr>';
            }

            if ($clabeinter!="") {

                $html.='<tr>  
                    <td class=""><font color="#003366">Clabe Interbancaria:</font></td>
                    <td class="">'.$clabeinter.'</td>
                </tr>';
            }

            ## *********************************************************************************** ##


            if($aba!=""){
                $html.='
                <tr>  
                    <td colspan="2"><font color="#003366"><br> <strong> Extrangeros: </strong></font></td>
                </tr>
                <tr>
                    <td colspan="2"><font color="#003366"><hr></font></td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">ABA:</font></td>
                    <td class="">'.$aba.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">SWIFT:</font></td>
                    <td class="">'.$swift.'</td>
                </tr>';
            }
            $html.='
            <tr>
                <td><br> </td>
                <td><br> </td>
            </tr>
            <tr>
                <td colspan="2"><a href="'.$linkDescarga.'" style="font-family:sans-serif;font-size:14px;text-decoration:none;"><u>Descargar Facturas</u></a></td>
            </tr>
            <tr>
                <td align="right">
                <a href="'.$linkAutoriza.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;">Aceptar</a>&nbsp;&nbsp;&nbsp;';
                $html.='<a href="'.$linkRechaza.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;">Rechazar</a>';
                if($importancia == "si"){
                $html.='</td>
                <td align="center"><a href="'.$linkFiltra.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;">'.$tipoRechazo.'</a></td>';
                }
            $html.='</tr>
            <tr>
                <td><br> </td>
                <td><br> </td>
            </tr>
            </table>
        </font>
        </td>
    </tr>
    <tr>
        <td align="center" style="height: 20px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" colspan="3" bgcolor="#E6E6E6">
        <span style="color:#575756; font-size: 12px;">Este mensaje fue generado por un sistema automatizado, usando una direccion de correo de notificaciones. Por favor, no responder a este mensaje.</span>
        </td>
    </tr>
    </table>
    </center>
    </body>
    </html>
    ';



    #############################################################################
    
    ##verificar si existe carpeta de facturas  por solicitud
    $rutaCarpte = "Facturas/".$idSolicitud;

    if(!file_exists($rutaCarpte)){
        mkdir($rutaCarpte,0700);
    }



    ##Eliminar zip existente 
    $nombreZip =   "Facturas Solicitud No_ ".$idSolicitud.".zip";
    $rutaZip = "Facturas/".$idSolicitud."/".$nombreZip;
    if(file_exists("Facturas/".$idSolicitud."/".$nombreZip)) {
        unlink ("Facturas/".$idSolicitud."/".$nombreZip); 
    }

    ##verificar si existen archivos en las carpetas##

    $dirFcaturas = "Facturas/".$idSolicitud."/";
    $gestor_dir = opendir($dirFcaturas);

    $posicion = 0; 
    $ficheros = array();
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {

        if($nombre_fichero == "." || $nombre_fichero == ".." ){
            #nada
        }else{
            $ficheros[$posicion] = $nombre_fichero;
            $posicion ++;
        }
        
    }



    #################################################



        ##enviar correo CON adjunto si el array tiene nombres de archivos
        if(count($ficheros) > 0){

            $zip = new ZipArchive();
            if ($zip->open("Facturas/".$idSolicitud."/".$nombreZip, ZIPARCHIVE::CREATE) != TRUE) {
                    //die ("Could not open archive");
            }else{

                foreach ($ficheros as &$documento) {
                    $zip->addFile("Facturas/".$idSolicitud."/".$documento, $documento);
                }
    
                $zip->close();
            }
           
            $envio = correoZIP($asunto,$receptor,$nombre,$html,$nombreZip,$rutaZip);

        }else{
            ##enviar correo SIN adjunto 
            $envio = correo($asunto,$receptor,$nombre,$html);
        }

        if($envio == true){
            $solicitud->set('estatus', "Aceptado");
            $res = $solicitud->actualizaEstatus();
            if($res){
                logs($idSolicitud,$usuarioS,'Solicitud Aceptada');
    
            }
        }
        
    #################################################


?>
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-block titulo bg-primary">
                    <h5 style="float:left">Solicitudes / Pagos / Autorización / Gerencia</h5>
                    <div class="col-md-3" style="text-align: right;float:right;">
                    </div>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block">
                    <div class="row">
                        <div class='col-md-12'>
                            <?php if($envio == true){ ?>
                            <h4><i class="fa fa-check-circle-o fa-1x" aria-hidden="true"></i> La solicitud de pago con el <strong>Folio: <?= $idSolicitud; ?> </strong> se ha aceptado con éxito!!</h4>
                            <br><br>
                            <small class="form-text text-muted">La notificación para instrucción de pago fue enviado al área de Contabilidad.</small>
                            <?php }else{ ?>
                            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error al intentar aceptar la solicitud de pago. Favor de intentarlo mas tarde.</h4>
                            <br><br>
                            <small class="form-text text-muted">Si el problema persiste favor de comunicarse con su administrador.</small>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html>

<?php
    function correo($asunto,$receptor,$nombre,$html){
        require_once('../lib/swiftmailer/swift_required.php');
        $envio = false;
        
        try {
        $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
                ->setUsername('soporte@aiko.com.mx')
                ->setPassword('s0p0rt3**18');
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
            ->setTo(array($receptor =>$nombre))
            ->setCc(array('soporte@aiko.com.mx' =>'control'))
            ->setBody($html, 'text/html'); //body html
            if ($mailer->send($message)){
                $envio = true;
            }else{
                //echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
                $envio = false;
            }
        } catch (Exception $e) {
            $envio = false;
        //echo 'Excepcion',  $e->getMessage(), "\n";
        }

        return $envio;

    }

    function correoZIP($asunto,$receptor,$nombre,$html,$nombreZip,$rutaZip){
        require_once('../lib/swiftmailer/swift_required.php');
        $envio = false;
        
        try {
        $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
                ->setUsername('soporte@aiko.com.mx')
                ->setPassword('s0p0rt3**18');
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
            ->setTo(array($receptor =>$nombre))
            ->setCc(array('soporte@aiko.com.mx' =>'control'))
            ->setBody($html, 'text/html') //body html
            ->attach(Swift_Attachment::fromPath($rutaZip)->setFilename($nombreZip));
            if ($mailer->send($message)){
                $envio = true;
            }else{
                //echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
                $envio = false;
            }
        } catch (Exception $e) {
            $envio = false;
        //echo 'Excepcion',  $e->getMessage(), "\n";
        }

        return $envio;
    }
?>