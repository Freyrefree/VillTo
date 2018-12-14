<?php
include_once '../app/config.php';
include_once str_replace(DS,"/",ROOT.'Models/solicitud.php');

$solicitud = new Solicitud();


$opcion = $_POST['opcion'];

$data = array();

if($opcion == 2){


    $idSolicitud = $_POST['id'];

    $folderRaiz = "Pagos/Facturas/";
    $folderSolicitud = "../".$folderRaiz.$idSolicitud;


    if(is_dir($folderSolicitud)){

        $directorio = opendir($folderSolicitud); //ruta de las Facturas
        
        while ($archivo = readdir($directorio)){ #Obtenemos todos los archivos contenidos

            if($archivo != "." && $archivo != '..'){

                $array = explode('.', $archivo);
                $extension = $array[count($array) - 1];
                //echo $last_dir;

                if($extension != "zip"){

                    if($extension == "pdf"){

                        $documento = '<a href="#"  onclick="documento('."'".$folderSolicitud."/".$archivo."'".');" class="list-group-item list-group-item-action list-group-item-secondary">'.$archivo.'</a>';
                        $data[]=array(
                            'documento' => $documento
                        );

                    }else{

                        $documento ='<a href="'.$folderSolicitud."/".$archivo.'" target="_blank" onclick="documentoB();"  class="list-group-item list-group-item-action list-group-item-secondary" download >'.$archivo.'</a>';
                        $data[]=array(
                            'documento' => $documento
                        );

                    }

                }

            }

        }

        echo json_encode($data);

    }

}else if($opcion == 1){

    $idSolicitud = $_POST['id'];

    $solicitud->set('id',$idSolicitud);

    $respuesta = $solicitud->validarExistente();

    if($respuesta){
        echo "1";
    }else{

        echo "0";
    }

}








?>