<?php
set_time_limit(0);
include_once 'app/config.php'; #Configuracion
include_once 'Models/seguridad.php'; #Modelo usuario
$usuario  = new Usuario();
if(!$_POST){
	header('Location: login.php');
exit;
}else {
	$rolUsuario = "";
	$id_Usuario = "";

	$usuario->set("email",	  addslashes(utf8_decode($_POST['email'])));
	$usuario->set("password", addslashes(utf8_decode(sha1(md5($_POST['password'])))));

	$usuario->validaExistencia();

	$id_Usuario = $usuario->get("id");
	$nombre     = $usuario->get("nombre");
	$apellidop  = $usuario->get("apellidop");
	$apellidom  = $usuario->get("apellidom");
	$rolUsuario = $usuario->get("perfil");
	$estatus    = $usuario->get("estatus");
	$ceco    	= $usuario->get("ceco");

	if(empty($rolUsuario)){
			$msg="Lo sentimos no cuenta con llos privilegios para acceder al sistema, consulte con su administrador";
			header('Location: login.php?e=n');
			exit;
		}else{

			$_SESSION['_pid'] 	    = $id_Usuario; #idbd
			$_SESSION['_plogin']    = 1; #indicador acceso
			$_SESSION['_prol']      = $rolUsuario; #perfil [permisos]
			$_SESSION['_pname']     = $nombre; #nombre
			$_SESSION['_pnamefull'] = $nombre." ".$apellidop." ".$apellidom; #nombre completo
			$_SESSION['_ppass'] 	= $estatus; #estatus de empleado
			$_SESSION['_ceco'] 		= $ceco; #centro de costo

			if ($rolUsuario == 1 || $rolUsuario == 2 || $rolUsuario == 3 || $rolUsuario == 4 || $rolUsuario == 5 || $rolUsuario == 6) {
				print "<meta http-equiv='refresh' content='0; url = ".URL."Pagos/inicio.php'>";
				exit;
			}else {
				$msg="No es posible acceder consulte a su administrativo";
				print "<meta http-equiv='refresh' content='0; url=login.html?msg=$msg'>";
				exit;
			}
			
		}
}
?>
