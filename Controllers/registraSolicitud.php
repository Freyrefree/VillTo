<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
include_once str_replace(DS, "/", ROOT . 'Controllers/log.php'); #Log de actividad
include_once str_replace(DS, "/", ROOT . 'Models/asignacion.php'); #Modelo asignacion
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo usuario

$asignacion= new Asignacion();
$usuarioOBJ = new Usuario();


$solicitud = new Solicitud();
#parametros requeridos

$idUsuario = $_SESSION['_pid'];
$usuario = $_SESSION['_pnamefull'];

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
}else{

    #id --> Solicitud
    // fecha : fechasolicitud
    // proveedor : numproveedor | proveedor
    // cecos : cecos
    // localizador : localizador
    // concepto : concepto
    // monto : monto
    // moneda : moneda
    // tipocambio : tipocambio
    // montoletra : montoletra
    // fechalimite : fechalimite
    // facturas : facturas
    // importancia : importancia -> si | null
    // formapago : formapago

    #pueden ser varios bancos asi que debemos ingresarlos en otra tabla
    // banco
    // cuentaBanco
    // referencia
    // clabeinterbancaria
    #datos extra para pagos al extrangero
    // aba
    // swift

    $dataProvider = explode("|", @$_POST["proveedor"]);

    if(count($dataProvider) >= 3){
        $idproveedor = $dataProvider[0]; #id de proveedor [beneficiario]
        $numproveedor = $dataProvider[1]; #numero de proveedor [beneficiario]
        $proveedor = $dataProvider[2]; #nombre de proveedor [beneficiario]
    }else{
        $idproveedor = ""; #id de proveedor [beneficiario]
        $numproveedor = ""; #numero de proveedor [beneficiario]
        $proveedor =  @$_POST["proveedor"];#nombre de proveedor [beneficiario]
    }

    // $idproveedor = $dataProvider[0]; #id de proveedor
    // $numproveedor = $dataProvider[1]; #numero de proveedor
    // $proveedor = $dataProvider[2]; #nombre de proveedor

    $fecha = $_POST["fecha"];
    $cecos = $_POST["cecos"];
    $localizador = @$_POST["localizador"];
    $concepto = $_POST["concepto"];
    $monto = str_replace(",", "", $_POST["monto"]);
    $moneda = $_POST["moneda"];
    $tipocambio = $_POST["tipocambio"];
    $formapago=$_POST["formapago"];
    $montoletra = $_POST["montoletra"];

    $monedaPago = $_POST["monedaPago"];
    $conversionPago = str_replace(",", "", $_POST["conversion"]);;

    $fechalimite = $_POST["fechalimite"];
    $facturas = @$_POST["facturas"];
    $importancia = "";#$_POST["importancia"];

    ############ Tipo Solicitud 
    $tipoSolicitud = $_POST['tipoSolicitud'];

    switch ($tipoSolicitud) {
        case 1:
            $nombreSolicitud = "Operadores";
            break;
        case 2:
            $nombreSolicitud = "Proveedores";
            break;
        default:
            $nombreSolicitud = "udefinded";
    }
 
    #Datos Bancarios Nacional
    // if(!empty($_POST["banco"]))       $banco = $_POST["banco"];             else $banco = "";
    if(!empty($_POST["bancoCuenta"])){
        $datosBancarios = explode("|",$_POST["bancoCuenta"]);
        $banco = $datosBancarios[1];
        $cuentaBanco = $datosBancarios[2];
    }else {$cuentaBanco = ""; $banco="";}
    
    $referencia = @$_POST["referencia"];
    $clabeinter = @$_POST["clabeinter"];
    
    #Datos Bancarios Extrangero
    $aba   = $_POST["_aba"];
    $swift = $_POST["_swift"];

}
#Recepcion de datos $_POST

$solicitud->set('fecha', $fecha);
$solicitud->set('idproveedor', utf8_decode($idproveedor));
$solicitud->set('numproveedor', utf8_decode($idproveedor));
$solicitud->set('proveedor', utf8_decode($proveedor));
$solicitud->set('cecos', $cecos);
$solicitud->set('localizador', $localizador);
$solicitud->set('concepto', utf8_decode($concepto));
$solicitud->set('monto', $monto);
$solicitud->set('moneda', $moneda);
$solicitud->set('tipocambio', $tipocambio);

$solicitud->set('monedaPago', $monedaPago);
$solicitud->set('conversionPago', $conversionPago);

$solicitud->set('montoletra', utf8_decode($montoletra));
$solicitud->set('fechalimite', utf8_decode($fechalimite));
$solicitud->set('facturas', $facturas);
$solicitud->set('importancia', $importancia);
$solicitud->set('idUsuario', $idUsuario);
$solicitud->set('formapago', $formapago);

$solicitud->set('banco', $banco);
$solicitud->set('cuentaBanco', $cuentaBanco);
$solicitud->set('referencia', $referencia);
$solicitud->set('clabeinter', $clabeinter);

$solicitud->set('aba', $aba);
$solicitud->set('swift', $swift);

