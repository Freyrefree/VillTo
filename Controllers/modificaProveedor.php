<?php

#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo Proveedor
$proveedor = new Proveedor();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
}else{

    $key            = $_POST['key'];
    $numproveedor   = trim($_POST['numproveedor']);
    $rfc            = $_POST['rfc'];
    $razonsocial    = $_POST['razonsocial'];    
    $direccion      = $_POST['direccion'];
    $cp             = $_POST['cp'];
    $aliascomercial = $_POST['aliascomercial'];
    $email          = $_POST['email'];
    $contacto       = $_POST['contacto'];
    $tel1           = $_POST['tel1'];
    $tel2           = $_POST['tel2'];
    $comunidad      = $_POST['comunidad'];
    $pais           = $_POST['pais2'];

  
    $filecaratulahidd = $_POST['filecaratulahidd'];///CAMPOS ya LLENOS con el valor de la base 
    $filecedulahidd = $_POST['filecedulahidd'];///CAMPOS ya LLENOS con el valor de la base

    $nombreCaratula=basename($_FILES["filecaratula"]["name"]);//Documento Nuevo
    $nombreCedula=basename($_FILES["filecedula"]["name"]);//Documento Nuevo

    $aba = @$_POST['aba'];
    $swift = @$_POST['swift'];

    $activo = 'si';
}
#Recepcion de datos $_POST



 ## Validar RFC y Razon Social ##
 $rfcValidate    = $_POST['rfcValidate'];
 $razonsocialValidate = $_POST['razonsocialValidate'];

 if($rfcValidate != $rfc){

    if($rfc == 'XEXX010101000') ## Validar cuando es Extranjero. Validar por Razon social ##
    {
        //if ($razonsocialValidate != $razonsocial) {

            $proveedor->set('razonsocial', utf8_decode($razonsocial));
            $respuesta = $proveedor->razonSocialExistente();

            if (!$respuesta) {
                echo "4"; ## Ya existe con esa razon social ##
                exit;
            }
        //}   

    }else ## Validar cuando es Nacional. Validar por RFC ##
    {
       
            $proveedor->set('rfc', utf8_decode($rfc));
            $respuesta = $proveedor->rfcExistente();
    
            if(!$respuesta){
                echo "5"; ## Ya existe con ese rfc##
                exit;
            }
    }





 }

        //if($filecaratulahidd == "" && $filecedulahidd == "")///CAMPOS ya LLENOS con el valor de la base
    if($nombreCaratula != "" || $nombreCedula != "")
    {
        //************************Archivos PDF**********************************/
        //. URL . 'Administracion/proveedores.php'
        $directorio = str_replace(DS, "/", ROOT . 'Administracion/docs/'.$key.'/');
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }


        $nombreCaratula=basename($_FILES["filecaratula"]["name"]);
        $sizeCaratula=$_FILES["filecaratula"]["size"];
        $tmpCaratula = $_FILES["filecaratula"]["tmp_name"];

        $nombreCedula=basename($_FILES["filecedula"]["name"]);
        $sizeCedula=$_FILES["filecedula"]["size"];
        $tmpCedula = $_FILES["filecedula"]["tmp_name"];

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

        if($respuestaCartula == 1 && $respuestaCedula == 1)
        {
            $filecaratula = $nombreCaratula;
            $filecedula = $nombreCedula;

        //************************Archivos PDF**********************************/

            $proveedor->set('id', $key);
            $proveedor->set('tipo', '');
            $proveedor->set('numproveedor', utf8_decode($numproveedor));
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
            $proveedor->set('filecaratula', utf8_decode($filecaratula));
            $proveedor->set('filecedula', utf8_decode($filecedula));
            $proveedor->set('aba', utf8_decode($aba));
            $proveedor->set('swift', utf8_decode($swift));
            $proveedor->set('activo', "si");

            $answer = $proveedor->modificaProveedor();
            if($answer){
                echo "1";
            }else{
                echo "0";
            }

        }
        else{
            echo"2";
        }
    }
    else
    {
        $proveedor->set('id', $key);
        $proveedor->set('tipo', '');
        $proveedor->set('numproveedor', utf8_decode($numproveedor));
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
        $proveedor->set('filecaratula', utf8_decode($filecaratulahidd)); //se modifica con el archivo que anteriormente etaba regsitrado
        $proveedor->set('filecedula', utf8_decode($filecedulahidd)); //se modifica con el archivo que anteriormente etaba regsitrado
        $proveedor->set('aba', utf8_decode($aba));
        $proveedor->set('swift', utf8_decode($swift));
        $proveedor->set('activo', utf8_decode($activo));

        $answer = $proveedor->modificaProveedor();
        if($answer){
            echo "1";
        }else{
            echo "0";
        }   

    }


     



 



//*****************************FUNCIÓN PDF******************************** */
function uploadPDF($nombreArchivo,$sizeArchivo,$tmpArchivo,$directorio)
{
$rutacompleta = $directorio . basename($nombreArchivo);
$respuesta = 1;
$extension = strtolower(pathinfo($nombreArchivo,PATHINFO_EXTENSION));

//TAMAÑO
if ($sizeArchivo > 5000000) {   
    $respuesta = 0;
}
//FORMATO
// if(($extension != "pdf") && ($extension != "PDF")) {
//     $respuesta = 0;
// }
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