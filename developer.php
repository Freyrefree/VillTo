<?php
// $datoBeneficiario = "ajshghas|asd asd |asdasdhgasjdgasd";
// $beneficiario = explode("|", $datoBeneficiario);

// echo count($beneficiario);
// if(count($beneficiario) >= 3){
//     $idproveedor = $beneficiario[0]; #id de proveedor [beneficiario]
//     $numproveedor = $beneficiario[1]; #numero de proveedor [beneficiario]
//     $proveedor = $beneficiario[2]; #nombre de proveedor [beneficiario]
// }

#parametros requeridos
include_once 'app/config.php'; #Configuracion
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
            Por medio del presente corrreo, se le notifica que se ha aceptado una solicitud de pago con la siguiente información

        </p>	
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
$asunto = "Envio cuestionario";

$nombre = "Eduardo Becerril";
$receptor = 'ebecerril@aiko.com.mx';

require_once('lib/swiftmailer/swift_required.php');

try {
$transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
    ->setUsername('soporte@aiko.com.mx')
    ->setPassword('soporte**17');
$mailer = Swift_Mailer::newInstance($transport);
$message = Swift_Message::newInstance($asunto)
->setFrom(array('soporte@aiko.com.mx' => 'Envio cuestionario'))
    ->setTo(array($receptor =>$nombre))
    ->setCc(array('soporte@aiko.com.mx' =>'control'))
    ->setBody($html, 'text/html');
    if ($mailer->send($message)){
        echo "1";
    }else{
        echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
    }
} catch (Exception $e) {
    echo 'Excepcion',  $e->getMessage(), "\n";
}

?>