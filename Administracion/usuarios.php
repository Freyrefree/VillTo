<?php
    include_once '../app/config.php'; //Modelo usuario
    #include_once 'Models/circuito.php'; //Modelo usuario
    #$circuito  = new Circuito();
    #define('URL', "http://localhost/JuliaTravelPagos/"); #representa [ ruta web ]

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
    <title>Villa Tours | Usuarios</title>
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
            /* background:#5cb85c; */
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
        .naranja{
            color: #FF8000;
        }
        .rojo{
            color: #d9534f;
            font-size: 17px;
        }
        .verde{
            color: #138D75;
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
            height: 20px;
        }
    </style>
</head>
<body>
   <?php
   include_once "../layout.php";
   ?>
    <div class="container-fluid">
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE USUARIOS START>>>>>>>>>>>>>===========-->  
     <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                    <h6 style="float:left">Administración / usuarios</h6>
                    </div>
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                        <button type="button" class="btn btn-primary btn-md" name="nuevo" id="nuevo"><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo Usuario</button>
                        </div>
                    </div>
                    <!-- <hr class="my-4"> -->
                        <div class="row">
                            <div class='col-md-12'>
                              <table id="jqGrid" class="table table-bordered">
                                  
                              </table>
                              <div id="jqGridPager" >
                                  
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
     <!--===========<<<<<<<<<<<<<PANEL DE NUEVO DE USUARIOS START>>>>>>>>>>>>>===========-->
     <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo">

                    </div>
                
                    <div class="card-block">
                        <div id="formupdUser1" style='display:block;'>
                        <form method="POST" id="formNewUser">
                            <div class="row">
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="">No.</label>
                                    <input class="form-control" type="text" id="no" name="no"  placeholder="00000" required>
                            </div>
                                <div class="col-md-6">
                                    <label for="" class="">Nombre:</label>
                                    <input class="form-control" type="text" id="nombre" name="nombre"  placeholder="Nombre" required>
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="">Apellido Paterno:</label>
                                    <input type="text" name="app" id="app" placeholder="Apellido Paterno" class="form-control" required>
                                </div>
                            
                            <!-- </div> -->
                            

                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Apellido Materno: </label>
                                    <input class="form-control" type="text" placeholder="Apellido Materno" id="apm" name="apm" required>
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Puesto: </label>
                                    <input class="form-control" type="text" id="puesto" placeholder="Puesto" name="puesto" required>
                                </div>
                            
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Correo: </label>
                                    <input class="form-control" type="text" id="correo" placeholder="ejemplo@gmail.com" name="correo" required>
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Perfil: </label>
                                    <select id='perfil' name='perfil' class="form-control">
                                        <option value="">Elige una opcion</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Supervisor</option>
                                        <option value="3">Ejecutivo</option>
                                        <option value="4">Empleado</option>
                                        <option value="5">Contabilidad</option>
                                        <option value="6">Tesorería</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Area: </label>
                                    <select id='area' name='area' class="form-control">
                                    <option value="">Elige una opcion</option>
                                    <?php $idarea = ""; include_once str_replace(DS,"/",ROOT.'Controllers/poblarArea.php'); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Oficina: </label>
                                    <!-- <input class="form-control" type="text" id="oficina" placeholder="Oficina" name="oficina"> -->
                                    <select id='oficina' name='oficina' class="form-control" required>
                                        <option value="">Elige una Oficina</option>
                                        <?php include str_replace(DS,"/",ROOT.'Controllers/poblarOficinas.php'); ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="" class="col-form-label">* Contraseña: </label>
                                    <input class="form-control" type="text" id="contrasena" name="contrasena" placeholder="**************" required>
                                </div>
                            <!-- </div> -->
                           
                            <!-- </div> -->
                            <div class="col-12">
                                <br>
                                <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar</button>
                                <button type="button" name='listado' id='listado' class="btn btn-info wow btn-md fadeInDown" data-wow-delay="0.2s"> Listado</button>
                            </div>
                            </div>
                        </form>
                        
                    </div>
                    <div id='formupdUser'></div>
                    </div>
                </div>
                <!-- <br> -->
            </div>
            </div>
        </div>
      <!--===========<<<<<<<<<<<<<PANEL DE NUEVO DE USUARIOS END>>>>>>>>>>>>>===========-->
     <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Usuarios</h5>
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

    <!-- Modal asignacion de gerentes a usuarios -->
    <div class="modal fade" id="modalAsig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Usuarios</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="col-md-12">
            <small> Asignación : [Gerente <i class="fa fa-angle-right" aria-hidden="true"></i> Operador]</small> / <small> Asignación : [Gerente <i class="fa fa-angle-right" aria-hidden="true"></i>Proveedor]</small>
            <br><br>
            <form method="POST" id="formAsignacion">
                <input type="text" id="idusuario" name="idusuario" style="display:none">

                <div class="input-group">
                    <select id='tipoAsignacion' name='tipoAsignacion' class="form-control" required>
                    <option value="">Elige un tipo de Solicitud</option>
                    <option value="1">Operadores</option>
                    <option value="2">Proveedores</option>
                    </select>
                </div>

                <br/>

                <div class="input-group">
                    <select id='gerente' name='gerente' class="form-control">
                    
                    
                    </select>
                    <button class="btn btn-success" type="submit" id="asignar"><i class="fa fa-id-badge" aria-hidden="true"></i></button>
                </div>

            </form>
            <br/>
            <table id="jqGridAsigna" class="table table-bordered"></table>
            <br/>



        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal asignacion de gerentes a usuarios -->

    <!-- Modal asignacion de PERMISOS a usuarios -->
    <div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Usuarios</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="col-md-12">
            <small> Asignación : [Permiso <i class="fa fa-angle-right" aria-hidden="true"></i> Ejecutivo]</small>
            <br><br>
            <form method="POST" id="formPermisos">
                <input type="text" id="idusuariopermiso" name="idusuariopermiso" style="display:none">
                <div class="input-group">
                    <select id='selectPermiso' name='selectPermiso' class="form-control">
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="submit" id="asignar2"> <i class="fa fa-id-badge" aria-hidden="true"></i></button>
                    </span>
                </div>
            </form>
            <br>
            <table id="jqGridPermisos" class="table table-bordered"></table>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal asignacion de PERMISOS a usuarios -->


    <!-- ************** Modal Reasignación ********** -->
    <div class="modal fade" id="modalReAsig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Usuarios</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="col-md-12">
        <!-- <small> Reasignación : [Operador <i class="fa fa-angle-right" aria-hidden="true"></i> Gerente]</small> / <small> Reasignación : [Proveedor <i class="fa fa-angle-right" aria-hidden="true"></i> Gerente]</small> -->
        <small>Reasignación</small>
        

            <br><br>
            <form method="POST" id="formReAsignacion">
                <input type="text" id="idGerente" name="idGerente" style="display:none">
                <table id="jqGridReAsigna" class="table table-bordered"></table>
            <br/>

            <div class="input-group">
                <select id='reasignacionUsuario' name='reasignacionUsuario' class="form-control" required>
                    
                </select>
            </div>


        </div>
        </div>
        <div class="modal-footer">
            <img id="process" style="display:none;" src="../img/loadingimg.gif" height="42" width="42" alt="Loading">&nbsp;<span id="txtprocess" style="color: #0c84e4;display:none;"> Procesando...</span>
            <button id="btnReasignacion" type="submit" class="btn btn-primary" >Aceptar</button>
            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- ***************************************************** -->

    <script>
         $(document).ready(function () {
          $("#jqGrid").jqGrid({
            url:'../Controllers/listarUsuarios.php',
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                
                {label: 'No', name: 'id', width: 10, key: true},    
                {label: 'Nombre', name: 'nombre', width: 20},
                {label: 'Puesto', name: 'puesto', width: 10}, 
                {label: 'Correo', name: 'correo', width: 20},
                {label: 'Perfil', name: 'perfil', width: 10},
                {label: 'Ceco', name: 'ceco', width: 7},
                {label: 'Área', name: 'area', width: 7},
                {label: 'Oficina', name: 'oficina', width: 15},
                {label: 'Tool',name: 'operacion', width: 10, },
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

          //Lista de asignaciones
          $("#jqGridAsigna").jqGrid({
            url:'../Controllers/listarAsignaciones.php',
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                {label: 'Id', name: 'id', width: 4, hidden:true,  key: true},
                {label: 'No Gerente', name: 'noUsuario', width: 10,},
                {label: 'Gerente', name: 'gerente', width: 25,},
                {label: 'Tipo', name: 'tipo', width: 15},
                //{label: 'Oficina', name: 'oficina', width: 10},
                {label: 'Tool', name: 'Tool', width: 7},
            ],
            loadonce: true,
            viewrecords: true,
            width:440,
            height:200,
            rowNum: 2000,
            //multiselect: true
          });


          //Lista de asignaciones -> PIVOTE GERENTE
          $("#jqGridReAsigna").jqGrid({
            url:'../Controllers/listarAsignacionesGerente.php',
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                {label: 'Id', name: 'id', width: 4, hidden:true,  key: true},
                {label: 'No Usuario', name: 'numUsuario', width: 10},
                {label: 'Usuario', name: 'usuario', width: 25,},
                {label: 'Tipo', name: 'tipo', width: 10,},
            ],
            loadonce: true,
            viewrecords: true,
            width:440,
            height:200,
            rowNum: 2000,
            multiselect: true
          });
      });
    </script>
    <script type="text/javascript">
        $("#nuevo").click(function(){
            $("#formupdUser1").css('display','block');
            $("#formupdUser").css('display','none');
            $("#collapseOne").collapse('hide');
            $("#collapseTwo").collapse('show');
        });
    </script>
    <!--===========<<<<<<<<<<FUNCION DE GUARDAR USUARIO START>>>>>>>>===========-->
    <script type="text/javascript">
        $("#formNewUser").on("submit", function(e){
            $('#perfil').prop('disabled', false);
                e.preventDefault();
                var formData = new FormData(document.getElementById("formNewUser"));
                $.ajax({
                    url: "../Controllers/agregaUsuario.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                        if(res==1){
                            $('#msg').text('SE AGREGO CON EXITO EL USUARIO');
                            $("#modalMsg").modal('show');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }else if(res == 2){
                            $('#msg').text('Error: No se pudo registrar el usuario, el número de usuario ya existe');
                            $("#modalMsg").modal('show');
                            
                        }else if(res == 0){
                            $('#msg').text('Error: No se pudo registrar el usuario, favor de revisar la informacion e intentarlo nuevamente');
                            $("#modalMsg").modal('show');

                        }

                     //swal('Muy Bien!', 'Evento Agregado!', 'success');
                       //  setTimeout(function () {
                         //   location.reload();
                        //}, 1000);
                    
                    });
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });

