<?php
    include_once '../app/config.php'; //Modelo usuario
    $idSolicitud = $_GET['id'];
    $idSolicitud = base64_decode($idSolicitud);
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="" type="image/vnd.microsoft.icon" />
    <title>Villa Tours | Pagos</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    
    <script src="../js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="../js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../js/i18n/grid.locale-es.js" type="text/javascript"></script>
    <script src="../js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/ui.jqgrid-bootstrap.css"/>

    
    <script>
      $.jgrid.defaults.responsive = true;
      $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>

    <style>
        body{
            background: #F8F9F9;
        }
        .titulo{
            color: #F2F2F2;
            padding: 8px;
        }
        .modal-header{
            background: #0275d8;
            color: #F2F2F2;
        }
        .listado-tareas {
            max-height: calc(50vh - 70px);
            overflow-y: auto;
        }
        .btn{
            border-radius: 0px;
        }
        .finish{
            text-decoration:line-through;
        }
        .dropdown-item{
            color: #E5E8E8;
        }
        .dropdown-item:hover{
            color:#F4F6F6;
        }
        .azul:hover{
            color: #0275d8;
            font-size: 17px;
        }
        .rojo:hover{
            color: #d9534f;
            font-size: 17px;
        }
        .azul{
            color: #0275d8;
            font-size: 17px;
        }
        .rojo{
            color: #d9534f;
            font-size: 17px;
        }
        ::-webkit-scrollbar {
            width: 3px;
            height: 6px;
        }
         
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 50px rgba(0,0,0,0.3); /* 105,106,110 */
            border-radius: 0px;
        }
         
        ::-webkit-scrollbar-thumb {
            border-radius: 0px;
            -webkit-box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        }
        .folder{
            color:#F39C12;
        }
        .pdf{
            color: #3498DB;
        }
        .linkIcono{
            text-decoration:none;
        }

        .list-group{
            max-height: 500px;
            
            overflow:scroll;
        }
        .list-group a{
            display: block;
            height: 100%;
        }
    </style>
    <link rel="stylesheet" href="../css/grid.css"/>
</head>
<body>
   
   
    <div class="container-fluid">

    
  
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-block titulo bg-primary">
                        <h5 style="float:left">Solicitudes / Descarga Archivos</h5>
                        <div class="col-md-3" style="text-align: right;float:right;">
                        </div>
                    </div>

                    
                    <div class="card-block">

                        <div class="row">
                            <div class="col-md-12">
                            <small>Sólo se visualizarán archivos PDF</small>
                            </div>                            
                        </div>

                        <div class="row">

                            <div class="col-md-3">

                                <div class="card">
                                <div class="card-header">
                                <b>Solicitud No° <?php echo $idSolicitud; ?> </b> 
                                </div>
                                <div class="card-body">
                                    <div class="list-group" id="listDocs"></div>
                                </div>
                                </div>
                            </div>

                            <!--===========<<<<<<<<<<<<<Listado>>>>>>>>>>>>>===========-->

                            <div class="col-md-9">

                                <div class="card">
                                    <div class="card-header">
                                        <b>Vista Previa</b> 
                                    </div>

                                    <div class="card-body">
                                        <div class='col-md-12' id="divRespuesta"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
           
        </div>

    </div>

</body>
</html>
    

    <script>
    $(document).ready(function () {

     var idSolicitud = "<?php echo $idSolicitud; ?>";

    
   
    $.ajax({
    method: "POST",
    url: "../Controllers/listarDocFacturas.php",
    dataType: "json",
    data: { id: idSolicitud, opcion: 1 }
    }).done(function(respuesta) {


        if(respuesta == "1"){

            

            $.ajax({
            method: "POST",
            url:"../Controllers/listarDocFacturas.php",
            dataType: "json",
            data: { id: idSolicitud, opcion: 2 }
            }).done(function(respuesta) {
                console.log(respuesta.length);

                if(respuesta.length > 0){

                    $.each(respuesta, function(key, item) {
                        $("#listDocs").append(item.documento);
                    });

                }else if(respuesta.length <= 0){

                    $("#divRespuesta").append('<h5>No existen facturas que mostrar.</h5>');
                }

                

            });
            

        }else if(respuesta == "0"){

            $("#divRespuesta").append('<h5>Lo sentimos la Solicitud es Inexistente</h5>');
        }


    });
    

});
            

function documento(ruta)
{
    //console.log(ruta);
    $("#divRespuesta").html('');

    array = ruta.split('.');
    nombreExtension = array[array.length-1];
    console.log(nombreExtension);

    if(nombreExtension == "pdf"){

        $("#divRespuesta").append('<iframe  id="embedArchivo"  frameborder="0" width="100%" height="700px"></iframe>');


        $("#embedArchivo").attr("src","").
        collapse('hide').
        attr("src",ruta).
        collapse('show');

    }else{
       
        $("#divRespuesta").html('').
        append('<small>Lo sentimos la visualización sólo está disponible en archivos pdf, Pero su archivo se ha descargado</small>');
    }

    
}

function documentoB(){

    $("#divRespuesta").html('').
    append('<small><b>Lo sentimos la visualización sólo está disponible en archivos pdf, Pero su archivo se ha descargado</b></small>');

}
        

</script>


