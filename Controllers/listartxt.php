<?php
include_once '../app/config.php'; #Configuracion

#Recepcion de datos $_GET
if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
}else{
    $folio = @$_POST['_folio'];
}
#Recepcion de datos $_GET
$rutaComprobantes = str_replace(DS, "/", ROOT . 'Pagos/txt/'.$folio."/");
$rutaDescarga     = URL."Pagos/txt/".$folio."/";

if (file_exists($rutaComprobantes)) {
    $directorio = opendir($rutaComprobantes); //ruta de las Facturas
    $cuentaCFD=0;
    while ($archivo = readdir($directorio)){ #Obtenemos todos los archivos contenidos
        if (is_dir($archivo)){ //verificamos que sea un directorio
        }
        else{

            echo '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <a href="'.$rutaDescarga.$archivo.'" type="button" class="btn btn-primary btn-sm" download >'.$archivo.'</a>
                    <div class="btn-group" role="group">
                        <!--<button type="button" onclick="eliminaComprobante('."'".$rutaComprobantes.$archivo."'".')" class="btn btn-primary btn-sm" title="Eliminar archivo"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                    </div>
                </div>&nbsp;&nbsp;';
            // echo '<a href="'.$rutaDescarga.$archivo.'" type="button" class="btn btn-primary btn-sm" download>'.$archivo.'</a>&nbsp;'; #listamos con botones los archivos contenidos

            $cuentaCFD=$cuentaCFD+1;
        }
    }
    if($cuentaCFD == 0){
        echo "<h3>No existen TXT que mostrar.</h3>";
    }
} else {
    echo "<h3>No existen TXT que mostrar.</h3>";
}

echo "<br><br><br>";

?>