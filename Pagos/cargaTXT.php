<?php
// include 'config.php';
// $conexion=mysqli_connect($server,$dbuser,$dbpass,$database);
// $archi= trim ($_FILES['comprobantes']['name']);
// $comprobante=$_POST['Nocomprobantes'];
// $SQL="insert into columnas (columna1) values ('".$archi."') ";            
// $result2 = mysqli_query($conexion,$SQL) or die("Couldn't execute query.".mysql_error()); 


// #parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
include_once str_replace(DS, "/", ROOT . 'Controllers/log.php'); #Log de actividad
$solicitud = new Solicitud();
#parametros requeridos
$usuarioS = $_POST['nombreContabilidadCorreo'];

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Pagos/solicitudes.php');
    exit;
} else {

    $folio = $_POST["_folioc"];
    //$txt = @$_POST["txt"];
    $nombre_archivo = $_FILES['comprobantes']['name'];

}
#Recepcion de datos $_POST

#verificar si ya hay txt en esa solicitud#
$solicitud->set('id',$folio);
$answer1  = $solicitud->buscarSolicitud();
if(mysqli_num_rows($answer1) > 0){

    $dato = mysqli_fetch_array($answer1);
    $txt = $dato['txt'];

    if($txt == ""){

        $solicitud->set('id', $folio);
        $solicitud->set('nomTXT', $nombre_archivo);
        $answer = $solicitud->registraTXT();
        if ($answer) {


                ##verificar si existe carpeta de facturas  por solicitud
    $rutaCarpte = "Facturas/".$folio;

    if(!file_exists($rutaCarpte)){
        mkdir($rutaCarpte,0700);
    }




            $nombre_archivo ="";$nombres_archivos="";
        // for($i=0;$i<count($_FILES["comprobantes"]["name"]);$i++){
                /* Lectura del archivo */
                $nombre_archivo = $_FILES['comprobantes']['name'];
                $tipo_archivo   = $_FILES['comprobantes']['type'];
                $tamano_archivo = $_FILES['comprobantes']['size'];
                $tmp_archivo    = $_FILES['comprobantes']['tmp_name'];

                if ($nombre_archivo != "" and !empty($folio)) {
                    $nom_arch = $nombre_archivo;
                    //Guardar el archivo en la carpeta doc_compra/numero_remision
                    $num_compra=$folio;
                    if($tamano_archivo!=0){
                        $ruta_pancarta= str_replace(DS, "/", ROOT . 'Pagos/txt/'.$num_compra);
                        $archivador= str_replace(DS, "/", ROOT . 'Pagos/txt/'.$num_compra);
                        $dir_logo=$archivador."/".$nombre_archivo;
                        
                        if (file_exists(str_replace(DS, "/", ROOT . 'Pagos/txt/'.$num_compra))) {

                        } else {
                            mkdir(str_replace(DS, "/", ROOT . 'Pagos/txt/'.$num_compra),0700);    
                        }

                        if(!move_uploaded_file($tmp_archivo,$dir_logo)) { $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');}
                        if(!copy($dir_logo,$archivador."/".$nombre_archivo)){ 
                            // if (count($_FILES["comprobantes"]["name"]) > $i) {
                            //     if ($i>=1) {
                            //         $nombres_archivos = $nombres_archivos.",".$nombre_archivo;
                            //     }else{
                            //         $nombres_archivos = $nombre_archivo;
                            //     }
                            // }else{
                            //     $nombres_archivos=$nombre_archivo;
                            // }
                            logs($folio,$usuarioS,'Carga Archivo txt: '.$nombre_archivo);

                            echo "1";
                        }
                    }
                }else{
                    echo "1";

                }
            //}
            


        } else {
            echo "0";

        }
        
        


    }else{

        



    }
        
    

}



?>
