<?php
    include_once '../app/config.php'; //Modelo usuario
    if(!$_SESSION['_pid']){
        header('Location: '.URL.'login.php?e=n');
    }
    $idVendedor = $_SESSION['_pid'];
    $nombre     = $_SESSION['_pname'];
    $nombreAll  = $_SESSION['_pnamefull'];
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="" type="image/vnd.microsoft.icon" />
    <title>Villa Tours | Áreas</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <!-- <link href="css/mdb.min.css" rel="stylesheet"> -->
    
    <script src="../js/jquery-3.1.1.js"></script>
    

    <script type="text/javascript" src="../js/tether.min.js"></script>
    <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <script src="../js/i18n/grid.locale-es.js" type="text/javascript"></script>
    <script src="../js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/ui.jqgrid-bootstrap.css"/>
    <!-- <script type="text/javascript" src="js/mdb.min.js"></script> -->
    <link rel="stylesheet" href="../css/grid.css"/>
    <script>
      $.jgrid.defaults.responsive = true;
      $.jgrid.defaults.styleUI = 'Bootstrap';

    </script>
    <style>
        body{
            background: #F8F9F9;
        }
        .titulo{
            /* background:#5cb85c;  */
            /*#0275d8;*/
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
        /* .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 20px;
            margin-top: -8px;
            display: inine-block;
        }
        .ui-jqgrid-labels{
            background:#E5E8E8;
        } */
        .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 25px;
        }
    </style>
</head>
<body>
    <?php include_once "../layout.php"; ?>
    <div class="container-fluid">
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE USUARIOS START>>>>>>>>>>>>>===========-->
     
     <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                        <h6 style="float:left">Administración / Áreas - [cecos]</h6>
                    </div>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-block">
                    <div class="row">
                    </div>
                    <!-- <hr class="my-4"> -->
                        <div class="row">
                            <div class='col-md-8'>
                              <table id="jqGrid" class="table table-bordered">
                                  
                              </table>
                              <div id="jqGridPager" >
                                  
                              </div>
                            </div>
                              <div class='col-md-4'>
                                   <div id='formularioArea'>
                                       <form method="POST" id="formRegistraArea">
                                        <div class="row">
                                        <!-- <div class="form-group row"> -->
                                            <div class="col-md-8">
                                                <label for="" class="">Nombre área:</label>
                                                <input class="form-control" type="text" id="nombreArea" name="nombreArea" placeholder="..." required>
                                                <label for="" class="">CECO:</label>
                                                <input class="form-control" type="text" id="ceco" name="ceco" placeholder="..." required>
                                            </div>
                                            <!-- </div> -->
                                
                                            <!-- </div> -->
                                            <div class="col-12">
                                                <br>
                                                <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true" disabled="true"></i> Registrar</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- <br> -->
            </div>
            
        </div>
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE USUARIOS END>>>>>>>>>>>>>===========-->
     <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Areas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id='msg'></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-primary">Guardar</button>-->
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal -->

    <script>
         $(document).ready(function () {
          $("#jqGrid").jqGrid({
            url:'../Controllers/listarAreas.php',
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                {label: 'Id', name: 'id', width: 5, key: true},    
                {label: 'Area', name: 'nombreArea', width: 30},
                {label: 'CECO', name: 'ceco', width: 15},
                {label: 'Tool', name: 'Tool', width: 5 }
            ],
           loadonce: true,
            viewrecords: true,
            autowidth: true,
            /*width:1280,*/
            height:350,
            rowNum: 7,
            rowList : [7,10,15],
            pager: '#jqGridPager' 

          });

          jQuery("#jqGrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:"cn"});

$(".glyphicon-backward").addClass("fa fa-chevron-left");
$(".fa-chevron-left").removeClass("glyphicon-backward");

$(".glyphicon-forward").addClass("fa fa-chevron-right");
$(".fa-chevron-right").removeClass("glyphicon-forward");

$(".glyphicon-step-backward").addClass("fa fa-step-backward");
$(".fa-step-backward").removeClass("glyphicon-step-backward");

$(".glyphicon-step-forward").addClass("fa fa-step-forward");
$(".fa-step-forward").removeClass("glyphicon-step-forward");


$(".ui-pg-selbox").removeClass("ui-pg-selbox");

          
      });
    </script>

<!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO START>>>>>>===========-->
    <script type="text/javascript">
        $("#formRegistraArea").on("submit", function(e){
            e.preventDefault();
            var formData = new FormData(document.getElementById("formRegistraArea"));
            $.ajax({
                url: "../Controllers/agregaArea.php",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
                }).done(function(res){
                    if(res==1){
                        $('#msg').text('SE AGREGO CON EXITO EL ÁREA');
                        $("#modalMsg").modal('show');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }else{
                        $('#msg').text('Error: No se pudo registrar el Arae, favor de revisar la información e intentarlo nuevamente');
                        $("#modalMsg").modal('show');
                    }
                });
            e.preventDefault(); //stop default action
            //e.unbind(); //unbind. to stop multiple form submit.
        });

        function editar(key){
               $.ajax({
                     url: "../Controllers/buscaArea.php",
                     type: "POST",
                     dataType: "html",
                     data: "id=" + key,
                     success:  function (response) {
                        $("#formularioArea").html(response);
                     }
                });

     }
     function eliminar(key){
        $.ajax({
                url: "../Controllers/eliminaArea.php",
                type: "POST",
                dataType: "html",
                data: "id=" + key,
                success:  function (response) {
                if(response==1){
                    $('#msg').text('SE ELIMINO CORRECTAMENTE EL ÁREA');
                    $("#modalMsg").modal('show');
                    $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarAreas.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
                    // setTimeout(function () {
                    //     location.reload();
                    // }, 1000);
                }else{
                    $('#msg').text('Error: Ocurrio un problema con la eliminacion de Área, ponganse en contacto con el administrador del sistema.');
                    $("#modalMsg").modal('show');
                }
                
                }
        });
    }
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO END>>>>>>===========-->



</body>
</html>