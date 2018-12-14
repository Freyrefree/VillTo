<?php
include_once '../app/config.php'; #Configuracion
// include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');
$idUsuario = $_SESSION['_pid'];
#Recepcion de datos $_GET
if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
}else{
    $folio = @$_POST['_folio'];
    // $tipo  = @$_POST['tipo'];#valor que indica si es nomina
}
#Recepcion de datos $_GET
$rutaFacturas = str_replace(DS, "/", ROOT . 'Pagos/Facturas/'.$folio."/");
$rutaDescarga = URL."Pagos/Facturas/".$folio."/";

if (file_exists($rutaFacturas)) {
    $directorio = opendir($rutaFacturas); //ruta de las Facturas
    $cuentaCFD=0;
    while ($archivo = readdir($directorio)){ #Obtenemos todos los archivos contenidos
        if (is_dir($archivo)){ //verificamos que sea un directorio
        }
        else{

            $array = explode('.', $archivo);
            $extension = $array[count($array) - 1];
            //echo $last_dir;

            if($extension != "zip"){
            
            echo '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <a href="'.$rutaDescarga.$archivo.'" type="button" class="btn btn-danger btn-sm" download >'.$archivo.'</a>
                    <div class="btn-group" role="group">
                        <button type="button" onclick="eliminaFactura('."'".$rutaFacturas.$archivo."'".')" class="btn btn-danger btn-sm" title="Eliminar archivo"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>&nbsp;&nbsp;';
            // echo '<a href="'.$rutaDescarga.$archivo.'" type="button" class="btn btn-danger btn-sm" download>'.$archivo.'</a>&nbsp;'; #listamos con botones los archivos contenidos

            $cuentaCFD=$cuentaCFD+1;
            
            }
        }
    }
    if($cuentaCFD == 0){
        echo "<h3>No existen facturas que mostrar.</h3>";
    }
} else {
    echo "<h3>No existen facturas que mostrar.</h3>";
}

echo "<br><br><br>";

?>