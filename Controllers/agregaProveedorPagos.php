<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo Proveedor
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo Cuenta
include_once str_replace(DS, "/", ROOT . 'Controllers/log.php'); #Log de actividad
$proveedor = new Proveedor();
$usuarioOBJ = new Usuario();
#parametros requeridos
$usuarioS = $_SESSION['_pnamefull'];

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
}else{
    $numproveedor = trim($_POST['numproveedor']);
    if($numproveedor == ""){
        $answer1 = true;
    }else{
        $proveedor->set('numproveedor', utf8_decode($numproveedor));
        $answer1 = $proveedor->verificaProveedor();
    }
    if ($answer1 != false) 
    {
            $rfc = $_POST['rfc'];
            $razonsocial = $_POST['razonsocial'];
            $direccion = $_POST['direccion'];
            $cp = $_POST['cp'];
            $aliascomercial = $_POST['aliascomercial'];
            $email = $_POST['email'];
            $contacto = $_POST['contacto'];
            $tel1 = $_POST['tel1'];
            $tel2 = $_POST['tel2'];
            $comunidad = $_POST['comunidad'];
            $pais = $_POST['pais'];
            //$tipo = $_POST['tipopro'];
            //$filecaratulaname = $_FILES['filecaratula']['name'];
            //$filecedulaname = $_FILEST['filecedula']['name'];
        
            $aba = @$_POST['aba'];
            $swift = @$_POST['swift'];

            $activo = 're';

            if($comunidad == 1){$nacionalidad = "Nacional";}else{$nacionalidad = "Extranjero";}

            #Correo del usuario del area de contabilidad
            $usuarioOBJ->usuarioContabilidad();
            $receptor = $usuarioOBJ->get('correoContabilidad');
            $nombre = utf8_encode($usuarioOBJ->get('nombre'))." ".utf8_encode($usuarioOBJ->get('app'))." ".utf8_encode($usuarioOBJ->get('apm'));
            
            //$receptor = 'dgutierrez@aiko.com.mx';
            //$nombre = "Diego";
            
            #**************************************************

            $asunto = "Nuevo Proveedor | Usuario: ".$_SESSION['_pnamefull'].".";




            $mailcc = "soporte@aiko.com.mx";
            $namecc = 'Control';
        
        #Recepcion de datos $_POST
        //************************Archivos PDF**********************************/
        //. URL . 'Administracion/proveedores.php'


        $nombreCaratula=basename($_FILES["filecaratula"]["name"]);
        $sizeCaratula=$_FILES["filecaratula"]["size"];
        $tmpCaratula = $_FILES["filecaratula"]["tmp_name"];

        $nombreCedula=basename($_FILES["filecedula"]["name"]);
        $sizeCedula=$_FILES["filecedula"]["size"];
        $tmpCedula = $_FILES["filecedula"]["tmp_name"];



        //************************Archivos PDF**********************************/

        $proveedor->set('numproveedor', utf8_decode($numproveedor));
        $proveedor->set('tipo', '');
        $proveedor->set('rfc', utf8_decode($rfc));
        $proveedor->set('razonsocial', utf8_decode($razonsocial));
        $proveedor->set('direccion', utf8_decode($direccion));
        $proveedor->set('cp', utf8_decode($cp));
        $proveedor->set('aliascomercial', utf8_decode($aliascomercial));
        $proveedor->set('email', utf8_decode($email));
        $proveedor->set('contacto', utf8_decode($contacto));
        $proveedor->set('tel1', utf8_decode($tel1));
        $proveedor->set('tel2', utf8_decode($tel2));
        $proveedor->set('comunidad', $comunidad);
        $proveedor->set('pais', utf8_decode($pais));
        $proveedor->set('aba', utf8_decode($aba));
        $proveedor->set('swift', utf8_decode($swift));
        $proveedor->set('activo', utf8_decode($activo));


        $answer = $proveedor->registraProveedor();

        $proveedor->set('id',$answer);
        $proveedor->consultaProveedor();
        $nombreProveedor = utf8_encode($proveedor->get('razonsocial'));



        ###############Cuerpo Correo##########
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
                    <!--<td align="left" ><img src="https://www.bcdtravelmexico.com.mx/img/logo.gif" border=0  width="150px" /></td>-->
                </tr>
                <tr >
                    <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
                        <font color="#FAFAFA" size="4px">
                            NUEVO PROVEEDOR
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
                    Por medio del presente correo, se le notifica que <strong>'.$_SESSION['_pnamefull'].'</strong> realizo un nuevo registro de proveedor:
                </p>
                <table width="95%" border="0" style="font-family: Arial, Helvetica, sans-serif; ">
                    <!--align="center"-->
                <tr>
                    <td width="30%" ><font color="#003366">No Proveedor: </font></td>
                    <td width="70%" >'.$answer.'</td>
                </tr>
                <tr>
                    <td width="30%" ><font color="#003366">Nombre Proveedor: </font></td>
                    <td width="70%" >'.$nombreProveedor.'</td>
                </tr>
                <!--<tr>
                    <td width="30%" ><font color="#003366">Tipo Proveedor: </font></td>
                    <td width="70%" ></td>
                </tr>-->
                <tr>
                    <td class=""><font color="#003366">RFC | Tax ID:</font></td>
                    <td class="">'.$rfc.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Razon Social:</font></td>
                    <td class="">'.$razonsocial.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Alias Comercial:</font></td>
                    <td class="">'.$aliascomercial.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Dirección:</font></td>
                    <td class="">'.$direccion.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">C.P.:</font></td>
                    <td class="">'.$cp.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Correo:</font></td>
                    <td class="">'.$email.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Contacto:</font></td>
                    <td class="">'.$contacto.'</td>
                </tr>
                <tr>  
                    <td class=""><font color="#003366">Telefono 1:</font></td>
                    <td class="">'.$tel1.'</td>
                </tr>
                <tr>
                    <td class=""><font color="#003366">Telefono 2:</font></td>
                    <td class="">'.$tel2.'</td>
                </tr>
                <tr>
                    <td class=""><font color="#003366">Nacionalidad:</font></td>
                    <td class="">'.$nacionalidad.'</td>
                </tr>
                <tr>
                    <td class=""><font color="#003366">Pais:</font></td>
                    <td class="">'.$pais.'</td>
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

        ######################################

        if ($answer != 0) {
            correo($asunto, $receptor, $nombre, $html,$mailcc,$namecc);
            $directorio = str_replace(DS, "/", ROOT . 'Administracion/docs/'.$answer.'/');
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            if($nombreCaratula == ""){
                $respuestaCartula = 1;

            }else{
                $respuestaCartula=uploadPDF($nombreCaratula, $sizeCaratula, $tmpCaratula, $directorio);
            }

            if($nombreCedula == ""){
                $respuestaCedula = 1;

            }else{
                $respuestaCedula=uploadPDF($nombreCedula, $sizeCedula, $tmpCedula, $directorio);
            }
            

            

            if ($respuestaCartula == 1 && $respuestaCedula == 1) {
                $filecaratula = $nombreCaratula;
                $filecedula = $nombreCedula;
                $proveedor->set('id', $answer);
                $proveedor->set('filecaratula', $filecaratula);
                $proveedor->set('filecedula', $filecedula);
                $answer2 = $proveedor->updateArchivos();
                if ($answer2) {
                    echo "1";
                }
            } else {
                echo"2";
            }
        } else {
            echo "0";
        }
    }else{
        echo"3";
    }
}        
        




//*****************************FUNCIÓN Correo*******************************************/}
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
            ->setCc(array($mailcc => $namecc))
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

//*****************************FUNCIÓN PDF*********************************/
function uploadPDF($nombreArchivo,$sizeArchivo,$tmpArchivo,$directorio){

$rutacompleta = $directorio . basename($nombreArchivo);
$respuesta = 1;
$extension = strtolower(pathinfo($nombreArchivo,PATHINFO_EXTENSION));

//TAMAÑO
if ($sizeArchivo > 5000000) {
    $respuesta = 0;
}
//FORMATO
if($extension == "pdf" || $extension != "PDF" || $extension == "jpg" || $extension != "JPG" || $extension == "png" || $extension != "PNG") {
}else{
    $respuesta = 0;
}
//SUBIDA
if ($respuesta != 0)
{
    if (move_uploaded_file($tmpArchivo, $rutacompleta)) 
    {
        $respuesta = 1;
    } 
    else 
    {
        $respuesta = 0;
    }
}
return $respuesta;

}
//*****************************FUNCIÓN PDF******************************** */
?>