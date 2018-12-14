<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
include_once str_replace(DS, "/", ROOT . 'Controllers/log.php'); #Log de actividad
$solicitud = new Solicitud();
#parametros requeridos
$usuarioS = $_SESSION['_pnamefull'];

$idUsuario = $_SESSION['_pid'];
$usuario = $_SESSION['_pnamefull'];

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
} else {

    $folio = $_POST["_foliof"];
    $facturas = @$_POST["facturas"];

}
#Recepcion de datos $_POST

$solicitud->set('id', $folio);
$solicitud->set('facturas', $facturas);

$answer = $solicitud->registraFacturas();

if ($answer) {
    $nombre_archivo ="";$nombres_archivos="";
    for($i=0;$i<count($_FILES["cfdfacturas"]["name"]);$i++){
        /* Lectura del archivo */
        $nombre_archivo = $_FILES['cfdfacturas']['name'][$i];
        $tipo_archivo   = $_FILES['cfdfacturas']['type'][$i];
        $tamano_archivo = $_FILES['cfdfacturas']['size'][$i];
        $tmp_archivo    = $_FILES['cfdfacturas']['tmp_name'][$i];

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
                    logs($folio,$usuarioS,'Carga Factura: '.$nombre_archivo);

                    if (count($_FILES["cfdfacturas"]["name"]) > $i) {
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
    echo "1";
} else {
    echo "0";
}
?>