//##################Formulario de asignación de gerente

$('#formAsignacion').submit(function(e) {
    e.preventDefault();
    var data = $(this).serializeArray();
    //data.push({name: 'tag', value: 'login'});
    $.ajax({
        method: "POST",
        url: "../Controllers/asignarGerente.php",
        data: data
    })
    .done(function(respuesta) {

        if(respuesta == 1){
            var idusuario = $("#idusuario").val();
           
            $('#jqGridAsigna').jqGrid('setGridParam',{url:'../Controllers/listarAsignaciones.php?idusuario='+idusuario, datatype:'json',type:'GET'}).trigger('reloadGrid');
            
        
        }else if(respuesta == 3){
            //Error no se pudo llevar a cabo la Asignación
            $("#modalAsig").modal('hide');
            $('#msg').text('Error: No se pudo realizar la asignación, ya existe un gerente con ese tipo de solicitud');
            $("#modalMsg").modal('show');

        }
            
    });
    
});
//#########################################################

    </script>
    <!--===========<<<<<<<<<<FUNCION DE GUARDAR USUARIO END>>>>>>>>===========-->
<!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO START>>>>>>===========-->
    <script type="text/javascript">
        function editar(key){
               $.ajax({
                     url: "../Controllers/buscaUsuario.php",
                     type: "POST",
                     dataType: "html",
                     data: "id=" + key,
                     success:  function (response) {
                        $("#formupdUser").html(response);
                     }
                    });
                $("#collapseOne").collapse('hide');
                $("#collapseTwo").collapse('show');
                $("#formupdUser1").css('display','none');
                $("#formupdUser").css('display','block');
              //  alert(rowKey);   
     }
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO END>>>>>>===========-->
    <!--===========<<<<<<<<<<FUNCION DE ELIMINAR USUARIO START>>>>>>===========-->
    <script type="text/javascript">
        function eliminar(key){
                $.ajax({
                     url: "../Controllers/eliminaUsuario.php",
                     type: "POST",
                     dataType: "html",
                     data: "id=" + key,
                     success:  function (response) {
                        if(response==1){
                            $('#msg').text('SE ELIMINO CORRECTAMENTE EL USUARIO');
                            $("#modalMsg").modal('show');
                            $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarUsuarios.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
                            // setTimeout(function () {
                            //     location.reload();
                            // }, 1000);

                        }else{
                            $('#msg').text('Error: Ocurrio un problema con la eliminacion de usuario, ponganse en contacto con el administrador del sistema.');
                            $("#modalMsg").modal('show');
                        }
                        
                     }
                    });
        }

        function asignaciones(idusuario){
            $("#idusuario").val(idusuario);
            listarGerenteOficina(idusuario);
            $('#jqGridAsigna').jqGrid('setGridParam',{url:'../Controllers/listarAsignaciones.php?idusuario='+idusuario, datatype:'json',type:'GET'}).trigger('reloadGrid');
            $("#modalAsig").modal('show');
        }

        function eliminarAsignacion(key){
                $.ajax({
                     url: "../Controllers/eliminaAsignacion.php",
                     type: "POST",
                     dataType: "html",
                     data: "id=" + key,
                     success:  function (response) {
                        if(response==1){
                            var idusuario = $("#idusuario").val();
                            $('#jqGridAsigna').jqGrid('setGridParam',{url:'../Controllers/listarAsignaciones.php?idusuario='+idusuario, datatype:'json',type:'GET'}).trigger('reloadGrid');
                        }else{
                            //Error eliminación de asignación
                        }
                        
                     }
                    });
        }
            $("#listado").click(function(){
            $("#formNewUser")[0].reset();
            $("#collapseTwo").collapse('hide');
            $("#collapseOne").collapse('show');
        });

        function permisos(idusuario){

            $("#idusuariopermiso").val(idusuario);
            $.ajax({
            url: '../Controllers/poblarPermisos.php',
            type: 'post',
            data: {idUsuario:idusuario},
            dataType: 'json',
            success:function(response){
                var len = response.length;

                $("#selectPermiso").empty();
                $("#selectPermiso").append("<option value='0'>Selecciona un Permiso</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var nombreTipo = response[i]['nombreTipo'];
                    
                    $("#selectPermiso").append("<option value='"+id+"'>"+ nombreTipo +"</option>");
                }
            }
            });
            listadoCuentas(idusuario);
            $("#modalPermisos").modal('show');
        }
        function listadoCuentas(idusuario)
        {
            $('#jqGridPermisos').jqGrid('setGridParam',{url:'../Controllers/listarPermisos.php?idusuario='+idusuario, datatype:'json',type:'GET'}).trigger('reloadGrid');
            $("#jqGridPermisos").jqGrid({
            url:'../Controllers/listarPermisos.php?idusuario='+idusuario,
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                {label: 'Id', name: 'id', width: 4, hidde:true},
                {label: 'nombreTipo', name: 'nombreTipo', width: 25, key: true},
                {label: 'Tool', name: 'Tool', width: 7, key: true},
            ],
            loadonce: true,
            viewrecords: true,
            width:440,
            height:200,
            rowNum: 2000
          });
        }

        function eliminarpermiso(idpermiso,idusuario)
        {

                $.ajax({
                method: "POST",
                url: "../Controllers/eliminaPermiso.php",
                data: { idpermiso: idpermiso, idusuario: idusuario }
                })
                .done(function(respuesta) {
                    if(respuesta == 1)
                    {
                        poblarPermisosSelect(idusuario);
                        listadoCuentas(idusuario);
                    }
                });
        }

        function poblarPermisosSelect(idusuario)
        {
            $.ajax({
        url: '../Controllers/poblarPermisos.php',
        type: 'post',
        data: {idUsuario:idusuario},
        dataType: 'json',
        success:function(response){
            var len = response.length;

            $("#selectPermiso").empty();
            $("#selectPermiso").append("<option value='0'>Tipo de Solicitud</option>");
            for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var nombreTipo = response[i]['nombreTipo'];
                
                $("#selectPermiso").append("<option value='"+id+"'>"+ nombreTipo +"</option>");

            }
        }
    });
        }


        $(document).ready(function() 
        {
            $('#formPermisos').submit(function(e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                //data.push({name: 'tag', value: 'login'});
                $.ajax({
                    method: "POST",
                    url: "../Controllers/asignarPermiso.php",
                    data: data
                })
                .done(function(respuesta) {
                        if(respuesta == 1)
                        {
                            var idusuario = $("#idusuariopermiso").val();
                            poblarPermisosSelect(idusuario);
                            listadoCuentas(idusuario);
                        }
                    });
                
            })
        })
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO END>>>>>>>=========-->


