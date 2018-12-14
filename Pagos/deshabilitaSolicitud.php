<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
$solicitud = new Solicitud();
#parametros requeridos

$idSolicitud = @$_POST["_folioca"];
$motivo = @$_POST["motivoc"];

$solicitud->set('id', $idSolicitud);
$answer  = $solicitud->buscarSolicitud();

while($row = mysqli_fetch_array($answer)){
    $estatus = $row["estatus"];
    $fecha = $row["fechasolicitud"];
    $usuario = $row["nombre"]." ".$row["apellidoPaterno"];
    $correo = $row["correo"];
    $proveedor = $row['proveedor'];
    $cecos = $row["cecos"];
    $localizador = $row["localizador"];

    $tipoSolicitud = $row["tipoSolicitud"];

    $concepto = $row["concepto"];
    $monto = $row["monto"];
    $moneda = $row["moneda"];
    $tipocambio = $row["tipocambio"];
    $formapago=$row["formapago"];
    $montoletra = $row["montoletra"];
    $fechalimite = $row["fechalimite"];
    $facturas = $row["facturas"];
    $importancia = $row["importancia"];

    $monedaPago = $row["monedaPago"];
    $conversionPago = $row["conversionPago"];
    
    #Datos Bancarios Nacional
    $banco = $row["banco"];
    $cuentaBanco = $row["cuentaBanco"];
    $referencia = $row["referencia1"];
    $clabeinter = $row["clabeinter"];
    
    #Datos Bancarios Extrangero
    $aba   = $row["aba"];
    $swift = $row["swift"];

    #Envio de notificacion aceptacion solicitud de pago
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
                        CANCELACIÓN SOLICITUD DE PAGO
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
        <td style="height: 20px; font-size: 14px;">
        <font color="#003366">
            <p align="justify">
            Estimado(a),
            </p>	
            <p>
                Por medio del presente correo, se le notifica que se ha cancelado la solicitud de pago con la siguiente información
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

            <tr>  
                <td class=""><font color="#003366">Localizador:</font></td>
                <td class="">'.$localizador.'</td>
            </tr>

            <tr>  
                <td class=""><font color="#003366">Beneficiario:</font></td>
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
                <td class="">$ '.number_format($monto,2,'.',',').'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Tipo de cambio:</font></td>
                <td class="">$ '.number_format($tipocambio,2,'.',',').'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Monto en letra:</font></td>
                <td class="">'.$montoletra.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Factura(s):</font></td>
                <td class="">'.$facturas.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Fecha limite de pago:</font></td>
                <td class="">'.$fechalimite.'</td>
            </tr>
            <tr>
                <td colspan="2"><font color="#003366"><hr></font></td>
            </tr>'; 
            $html.='
            <tr>
                <td><br> </td>
                <td><br> </td>
            </tr>
            <tr>
            <td class=""><font color="#003366"><strong>Motivo Cancelación:</strong></font></td>
            <td class=""><strong>'.$motivo.'</strong></td>
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
    // <td><a href="" style="text-decoration: none;padding: 10px;font-weight: 200;font-size: 15px;color: #ffffff;background-color: #d9534f;border-radius: 20px;border: 2px solid #d9544fad;box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);">Rechazar solicitud</a></td>
    require_once('../lib/swiftmailer/swift_required.php');
    $envio = false;
    $asunto = "Solicitud cancelada | Folio: ".$idSolicitud." | Solicitante: ".$usuario.".";

    // $receptor = $correo;#'ebecerril@aiko.com.mx';
    // $nombre = $usuario;#"Eduardo";

    // $receptor = 'ebecerril@aiko.com.mx';
    // $nombre = "Eduardo";

    $receptor = 'dgutierrez@aiko.com.mx';
    $nombre = "Diego";

    try {
    $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
            ->setUsername('soporte@aiko.com.mx')
            ->setPassword('soporte**17');
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($asunto)
    ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
    ->setTo(array($receptor =>$nombre))
    ->setCc(array('soporte@aiko.com.mx' =>'control'))
        ->setBody($html, 'text/html'); //body html
        if ($mailer->send($message)){
            $envio = true;
        }else{
            echo 'Error: Ocurrio un problema al enviar el correo de cancelacion';
        }
    } catch (Exception $e) {
    //echo 'Excepcion',  $e->getMessage(), "\n";
    }
    if($envio == true){
        $solicitud->set('estatus', "Cancelado");
        $solicitud->set('motivo', $motivo);
        $solicitud->rechazarSolicitud();
        echo 1;
    }
}
?>