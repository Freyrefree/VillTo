<?php
include_once 'app/config.php'; #Configuracion
if(empty($_SESSION['_pid'])){
    header('Location: '.URL.'login.php');
}else{
    header('Location: '.URL.'Pagos/inicio.php');
}

?>