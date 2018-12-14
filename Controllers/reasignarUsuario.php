<?php
#parametros requeridos

include_once '../app/config.php'; #Configuracion
include_once str_replace(DS,"/",ROOT.'Models/asignacion.php');
include_once str_replace(DS,"/",ROOT.'Models/usuario.php');
#parametros requeridos
$asignacion = new Asignacion();
$usuario    = new Usuario();


#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/usuarios.php');
    exit;
}else{

    
    $datosgerente = trim($_POST['reasignacionUsuario']);
    $gerente = explode('|', $datosgerente); # Division de datos gerente [ id | Nombre Apellido ]
    $arraySeleccion = json_decode($_POST['arraySeleccion']);


    ## Datos del gerente que realizará la reasignación ##

    $idUsuario = $_SESSION['_pid'];

    $usuario->set('id', $idUsuario);
    $usuario->getuserById();
    $correo   =  $usuario->get('correo');
    $nombre   =  utf8_encode($usuario->get('nombre'));
    $ap       =  utf8_encode($usuario->get('apellidoPaterno'));
    $am       =  utf8_encode($usuario->get('apellidoMaterno'));
    $nombreUser = $nombre." ".$ap." ".$am;


    ## Datos del gerente al que se reasignará ##

    $asignacion->set('idgerente', $gerente[0]);
    $asignacion->set('nombreGerente', $gerente[1]);

    $usuario->set('id', $gerente[0]);
    $usuario->getuserById();

    $idGerenteNuevo = $gerente[0];
    $correoGeNuevo   =  $usuario->get('correo');
    $nombreGeNuevo   =  utf8_encode($usuario->get('nombre'));
    $apGeNuevo       =  utf8_encode($usuario->get('apellidoPaterno'));
    $amGeNuevo       =  utf8_encode($usuario->get('apellidoMaterno'));
    $nombreGerenteNuevo = $nombreGeNuevo." ".$apGeNuevo." ".$amGeNuevo;



    foreach ($arraySeleccion as &$idAsignacion) {

    ## Consultar gerente actual ##
        $asignacion->set('id', $idAsignacion);
        $asignacion->getByIdAsignacionGerente();
        $idGerenteAnterior  =  $asignacion->get('idgerente');
        $correoGeAnterior   =  $asignacion->get('correo');
        $nombreGeAnterior   =  utf8_encode($asignacion->get('nombre'));
        $apGeAnterior       =  utf8_encode($asignacion->get('apellidoPaterno'));
        $amGeAnterior       =  utf8_encode($asignacion->get('apellidoMaterno'));

        $nombreGerenteAnterior = $nombreGeAnterior." ".$apGeAnterior." ".$amGeAnterior;


        ## consulta Datos Consultor (a quien le llegará el correo) ##

        $asignacion->set('id', $idAsignacion);
        $asignacion->getByIdAsignacionConsultor();
        $idconsultor       =  $asignacion->get('idusuario');
        $correoConsultor   =  $asignacion->get('correo');
        $nombreConsultor   =  utf8_encode($asignacion->get('nombre'));
        $apConsultor       =  utf8_encode($asignacion->get('apellidoPaterno'));
        $amConsultor       =  utf8_encode($asignacion->get('apellidoMaterno'));

        $nombreConsultor = $nombreConsultor." ".$apConsultor." ".$amConsultor;

        ##

            //$correoConsultor = "dgutierrez@aiko.com.mx";
            //$correoGeNuevo = "dgutierrez@aiko.com.mx";
            //$correoGeAnterior = "dgutierrez@aiko.com.mx";

        ##

        $resCorreo = correo($idconsultor,$correoConsultor,$nombreConsultor,$idUsuario,$correo,$nombreUser,$idGerenteNuevo, $correoGeNuevo, $nombreGerenteNuevo, $idGerenteAnterior, $correoGeAnterior, $nombreGerenteAnterior);

        if($resCorreo){

            $asignacion->set('idgerente', $gerente[0]);
            $asignacion->set('nombreGerente', $gerente[1]);
            $asignacion->set('id', $idAsignacion);
            $answer = $asignacion->reasignarGerente();
        }
        
    }

    if ($answer) {
        echo "1";
    } else {
        echo "0";
    }
}



