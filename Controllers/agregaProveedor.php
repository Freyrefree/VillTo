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
    $numproveedor = trim($_POST['numproveedor']);
    if($numproveedor == ""){
        $answer1 = true;
    }else{
        $proveedor->set('numproveedor', utf8_decode($numproveedor));
        $answer1 = $proveedor->verificaProveedor();
    }


    if ($answer1 != false) 
    {
            $rfc = $_POST['rfc'];
            $razonsocial = $_POST['razonsocial'];
            $direccion = $_POST['direccion'];
            $cp = $_POST['cp'];
            $aliascomercial = $_POST['aliascomercial'];
            $email = $_POST['email'];
            $contacto = $_POST['contacto'];
            $tel1 = $_POST['tel1'];
            $tel2 = $_POST['tel2'];
            $comunidad = $_POST['comunidad'];
            $pais = $_POST['pais'];
            //$tipo = $_POST['tipopro'];

            //$filecaratulaname = $_FILES['filecaratula']['name'];
            //$filecedulaname = $_FILEST['filecedula']['name'];

            $aba = @$_POST['aba'];
            $swift = @$_POST['swift'];

            $activo = 'si';
        
        #Recepcion de datos $_POST
        //************************Archivos PDF**********************************/
        //. URL . 'Administracion/proveedores.php'



        $nombreCaratula=basename($_FILES["filecaratula"]["name"]);
        $sizeCaratula=$_FILES["filecaratula"]["size"];
        $tmpCaratula = $_FILES["filecaratula"]["tmp_name"];

        $nombreCedula=basename($_FILES["filecedula"]["name"]);
        $sizeCedula=$_FILES["filecedula"]["size"];
        $tmpCedula = $_FILES["filecedula"]["tmp_name"];





        //************************Archivos PDF**********************************/

        $proveedor->set('numproveedor', utf8_decode($numproveedor));
        //$proveedor->set('tipo', $tipo);
        $proveedor->set('rfc', utf8_decode($rfc));
        $proveedor->set('razonsocial', addslashes(utf8_decode($razonsocial)));
        $proveedor->set('direccion', addslashes(utf8_decode($direccion)));
        $proveedor->set('cp', addslashes(utf8_decode($cp)));
        $proveedor->set('aliascomercial', addslashes(utf8_decode($aliascomercial)));
        $proveedor->set('email', utf8_decode($email));
        $proveedor->set('contacto', utf8_decode($contacto));
        $proveedor->set('tel1', utf8_decode($tel1));
        $proveedor->set('tel2', utf8_decode($tel2));
        $proveedor->set('comunidad', $comunidad);
        $proveedor->set('pais', utf8_decode($pais));
        $proveedor->set('aba', utf8_decode($aba));
        $proveedor->set('swift', utf8_decode($swift));
        $proveedor->set('activo', utf8_decode($activo));


        $answer = $proveedor->registraProveedor();
        if ($answer != "") {
            $directorio = str_replace(DS, "/", ROOT . 'Administracion/docs/'.$answer.'/');
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

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

            if ($respuestaCartula == 1 && $respuestaCedula == 1) {
                $filecaratula = $nombreCaratula;
                $filecedula = $nombreCedula;
                $proveedor->set('id', $answer);
                $proveedor->set('filecaratula', $filecaratula);
                $proveedor->set('filecedula', $filecedula);
                $answer2 = $proveedor->updateArchivos();
                if ($answer2) {
                    echo "1";
                }
            } else {
                echo"2";
            }
        } else {
            echo "0";
        }
    }else{
        echo"3";
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