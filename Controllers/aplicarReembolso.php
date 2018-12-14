<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
$solicitud = new Solicitud();
#parametros requeridos

$idUsuario = $_SESSION['_pid'];
$usuario = $_SESSION['_pnamefull'];

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
} else {

    $folio = $_POST["_folio"];
    $motivo = $_POST["motivo"];

}
#Recepcion de datos $_POST

$solicitud->set('id', $folio);
$solicitud->set('estatus', "reembolso");
$solicitud->set('motivo', utf8_decode($motivo));

$answer1 = $solicitud->registraReembolso();

if ($answer1) {

    $answer2  = $solicitud->buscarSolicitud();

    while($row = mysqli_fetch_array($answer2)){
        
        $proveedor = $row['proveedor'];
        $cecos = $row["cecos"];
        $localizador = $row["localizador"];
        $concepto = $row["concepto"];
        $monto = $row["monto"];
        $moneda = $row["moneda"];
        $tipocambio = $row["tipocambio"];
        $formapago=$row["formapago"];
        $montoletra = $row["montoletra"];

    }

    #envio de correo
    $html = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Solicitud de pago</title>
    </head>
    <body>
        <center>
            <table width="100%" style=" font-family: Arial, Helvetica, sans-serif; ">
            <tr>
            </tr>
            <tr >
                <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
                    <font color="#FAFAFA" size="4px">
                        DATOS REEMBOLSO
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
                Por medio del presente corrreo, se le notifica que se registro un reembolso de pago con la siguiente información
            </p>	
            <table width="100%" border="0" style="font-family: Arial, Helvetica, sans-serif; ">
            <tr>
                <td width="30%" ><font color="#003366"><strong> Solicitante: <strong></font></td>
                <td width="70%" ><strong> '.$usuario.' <strong></td>
            </tr>
            <tr>
                <td width="30%" ><font color="#003366"><strong> Folio Solicitud: <strong></font></td>
                <td width="70%" ><strong> '.$folio.' <strong></td>
            </tr>
            <tr><td><br> </td><td><br> </td></tr>
            <tr>
                <td class=""><font color="#003366">Localizador:</font></td>
                <td class="">'.$localizador.'</td>
            </tr>

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
                <td class="">$ '.number_format($monto,2,'.',',').'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366">Monto en letra:</font></td>
                <td class="">'.$montoletra.'</td>
            </tr>
            <tr>  
                <td class=""><font color="#003366"><strong> Motivo de Reembolso: </strong></font></td>
                <td class=""><strong>'.$motivo.'</strong></td>
            </tr>
            <tr>
                <td><br> </td>
                <td><br> </td>
            </tr>
            </table>
        </font>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" style="height: 10px;padding-top:20px;padding-bottom:20px; font-size: 12px;" VALIGN="bottom">
        <!--<br>-->
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
    $asunto = "Reembolso | Folio: ".$folio." | Solicitante: ".$usuario.".";
    require_once('../lib/swiftmailer/swift_required.php');
    $receptor = 'ebecerril@aiko.com.mx';
    $nombre = "Eduardo";
    try {
    $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
            ->setUsername('soporte@aiko.com.mx')
            ->setPassword('soporte**17');
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($asunto)
    ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
    ->setTo(array($receptor =>$nombre))
    // ->setCc('soporte@aiko.com.mx','dgalicia@juliatours.com.mx')
    //->setCc(array('soporte@aiko.com.mx', 'facturacion-notacredito@juliatours.com.mx', 'cuentasporpagar@juliatours.com.mx','dgalicia@juliatours.com.mx'))
        ->setBody($html, 'text/html'); //body html
        if ($mailer->send($message)){
            echo 1;
        }else{
            echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
        }
    } catch (Exception $e) {
    //echo 'Excepcion',  $e->getMessage(), "\n";
    }
} else {
    echo "0";
}
?>