function correo($idconsultor,$correoConsultor,$nombreConsultor,$idUsuario,$correo,$nombreUser,$idGerenteNuevo, $correoGeNuevo, $nombreGerenteNuevo, $idGerenteAnterior, $correoGeAnterior, $nombreGerenteAnterior)
{

    $htmlConsultor='<table width="100%" style=" font-family: Arial, Helvetica, sans-serif; ">
    <tr>
        <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
            <font color="#FAFAFA" size="4px">
                REASIGNACIÓN
            </font>
        </td>
    </tr>

    <tr>

    <font color="#003366">
        <p align="justify">
         Estimado(a),
        </p>	
        <p>
            Por medio del presente correo, se le notifica que se han presentado cambios en el sistema de Pagos, correspondientes al modulo de reasignaciones 
        </p>
    </font>	

    </tr>

    <tr>
    <hr>
    </tr>

    </table>
    
    <table width="100%" style="font-family: Arial, Helvetica, sans-serif;">  

    <tr>
        <td><b>Usted ha sido Reasignado al Supervisor:</b></td>
        <td>
            <b>Nombre: </b>'.$nombreGerenteNuevo.'<br>
            <b>No usuario: </b>'.$idGerenteNuevo.'<br>
            <b>Correo: </b>'.$correoGeNuevo.'
        </td>
        
    </tr>
    <hr>

    <tr>
        <td><b>Usted anteriormente estaba asignado al Supervisor:</b></td>
        <td>
            <b>Nombre: </b>'.$nombreGerenteAnterior.'<br>
            <b>No usuario: </b>'.$idGerenteAnterior.'<br>
            <b>Correo: </b>'.$correoGeAnterior.'
        </td>
        
    </tr>
    <hr>

    <tr>
        <td><b>Usuario que realizó la reasignación</b></td>
        <td>
            <b>Nombre: </b>'.$nombreUser.'<br>
            <b>No usuario: </b>'.$idUsuario.'<br>
            <b>Correo: </b>'.$correo.'
        </td>
    </tr>

    <tr><br></tr>

    <tr>
        <td align="center" style="height: 20px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" colspan="3" bgcolor="#E6E6E6">
            <span style="color:#575756; font-size: 12px;">Este mensaje fue generado por un sistema automatizado, usando una direccion de correo de notificaciones. Por favor, no responder a este mensaje.</span>
        </td>
    </tr>
    
    </table>';

## **************************************************************************************************************** ##

    $htmlNuevoSupervisor='<table width="100%" style=" font-family: Arial, Helvetica, sans-serif; ">
    <tr>
        <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
            <font color="#FAFAFA" size="4px">
                REASIGNACIÓN
            </font>
        </td>
    </tr>
    <tr>

    <font color="#003366">
        <p align="justify">
         Estimado(a),
        </p>	
        <p>
            Por medio del presente correo, se le notifica que se han presentado cambios en el sistema de Pagos, correspondientes al modulo de reasignaciones 
        </p>
    </font>	

    </tr>

    <tr>
    <hr>
    </tr>

    
    </table>
    
    <table width="100%" style="font-family: Arial, Helvetica, sans-serif;">  

    <tr>
        <td><b>Se ha reasignado un usuario a su Supervisión:</b></td>
        <td>
            <b>Nombre: </b>'.$nombreConsultor.'<br>
            <b>No usuario: </b>'.$idconsultor.'<br>
            <b>Correo: </b>'.$correoConsultor.'
        </td>
        
    </tr>
    <hr>

    <tr>
        <td><b>Anteriormente el usuario estaba asignado al Supervisor:</b></td>
        <td>
            <b>Nombre: </b>'.$nombreGerenteAnterior.'<br>
            <b>No usuario: </b>'.$idGerenteAnterior.'<br>
            <b>Correo: </b>'.$correoGeAnterior.'
        </td>
        
    </tr>
    <hr>

    <tr>
        <td><b>Usuario que realizó la reasignación</b></td>
        <td>
            <b>Nombre: </b>'.$nombreUser.'<br>
            <b>No usuario: </b>'.$idUsuario.'<br>
            <b>Correo: </b>'.$correo.'
        </td>
    </tr>

    <tr><br></tr>

    <tr>
        <td align="center" style="height: 20px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" colspan="3" bgcolor="#E6E6E6">
            <span style="color:#575756; font-size: 12px;">Este mensaje fue generado por un sistema automatizado, usando una direccion de correo de notificaciones. Por favor, no responder a este mensaje.</span>
        </td>
    </tr>
    
    </table>';

## **************************************************************************************************************** ##

    $htmlAnteriorSupervisor='<table width="100%" style=" font-family: Arial, Helvetica, sans-serif; ">
    <tr>
        <td colspan="3" bgcolor="#0275d8" style="text-align: center;padding-top:5px;height:15px;" VALIGN="bottom">
            <font color="#FAFAFA" size="4px">
                REASIGNACIÓN
            </font>
        </td>
    </tr>
    <tr>

    <font color="#003366">
        <p align="justify">
         Estimado(a),
        </p>	
        <p>
            Por medio del presente correo, se le notifica que se han presentado cambios en el sistema de Pagos, correspondientes al modulo de reasignaciones 
        </p>
    </font>	

    </tr>

    <tr>
    <hr>
    </tr>

    
    </table>
    
    <table width="100%" style="font-family: Arial, Helvetica, sans-serif;">  

    <tr>
        <td><b>Usuario que anteriormente estaba a su Supervisión</b></td>
        <td>
            <b>Nombre: </b>'.$nombreConsultor.'<br>
            <b>No usuario: </b>'.$idconsultor.'<br>
            <b>Correo: </b>'.$correoConsultor.'
        </td>
        
    </tr>
    <hr>

    <tr>
        <td><b>Supervisor al que se reasignó el usuario</b></td>
        <td>
            <b>Nombre: </b>'.$nombreGerenteNuevo.'<br>
            <b>No usuario: </b>'.$idGerenteNuevo.'<br>
            <b>Correo: </b>'.$correoGeNuevo.'
        </td>
        
    </tr>
    <hr>

    <tr>
        <td><b>Usuario que realizó la reasignación</b></td>
        <td>
            <b>Nombre: </b>'.$nombreUser.'<br>
            <b>No usuario: </b>'.$idUsuario.'<br>
            <b>Correo: </b>'.$correo.'
        </td>
    </tr>

    <tr><br></tr>

    <tr>
        <td align="center" style="height: 20px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" colspan="3" bgcolor="#E6E6E6">
            <span style="color:#575756; font-size: 12px;">Este mensaje fue generado por un sistema automatizado, usando una direccion de correo de notificaciones. Por favor, no responder a este mensaje.</span>
        </td>
    </tr>
    
    </table>';


    require_once('../lib/swiftmailer/swift_required.php');
    $retorno = false;

    $asunto =  "Reasignación";

    try {
            $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
            ->setUsername('soporte@aiko.com.mx')
            ->setPassword('s0p0rt3**18');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
            ->setTo(array($correoConsultor =>$nombreConsultor))
            //->setCc(array($mailcc =>$namecc))
            ->setBody($htmlConsultor, 'text/html');
            if ($mailer->send($message)){
                
                $retorno = true;
            }else{
                $retorno = false;
            }
        } catch (Exception $e) {
            $retorno = false;
        }

########## ************************************************************************************** #############3

        try {
            $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
            ->setUsername('soporte@aiko.com.mx')
            ->setPassword('s0p0rt3**18');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
            ->setTo(array($correoGeNuevo =>$nombreGerenteNuevo))
            //->setCc(array($mailcc =>$namecc))
            ->setBody($htmlNuevoSupervisor, 'text/html');
            if ($mailer->send($message)){
                $retorno = true;
            }else{

                $retorno = false;
            }
        } catch (Exception $e) {
       
            $retorno = false;
        }

    




########## ************************************************************************************** #############3

        try {
            $transport = Swift_SmtpTransport::newInstance('mail.aiko.com.mx', 587)
            ->setUsername('soporte@aiko.com.mx')
            ->setPassword('s0p0rt3**18');
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance($asunto)
            ->setFrom(array('soporte@aiko.com.mx' => 'Villa Tours | Pagos'))
            ->setTo(array($correoGeAnterior =>$nombreGerenteAnterior))
            //->setCc(array($mailcc =>$namecc))
            ->setBody($htmlAnteriorSupervisor, 'text/html');
            if ($mailer->send($message)){
                $retorno = true;
            }else{

                $retorno = false;
            }
        } catch (Exception $e) {

            $retorno = false;
        }

return $retorno;

}





?>