<script>
//**********Función reasignación*************
function reasignaciones(idGerente){

    $("#idGerente").val(idGerente);
    listarGerenteOficina(idGerente);
    $("#modalReAsig").modal('show');
    $('#jqGridReAsigna').jqGrid('setGridParam',{url:'../Controllers/listarAsignacionesGerente.php?idGerente='+idGerente, datatype:'json',type:'GET'}).trigger('reloadGrid');
}




$('#formReAsignacion').submit(function(e) {

    $('#btnReasignacion').prop('disabled', true);
    $("#process").css("display", "inline");
    $("#txtprocess").css("display", "inline");

    e.preventDefault();
    var grid = $("#jqGridReAsigna");
    var seleccionados = grid.getGridParam("selarrrow");
    var arraySeleccion = new Array();


    for (var i = 0; i < seleccionados.length; i++) {
        arraySeleccion[i] = seleccionados[i];
    }
    console.log(arraySeleccion);



    var data = $(this).serialize() + "&arraySeleccion=" + JSON.stringify(arraySeleccion);

    if(seleccionados.length > 0)
    {
            $.ajax({
            method: "POST",
            url: "../Controllers/reasignarUsuario.php",
            data: data,
            })
            .done(function(respuesta) {
                if(respuesta == 1){
                    var idGerente = $("#idGerente").val();
                    $('#jqGridReAsigna').jqGrid('setGridParam',{url:'../Controllers/listarAsignacionesGerente.php?idGerente='+idGerente, datatype:'json',type:'GET'}).trigger('reloadGrid');
                
                }
                $('#btnReasignacion').prop('disabled', false);
                $("#process").css("display", "none");
                $("#txtprocess").css("display", "none");
                
            });

    }else
    {
        $('#msg').text('¡Seleccione un Elemento!');
        $("#modalReAsig").modal('hide');
        $("#modalMsg").modal('show');
        $('#btnReasignacion').prop('disabled', false);
        $("#process").css("display", "none");
        $("#txtprocess").css("display", "none");
    }
    
});