$solicitud->set('tipoSolicitud',$nombreSolicitud);
#Validacion Existencia erente
$asignacion->set("idusuario",$idUsuario);
$asignacion->set("tipo",$tipoSolicitud);
$answer = $asignacion->consultaGerentes();
if($fila = mysqli_fetch_array($answer)){
}else{
    echo "No se cuenta con un gerente asignado por favor de contactar al administrador del sistema para que le sea asignado";
    exit;
}
#Validacion Existencia erente

$folio = $solicitud->registraSolicitud();


if ($folio) {

    logs($folio,$usuario,'Registro solicitud');

    #envio de correo
    
    $asunto = "Solicitud Pago | Folio: ".$folio." | Solicitante: ".$usuario.".";
    require_once('../lib/swiftmailer/swift_required.php');

    $asignacion->set("idusuario",$idUsuario);
    $asignacion->set("tipo",$tipoSolicitud);
    $answer = $asignacion->consultaGerentes();
    while ($fila = mysqli_fetch_array($answer))
    {

        ######## Correo Gerente ################
        $idGerente = $fila['idgerente'];
        $usuarioOBJ->set('id',$idGerente);
        $usuarioOBJ->consultaUsuario();
        $nombre = $usuarioOBJ->get('nombre');
        $receptor = $usuarioOBJ->get('correo');


        //$receptor = 'dgutierrez@aiko.com.mx';
        //$nombre = "Diego";


        ########################################### Nombre Gerente que aceptará la solicitud !!!!! ####################
            
            $nombreGerneteCorreo    =  utf8_encode($usuarioOBJ->get('nombre'))." ".utf8_encode($usuarioOBJ->get('app'))." ".utf8_encode($usuarioOBJ->get('apm'));
            
            $linkAutoriza = URL . "Pagos/AceptarSolicitud.php?id=".$folio."&nombreGerenteCorreo=".$nombreGerneteCorreo;
            $linkRechaza =  URL . "Pagos/PreRechazo.php?id=".$folio."&nombreGerenteCorreo=".$nombreGerneteCorreo;

            ######################################

            $encript= base64_encode($folio);
            $linkDescarga = URL . "Pagos/descargaFacturas.php?id=".$encript;

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
                                DATOS SOLICITUD DE PAGO
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
                        Por medio del presente correo, se le notifica que se realizo una nueva solicitud de pago con la siguiente información
        
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
                        <td width="30%" ><font color="#003366"><strong> Folio Solicitud: <strong></font></td>
                        <td width="70%" ><strong> '.$folio.' <strong></td>
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
                        <td class="">$ '.number_format($monto,2,'.',',').'</td>
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
                        <td><br> </td>
                        <td><br> </td>
                    </tr>

                    <tr>
                        <td colspan="2"><a href="'.$linkDescarga.'" style="font-family:sans-serif;font-size:14px;text-decoration:none;"><u>Descargar Facturas</u></a></td>
                    </tr>

                    <tr>
                        <td align="right"><a href="'.$linkAutoriza.'" style="background-color:#0275d8;border:1px solid #0275d8;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;">Aceptar</a></td>
                        <td align="center"><a href="'.$linkRechaza.'" style="background-color:#EB7035;border:1px solid #EB7035;border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:150px;">Rechazar</a></td>
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
        ################################################################################################




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
                echo 1;
            }else{
                echo 'Error: Ocurrio un problema al enviar el correo de la solicitud';
            }
        } catch (Exception $e) {
        //echo 'Excepcion',  $e->getMessage(), "\n";
        }

    }

    

    #codigo carga de facturas [documentos]
    $nombre_archivo ="";$nombres_archivos="";
    for($i=0;$i<count($_FILES["facturas"]["name"]);$i++){
        /* Lectura del archivo */
        $nombre_archivo = $_FILES['facturas']['name'][$i];
        $tipo_archivo   = $_FILES['facturas']['type'][$i];
        $tamano_archivo = $_FILES['facturas']['size'][$i];
        $tmp_archivo    = $_FILES['facturas']['tmp_name'][$i];

        if ($nombre_archivo != "" and !empty($folio)) {
            $nom_arch = $nombre_archivo;
            //Guardar el archivo en la carpeta doc_compra/numero_remision
            $num_compra=$folio;
            if($tamano_archivo!=0){
                $ruta_pancarta= str_replace(DS, "/", ROOT . 'Pagos/Facturas/'.$num_compra);
                $archivador= str_replace(DS, "/", ROOT . 'Pagos/Facturas/'.$num_compra);
                $dir_logo=$archivador."/".$nombre_archivo;
                
                if (file_exists(str_replace(DS, "/", ROOT . 'Pagos/Facturas/'.$num_compra))) {

                } else {
                    mkdir(str_replace(DS, "/", ROOT . 'Pagos/Facturas/'.$num_compra),0700);    
                }

                if(!move_uploaded_file($tmp_archivo,$dir_logo)) { $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');}
                if(!copy($dir_logo,$archivador."/".$nombre_archivo)){ 
                    if (count($_FILES["facturas"]["name"]) > $i) {
                        if ($i>=1) {
                            $nombres_archivos = $nombres_archivos.",".$nombre_archivo;
                        }else{
                            $nombres_archivos = $nombre_archivo;
                        }
                    }else{
                        $nombres_archivos=$nombre_archivo;
                    }
                }
            }
        }
    }
    #codigo carga de facturas [documentos]

} else {
    echo "0";
}







?>