<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/cuenta.php'); #Modelo Cuenta
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo Cuenta
include_once str_replace(DS, "/", ROOT . 'Controllers/log.php'); #Log de actividad
$cuenta = new Cuenta();
$usuarioOBJ = new Usuario();
#parametros requeridos
$usuario = $_SESSION['_pnamefull'];

#Recepcion de datos $_POST
if (!$_POST) {

    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;

}else{


    $envioCorreo = $_POST['envioCorreo'];
    $id_proveedor = $_POST['idproveedor'];
    $banco = $_POST['nombreBanco'];
    $num_cuenta = $_POST['numCuenta'];    
    $clabeInter = $_POST['clabeInter'];

    $claveSAT = $_POST['claveSAT'];
    $codigoSantander = $_POST['codigoSantander'];
    $divisa = $_POST['divisa'];
}
#Recepcion de datos $_POST

//************ Cuerpo Correo **************
$html='
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Registro Proveedor</title>
        </head>
        <body>
            <center>
                <table width="95%" style=" font-family: Arial, Helvetica, sans-serif; ">
                <tr>
                    
                </tr>
                <tr >
                    <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
                        <font color="#FAFAFA" size="4px">
                            NUEVA CUENTA
                        </font>
                    </td>
                </tr>
                </table>
                <table width="95%" style="font-family: Arial, Helvetica, sans-serif; ">
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
                    Por medio del presente correo, se le notifica que <strong>'.$_SESSION['_pnamefull'].'</strong> realizo un nuevo registro de Cuenta:
                </p>
                <table width="95%" border="0" style="font-family: Arial, Helvetica, sans-serif; ">
                    <!--align="center"-->
                <tr>
                    <td width="30%" ><font color="#003366">Cuenta Asignada al Proveedor No: </font></td>
                    <td width="70%" >'.$id_proveedor.'</td>
                </tr>
                <tr>
                    <td class=""><font color="#003366">Banco:</font></td>
                    <td class="">'.$banco.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Codigo Santander:</font></td>
                    <td class="">'.$codigoSantander.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Clave SAT:</font></td>
                    <td class="">'.$claveSAT.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Número Cuenta:</font></td>
                    <td class="">'.$num_cuenta.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Clave Interbancaria:</font></td>
                    <td class="">'.$clabeInter.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Divisa:</font></td>
                    <td class="">'.$divisa.'</td>
                </tr>        
                <tr><td colspan="2"><hr></td></tr>
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
//*****************************************


    $cuenta->set('id_proveedor', utf8_decode($id_proveedor));
    $cuenta->set('num_cuenta', utf8_decode($num_cuenta));
    $cuenta->set('banco', utf8_decode($banco));
    $cuenta->set('clabeInterbancaria', utf8_decode($clabeInter));

    $cuenta->set('claveSAT', utf8_decode($claveSAT));
    $cuenta->set('codigoSantander', utf8_decode($codigoSantander));
    $cuenta->set('divisa', utf8_decode($divisa));

    $cuenta->set('sucursal','');


    $answer = $cuenta->registraCuenta();
    if($answer){


    
        if($envioCorreo == "si"){
            //logs("Cuenta Nueva ".$num_cuenta,$usuario,'Nueva Cuenta');

            #Correo del usuario del area de contabilidad
            $usuarioOBJ->usuarioContabilidad();
            $receptor = $usuarioOBJ->get('correoContabilidad');
            $nombre = utf8_encode($usuarioOBJ->get('nombre'))." ".utf8_encode($usuarioOBJ->get('app'))." ".utf8_encode($usuarioOBJ->get('apm'));
            #**************************************************

            $asunto = "Nueva Cuenta | Usuario: ".$_SESSION['_pnamefull'].".";

            //$receptor = 'dgutierrez@aiko.com.mx';
            //$nombre = "Diego";

           $mailcc = "soporte@aiko.com.mx";
           $namecc = 'Control';

           $resCorreo = correo($asunto,$receptor,$nombre,$html,$mailcc,$namecc);
           if($resCorreo != true){
               echo "2"; //Se agregó solicitud pero no se envió correo
           }else{
               echo "1";
           }

        }else{

            echo "1";
        }

        
    }else{
        echo "0";
    }


function correo($asunto,$receptor,$nombre,$html,$mailcc,$namecc){
    require_once('../lib/swiftmailer/swift_required.php');
    $retorno = true;

    try {
            $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
                    ->setUsername('soporte@aiko.com.mx')
                    ->setPassword('s0p0rt3**18');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
            ->setTo(array($receptor =>$nombre))
            ->setCc(array($mailcc =>$namecc))
            ->setBody($html, 'text/html'); //body html
            if ($mailer->send($message)){
                //echo 1;
                $retorno = true;
            }else{
                $retorno = false;
                //echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
            }
        } catch (Exception $e) {
        //echo 'Excepcion',  $e->getMessage(), "\n";
        $retorno = false;
        }

    return $retorno;
}



?>