//*******************************************

//Funcion poblar gerentes correspondientes a la oficina del usuario
function listarGerenteOficina(idUsuario){
    
 $("#gerente").html("");
 $("#reasignacionUsuario").html("");


        $.ajax({
        method: "POST",
        url: "../Controllers/poblarGerentesOficina.php",
        data: {id_usuario : idUsuario},
        dataType: 'json',
        
        }).done(function(res) {

            $("#gerente").append("<option value=''>Selecciona un Solicitador</option>");
            $("#reasignacionUsuario").append("<option value=''>Selecciona un [Gerente o Administrador]</option>");
            $.each(res, function(key, item) {
                $("#gerente").append("<option value='"+item.id+"|"+item.nombre + " "+item.apellidoPaterno+"'>"+item.nombre + " "+item.apellidoPaterno+" "+item.apellidoMaterno+"</option>");
            });

            $.each(res, function(key, item) {
                $("#reasignacionUsuario").append("<option value='"+item.id+"|"+item.nombre + " "+item.apellidoPaterno+"'>"+item.nombre + " "+item.apellidoPaterno+" "+item.apellidoMaterno+"</option>");
            });

        });

}

</script>

<script>
$(document).ready(function() {

    var perfil = "<?php echo $_SESSION['_prol']; ?>";

    if(perfil == 2){

        $('#perfil').prop('readonly', true);
        $('#perfil').prop('disabled', true);
        $("#perfil").val(3);

    }
});
</script>








</body>
</html>