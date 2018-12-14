<?php
    include_once '../app/config.php'; 
    include_once str_replace(DS, "/", ROOT . 'Models/banco.php'); #Modelo bancos   

    if(!$_SESSION['_pid']){
        header('Location: '.URL.'login.php?e=n');
    }
    $idVendedor = $_SESSION['_pid'];
    $nombre     = $_SESSION['_pname'];
    $nombreAll  = $_SESSION['_pnamefull'];

    $banco = new Banco();
    $bancos = $banco->listarBancos();

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="" type="image/vnd.microsoft.icon" />
    <title>Villa Tours | Proveedores</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css"> -->
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
            /* font-size: 17px; */
        }
        .rojo:hover{
            color: #d9534f;
            /* font-size: 17px; */
        }
        .azul{
            color: #0275d8;
            /* font-size: 17px; */
        }
        .rojo{
            color: #d9534f;
            /* font-size: 17px; */
        }
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
         
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 50px rgba(0,0,0,0.3); /* 105,106,110 */
            border-radius: 0px;
        }
         
        ::-webkit-scrollbar-thumb {
            border-radius: 30px;
            -webkit-box-shadow: inset 0 0 20px rgba(21, 67, 96);
        }
        /* .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 20px;
            margin-top: -8px;
            display: inine-block;
            font-size: 15px;
        }
        .jqgrow{
            font-size: 14px;
        }
        .ui-jqgrid-labels{
            background:#E5E8E8;
        } */

        .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 25px;
        }
        label.error {
        display: none;
        color: red;
        }
        label.errorcuenta{
        display: none;
        color: red;
        }
    </style>
    
</head>
<body>
   <?php
   include_once "../layout.php";
   ?>
    <div class="container-fluid">
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE PROVEEDORES START>>>>>>>>>>>>>===========-->  
     <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                    <h6 style="float:left">Administración / Proveedores</h6>
                    </div>
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-block">
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary btn-md" name="nuevop" id="nuevop"><i class="fa fa-wpforms" aria-hidden="true"></i> Nuevo Proveedor</button>
                        </div>
                        <div class="col-sm-2">
                            <!-- <select class="form-control" id="tipo_proveedor" name = "tipo_proveedor">
                                <option value = "todos" selected>Visualizar Todos</option>
                                <option value = "nuevos" >Pendientes por Autorizar</option>
                                <option value = "Comisiones" >Comisiones</option>
                                <option value = "Operaciones" >Operaciones</option>                                
                                <option value = "Servicios" >Servicios</option>
                                <option value = "Impuestos" >Impuestos</option>
                                <option value = "BSP" >BSP</option>
                            </select> -->
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-md-4">
                            <!-- <div class="input-group">
                            <input type="text" onChange="buscaProveedor();" name="nameProveedor" id="nameProveedor" class="form-control form-control-md" placeholder="buscar proveedor">
                            <span class="input-group-btn"> 
                                <button type="button" onclick="buscaProveedor();" class="btn btn-primary btn-md"  title="Buscar Facturas" id="btn_bfc" name="btn_bfc" value="">
                                    <i class="fa fa-search" aria-hidden="true"></i> 
                                </button>
                            </span>
                            </div> -->
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
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE PROVEEDORES END>>>>>>>>>>>>>===========-->
     <!--===========<<<<<<<<<<<<<PANEL DE NUEVO DE PROVEEDORES START>>>>>>>>>>>>>===========-->
     <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo">
                    </div>                
                    <div class="card-block">
                        <div id="formupdProv1" style='display:block;'>
                        <form method="POST" id="formNewProv" enctype="multipart/form-data">
                            <div class="row">
                                
                                <input class="form-control" type="hidden" id="numproveedor" name="numproveedor" placeholder="00000">

                            
                                <div class="col-md-6">
                                    <label for="" class="">RFC | TAX ID</label>
                                    <input type="text" name="rfc" id="rfc" placeholder="RFC | TAX ID" class="form-control" required>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Razón Social: </label>
                                    <input class="form-control" type="text" placeholder="Razón Social" id="razonsocial" name="razonsocial" required>
                                </div>
                            
                                <div class="col-md-6">
                                        <label for="" class="col-form-label">Alias Comercial: </label>
                                        <input class="form-control" type="text" id="aliascomercial" placeholder="Alias Comercial" name="aliascomercial" required>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Direccion: </label>
                                    <input class="form-control" type="text" id="direccion" placeholder="Direccion" name="direccion" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="" class="col-form-label">Correo: </label>
                                    <input class="form-control" type="email" id="email" placeholder="ejemplo@mail.com" name="email">
                                </div>
                            
                                <div class="col-md-3">
                                    <label for="" class="col-form-label">Contacto: </label>
                                    <input class="form-control" type="text" id="contacto" placeholder="Contacto" name="contacto" required>
                                </div>
                            
                                <div class="col-md-3">
                                    <label for="" class="col-form-label">Teléfono: </label>
                                    <input class="form-control" type="text" id="tel1" placeholder="Teléfono" name="tel1">
                                </div>
                            
                                <div class="col-md-3">
                                    <label for="" class="col-form-label">Teléfono 2: </label>
                                    <input class="form-control" type="text" id="tel2" placeholder="Teléfono 2" name="tel2">
                                </div>
                                                        
                                <div class="col-md-6">                                 
                                </div>
                            
                                <div class="col-md-2">
                                        <label for="" class="col-form-label">Nacionalidad: </label>
                                        <select id='comunidad' name='comunidad' class="form-control" required>
                                            <option value="">Selecciona una Opción</option>
                                            <option value="1">Nacional</option>
                                            <option value="2">Extranjero</option>                                        
                                        </select>
                                </div>
                            
                                <div class="col-md-2">
                                        <label for="" class="col-form-label">País: </label>
                                        <select id='pais' name='pais' class="form-control" required>                                                                                                                     
                                        </select>
                                </div>
                            
                                <div class="col-md-2">
                                        <label for="" class="col-form-label">C.P.: </label>
                                        <input class="form-control" type="text" id="cp" placeholder="CP" name="cp">
                                </div>
                            
                                <div class="col-md-6">
                                        <br>
                                        <label for="" class="col-form-label">Carátula Bancaria: </label>
                                        <input class="btn btn-info btn-sm" type="file" id="filecaratula" name="filecaratula" accept=".pdf,.png,.jpg">
                                        <small class="form-text text-muted">Archivos requeridos(.pdf|.png|.jpg)</small>                           
                                </div>
                            
                                <div class="col-md-6">
                                        <br>
                                        <label for="" class="col-form-label">Cédula Fiscal: </label>
                                        <input class="btn btn-info btn-sm" type="file" id="filecedula" name="filecedula" accept=".pdf,.png,.jpg">
                                        <small class="form-text text-muted">Archivos requeridos(.pdf|.png|.jpg)</small>
                                </div>
                             
                                <div class="col-md-6" id="divaba">
                                    <label for="" class="col-form-label">ABA: </label>
                                    <input class="form-control" type="text" id="aba" placeholder="ABA" name="aba" >
                                </div>
                                
                                <div class="col-md-6" id="divswift">
                                    <label for="" class="col-form-label">SWIFT: </label>
                                    <input class="form-control" type="text" id="swift" placeholder="SWIFT" name="swift" >
                                </div>
                            
                                <div class="col-12">
                                    <br>
                                    <button id="btnNewProv"  type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar</button>
                                    &nbsp;&nbsp;&nbsp;<img id="proceso" style="display:none;" src="../img/loadingimg.gif" height="42" width="42" alt="Loading">&nbsp;<span id="txtproceso" style="color: #0c84e4;display:none;"> Creando...</span>
                                    <button type="button" name='listadoproveedor' id='listadoproveedor' class="btn btn-default wow btn-md fadeInDown" data-wow-delay="0.2s"> Listado</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    <div id='formupdProv'></div>
                    </div>
                </div>
                <!-- <br> -->
            </div>
            </div>
        </div>
      <!--===========<<<<<<<<<<<<<PANEL DE NUEVO DE PROVEEDORES END>>>>>>>>>>>>>===========-->
     <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Proveedores</h5>
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
    <!-- ===========<<<<<<<<<<<<< MODAL CUENTAS>>>>>>>>================-->
    <div class="modal fade bd-example-modal-lg" id="modalCuentas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Cuentas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <button type="button" class="btn btn-primary" id="cuentaNueva" onclick="crearCuenta(this.value)" data-toggle="collapse" data-target="#collapseFormCuentas">Agregar Cuenta</button>
        
            <div id='msgCuentas'></div>
            <div id="collapseListaCuentas" class="collapse" role="tabpanel" aria-labelledby="headingOne">
            <!-- <div class="card-block">                     -->
                <!-- <div class="row">
                <div class='col-md-12'> -->
                <table id="jqGridCuentas" class="table table-bordered">
                    
                </table>
                <div id="jqGridPagerCuentas" >
                    
                </div>
                <!-- </div>
                </div> -->
            <!-- </div> -->
            </div>
            <div  id="collapseFormCuentas" class="collapse show" role="tabpanel" aria-labelledby="headingTwo">
            <div class="card-block">
            <form method="POST" id="formNuevaCuenta">
                <div class="row">
                    <input class="form-control" type="hidden" id="idproveedor" placeholder="Banco" name="idproveedor">
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Banco: </label>
                        <!-- <input class="form-control" type="text" id="nombreBanco" placeholder="Banco" name="nombreBanco" required> -->
                        <select class="form-control" id="nombreBanco" name="nombreBanco" onchange="poblarDatosBanco();" required>
                            <option value="">Elige una opcion</option>
                            <?php while($rows = mysqli_fetch_array($bancos)){ ?>
                            <option value="<?= $rows['banco']; ?>"><?= $rows['banco'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Codigo Santander: </label>
                        <input class="form-control" type="text" id="codigoSantander" placeholder="Codigo Santander" name="codigoSantander" >
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Clave SAT: </label>
                        <input class="form-control" type="text" id="claveSAT" placeholder="Clave SAT" name="claveSAT" >
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Divisa: </label>
                        <select class="form-control" id="divisa" name="divisa">
                            <option value="">Elige una opcion</option>
                            <option value="AUD">AUD</option>
                            <option value="BRL">BRL</option>
                            <option value="CAD">CAD</option>
                            <option value="EUR">EUR</option>
                            <option value="FJD">FJD</option>
                            <option value="GBP">GBP</option>
                            <option value="JPY">JPY</option>
                            <option value="MXN">MXN</option>
                            <option value="NZD">NZD</option>
                            <option value="SGD">SGD</option>
                            <option value="THB">THB</option>
                            <option value="USD">USD</option>
                            <option value="ZAR">ZAR</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Número Cuenta: </label>
                        <label class='errorcuenta'>Cuenta Inválida</label>
                        <input class="form-control" type="text" id="numCuenta" placeholder="Número Cuenta" name="numCuenta" onkeypress="return isNumberKey(event)" >
                        <small id="smallc" class="form-text text-muted">10 u 11 Dígitos (Capture Sin Espacios)</small>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="col-form-label">Clabe Interbancaria: </label>
                        <label class='error'>Clabe Inválida</label>
                        <input class="form-control" type="text" id="clabeInter" name="clabeInter" placeholder="Clabe Intebancaria" onkeypress="return isNumberKey(event)"   required title="Ingrese 15,16 o 18 dígitos (Capture Sin Espacios)" >
                        <small id="smallcbi" class="form-text text-muted">15,16 o 18 Dígitos (Capture Sin Espacios)</small>
                    </div>
                    
                    <div class="col-md-12"><hr><small><i class="fa fa-arrow-right" aria-hidden="true"></i> Datos Opcionales </small></div>

                    <div class="col-md-3">
                        <!-- <label for="" class="col-form-label">Sucursal: </label> -->
                        <input class="form-control" type="hidden" id="sucursal" name="sucursal">
                    </div>
                    <div class="col-md-3">
                        <!-- <label for="" class="col-form-label">Convenio CIE: </label> -->
                        <input class="form-control" type="hidden" id="conveniocie" name="conveniocie">
                    </div>
                    <div class="col-md-3">
                        <!-- <label for="" class="col-form-label">Referencia CIE(1): </label> -->
                        <input class="form-control" type="hidden" id="referenciacie1" name="referenciacie1">
                    </div>
                    <div class="col-md-3">
                        <!-- <label for="" class="col-form-label">Referencia CIE(2): </label> -->
                        <input class="form-control" type="hidden" id="referenciacie2" name="referenciacie2">
                    </div>
                   
                    <div class="col-md-6">
                        <div id="loadGif"></div>
                    </div>
                    <div class="col-md-6" align="right">               
                        <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar Cuenta</button>               
                    </div>
                </div>
            </div>
            </form>                    
            </div>
        </div>
        <!--<button type="button" class="btn btn-primary">Guardar</button>-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Modal -->

    <script>
         $(document).ready(function () {
          $("#jqGrid").jqGrid({
            url:'../Controllers/listarProveedores.php',
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                
                {label: 'No. Prov.', name: 'id', width: 10},
                //{label: 'No. Prov.', name: 'numproveedor', width: 10},
                {label: 'RFC | TAXID', name: 'rfc', width: 20 },
                {label: 'Razón Social', name: 'razonsocial', width: 30},
                {label: 'Alias Comercial', name: 'aliascomercial', width: 30},
                {label: 'País', name: 'pais', width: 12},               
                {label: 'Dirección', name: 'direccion', width: 25},
                {label: 'C.P.', name: 'cp', width: 10},
                {label: 'Correo', name: 'email', width: 20},
                {label: 'Contacto', name: 'contacto', width: 25},
                {label: 'Teléfono', name: 'tel1', width: 20},
                {label: 'Tipo', name: 'tipo', width: 15, hidden:true},
                //{label: 'Teléfono 2', name: 'tel2', width: 20},
                {label: 'Opciones',name: 'operacion', width: 20, },
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
    <script type="text/javascript">
        $("#nuevop").click(function(){
            $("#formupdProv1").css('display','block');
            $("#formupdProv").css('display','none');
            $("#collapseOne").collapse('hide');
            $("#collapseTwo").collapse('show');
        });
    </script>
    <!--===========<<<<<<<<<<FUNCION DE GUARDAR PROVEEDOR START>>>>>>>>===========-->
    <script type="text/javascript">
        $("#formNewProv").on("submit", function(e){
            e.preventDefault();
    //var data = $(this).serializeArray();
    var formData = new FormData(document.getElementById("formNewProv"));
    //data.push({name: 'tag', value: 'login'});

                $('#btnNewProv').prop('disabled', true);
                $("#proceso").css("display", "inline");
                $("#txtproceso").css("display", "inline");

                $.ajax({
                url: "../Controllers/validacionesProveedor.php",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
                }).done(function(respuesta) {

                if(respuesta == "1"){


                        $.ajax({
                        url: "../Controllers/agregaProveedor.php",
                        type: "POST",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                        }).done(function(res){

                        if(res== "1"){

                            $('#msg').text('SE AGREGO CON EXITO EL PROVEEDOR');
                            $("#modalMsg").modal('show');
                            //return false();
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }else if(res == "0"){
                            $("#proceso").css("display", "none");
                            $("#txtproceso").css("display", "none");
                            $('#btnNewProv').prop('disabled', false);

                            $('#msg').text('Error: No se pudo registrar el proveedor, favor de revisar la informacion e intentarlo nuevamente');
                            $("#modalMsg").modal('show');
                        }else if(res == "2"){
                            $("#proceso").css("display", "none");
                            $("#txtproceso").css("display", "none");
                            $('#btnNewProv').prop('disabled', false);


                            $('#msg').text('Usuario Registrado, Sin Embargo Los archivos no son compatibles, por favor seleccione archivos con extensión (.pdf)');
                            $("#modalMsg").modal('show');
                            setTimeout(function () {
                                location.reload();
                            }, 4000);
                        }else if(res == "3"){
                            $("#proceso").css("display", "none");
                            $("#txtproceso").css("display", "none");
                            $('#btnNewProv').prop('disabled', false);


                            $('#msg').text('Error: No se pudo registrar el proveedor, el número de proveedor ya existe, intente con un número de Proveedor distinto');
                            $("#modalMsg").modal('show');
                        }

                     //swal('Muy Bien!', 'Evento Agregado!', 'success');
                       //  setTimeout(function () {
                         //   location.reload();
                        //}, 1000);
                    
                    });

                }else if(respuesta == "2"){
                $("#proceso").css("display", "none");
                $("#txtproceso").css("display", "none");
                $('#btnNewProv').prop('disabled', false);

                $("#modalProvier").modal('hide');
                $('#msg').text('Lo sentimos, ya existe un proveedor con la razón social ingresada.');
                $("#modalMsg").modal('show');

                }else if(respuesta == "3"){
                    $("#proceso").css("display", "none");
                    $("#txtproceso").css("display", "none");
                    $('#btnNewProv').prop('disabled', false);

                    $("#modalProvier").modal('hide');
                    $('#msg').text('Lo sentimos, ya existe un proveedor con el rfc ingresado.');
                    $("#modalMsg").modal('show');
                }

            });

        });
    </script>
    <!--===========<<<<<<<<<<FUNCION DE GUARDAR PROVEEDOR END>>>>>>>>===========-->
<!--===========<<<<<<<<<<FUNCION DE MODIFICAR PROVEEDOR START>>>>>>===========-->
    <script type="text/javascript">
        function editar(key){
               $.ajax({
                     url: "../Controllers/buscaProveedor.php",
                     type: "POST",
                     dataType: "html",
                     data: "id=" + key,
                     success:  function (response) {
                        $("#formupdProv").html(response);
                     }
                    });
                $("#collapseOne").collapse('hide');
                $("#collapseTwo").collapse('show');
                $("#formupdProv1").css('display','none');
                $("#formupdProv").css('display','block');
              //  alert(rowKey);   
     }
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MODIFICAR PROVEEDOR END>>>>>>===========-->
    <!--===========<<<<<<<<<<FUNCION DE ELIMINAR PROVEEDOR START>>>>>>===========-->
    <script type="text/javascript">
        function eliminar(key){
                $.ajax({
                     url: "../Controllers/eliminaProveedor.php",
                     type: "POST",
                     dataType: "html",
                     data: "id=" + key,
                     success:  function (response) {
                        if(response==1){
                            $('#msg').text('SE ELIMINO CORRECTAMENTE EL PROVEEDOR');
                            $("#modalMsg").modal('show');
                            $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarProveedores.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
                            // setTimeout(function () {
                            //     location.reload();
                            // }, 1000);

                        }else{
                            $('#msg').text('Error: Ocurrio un problema con la eliminacion de proveedor, ponganse en contacto con el administrador del sistema.');
                            $("#modalMsg").modal('show');
                        }
                        
                     }
                    });
            
        }
    </script>
    <!--===========<<<<<<<<<<FUNCION DE ELIMINAR PROVEEDOR END>>>>>>===========-->
    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO START>>>>>>>=========-->
    <script type="text/javascript">
        $("#listadoproveedor").click(function(){
            $("#formNewProv")[0].reset();
            $("#collapseTwo").collapse('hide');
            $("#collapseOne").collapse('show');
        })
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO END>>>>>>>=========-->

    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR CUENTAS START>>>>>>>=========-->
    <script type="text/javascript">
       function cuentas(key)
       {
        $.ajax({
                    method: "POST",
                    url: "../Controllers/consultaNumProveedor.php",
                    data: { id: key},
                     
                }).done(function (respuesta) 
                {   
                    $("#cuentaNueva").val(key);
                    listadoCuentas(key);                   
                    //$('#msgCuentas').text('Proveedor: ' + respuesta);
                    $("#modalCuentas").modal('show');

                });           
       }


       function listadoCuentas(key)
       {
        $("#collapseFormCuentas").collapse('hide');
        $("#collapseListaCuentas").collapse('show');
        $('#jqGridCuentas').jqGrid('setGridParam',{url:'../Controllers/listarCuentas.php?id=' + key , datatype:'json',type:'GET'}).trigger('reloadGrid');
        $("#jqGridCuentas").jqGrid({
                        url:'../Controllers/listarCuentas.php?id=' + key,
                        datatype: "json",
                        styleUI : 'Bootstrap',
                        colModel: [
                            {label: 'Id', name: 'id', width: 35, key: true, hidden:true},
                            {label: 'Banco', name: 'banco', width: 150 },
                            {label: 'Número Cuenta', name: 'num_cuenta', width: 80},
                            {label: 'Clabe Interbancaria', name: 'clabeinter', width: 180},
                            {label: 'Clabe SAT', name: 'claveSAT', width: 90},
                            {label: 'Cod Santander', name: 'codSantader', width: 100},
                            {label: 'Divisa', name: 'divisa', width: 70},
                            {label: 'Op.',name: 'operacion', width: 50 },
                        ],
                        loadonce: true,
                        viewrecords: true,
                        scroll :true,
                        autowidth: true
                        
                });
                
                
               
       }
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR CUENTAS END>>>>>>>=========-->


    <!--===========<<<<<<<<<<FUNCION DE ELIMIANR CUENTAS START>>>>>>>=========-->
    <script type="text/javascript">
    function eliminarCuenta(keyCuenta,keyProv)
    {
        $.ajax({
                method: "POST",
                url: "../Controllers/eliminaCuenta.php",
                data: { id: keyCuenta}
             })
            .done(function (response) {

                if(response == 1){
                            $("#modalCuentas").modal('hide');
                            $('#msg').text('SE ELIMINO CORRECTAMENTE LA CUENTA');                            
                            $("#modalMsg").modal('show');                            
                            $('#jqGridCuentas').jqGrid('setGridParam',{url:'../Controllers/listarCuentas.php?id=' + keyProv , datatype:'json',type:'GET'}).trigger('reloadGrid');
                            

                        }else{
                            $("#modalCuentas").modal('hide');
                            $('#msg').text('Error: Ocurrio un problema con la eliminacion de la cuenta, ponganse en contacto con el administrador del sistema.');                            
                            $("#modalMsg").modal('show');
                        }               
            });
    }
    </script>

    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR CUENTAS END>>>>>>>===========-->
<!--===========<<<<<<<<<<FUNCION DE CREAR CUENTAS START>>>>>>>=========-->
    <script type="text/javascript">

   function crearCuenta(idprov)//al proveedor se le asigna una cuenta segun su id en el listado
    {
        $("#idproveedor").val(idprov);
        //alert(idprov);
        //cuentasprov('',idprov);
    }
    $('#formNuevaCuenta').submit(function cuentasprov(e) {

        $('label.error').hide();
        $('label.errorcuenta').hide();
        var clabe   = $("#clabeInter").val();
        var cuenta  = $("#numCuenta").val();

        if(!validarCuenta(cuenta)){
            e.preventDefault(); //stop default action
            $('label.errorcuenta').show();

        }else if(!validarClabe(clabe)){
            e.preventDefault(); //stop default action
            $('label.error').show();
            
        }else{

            $("#loadGif").html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>');
            var idprov = $("#idproveedor").val();           
            e.preventDefault();
            var data = $(this).serialize() + "&envioCorreo=no";
            $.ajax({
                method: "POST",
                url: "../Controllers/agregaCuenta.php",
                data: data
            }).done(function(respuesta) {
                $("#loadGif").html("");

                if(respuesta == 1){
                    $("#formNuevaCuenta")[0].reset();
                    $("#collapseFormCuentas").collapse('hide');
                    //$('#msg').text('SE AGREGO CON EXITO LA CUENTA');
                    //$("#modalCuentas").modal('hide');
                    //$("#modalMsg").modal('show');
                    //listadoCuentas(idprov)
                    $('#jqGridCuentas').jqGrid('setGridParam',{url:'../Controllers/listarCuentas.php?id=' + idprov , datatype:'json',type:'GET'}).trigger('reloadGrid');
                    //return falase();
                    // setTimeout(function () {
                    //     location.reload();
                    // }, 1000);
                }else{
                    $("#modalCuentas").modal('hide'); 
                    $('#msg').text('Error: No se pudo registrar la cuenta, favor de revisar la información e intentarlo nuevamente');
                    $("#modalMsg").modal('show');
                }  
            });
            
        }

       

        
    });

function validarCuenta(cuenta){

retorno = false;
 var longitudCuenta  = cuenta.length;

if(cuenta != ""){

    if(longitudCuenta == 10 || longitudCuenta == 11)
    {
        retorno = true;

    }else{
        retorno = false;
    
    }
}else{

    retorno = true;
}

return retorno;

}

function validarClabe(clabe){

retorno = false;
var longitudClabe   = clabe.length; 


if(longitudClabe == 15 || longitudClabe == 16 || longitudClabe == 18)
{
    retorno = true;

}else{
    retorno = false;
}

return retorno;

}
    

    

    
    </script>
<!--===========<<<<<<<<<<FUNCION DE CREAR CUENTAS END>>>>>>>=========-->

<!--===========<<<<<<<<<<FUNCION MOSTRAR ARCHIVOS START>>>>>>>=========-->
<script type="text/javascript">
function archivos(key,numProveedor,archivoCaratula,archivoCedula)
{   
    $("#cedulaTab").removeClass('active');
    $("#caratulaTab").addClass('active');
    $("#embedCedula").collapse('hide'); 
    var rutaCedula = 'docs/' + numProveedor + '/' + archivoCedula;
    var rutaCaratula = 'docs/' + numProveedor + '/' + archivoCaratula;    
    $("#modalArchivo").modal('show');

    if (archivoCaratula == "") {
        $("#caratulaTab").val("");
        $("#embedCaratula").attr("src",""); 
    }else{
        $("#caratulaTab").val(rutaCaratula);
        $("#embedCaratula").attr("src",rutaCaratula); 
    }
    if(archivoCedula == ""){
        $("#cedulaTab").val("");

    }else{
        $("#cedulaTab").val(rutaCedula);
    }

    $("#embedCaratula").collapse('show');
    
    
}
</script>
<script>
function archivoCedula(archivoCedula)
{    
    $("#embedCedula").attr("src",archivoCedula);
    $("#embedCaratula").collapse('hide');
    $("#embedCedula").collapse('show');
}
function archivoCaratula(archivoCaratula)
{    
    $("#embedCaratula").attr("src",archivoCaratula);
    $("#embedCedula").collapse('hide');
    $("#embedCaratula").collapse('show');
}

</script>
<!--===========<<<<<<<<<<FUNCION MOSTRAR ARCHIVOS END>>>>>>>=========-->

<!-- ===========<<<<<<<<<<<<< MODAL ARCHIVOS START>>>>>>>>================-->
    <div class="modal fade" id="modalArchivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Proveedores | Archivos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id='msgArchivo'></div>
            

                <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab"  href="#" id="caratulaTab" onclick="archivoCaratula(this.value);">Archivo Carátula</a>
                    <!-- <embed src="docs\12345porveedor\CEDULA.pdf" frameborder="0" width="100%" height="400px"> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#" id="cedulaTab" onclick="archivoCedula(this.value);">Archivo Cédula</a>
                </li>                
                </ul>

        <div style="text-align: center;">
            <embed  id="embedCaratula"  frameborder="0" width="100%" height="400px">
        </div>

        <div style="text-align: center;">
            <embed  id="embedCedula"  frameborder="0" width="100%" height="400px">
        </div>

        

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-primary">Guardar</button>-->
        </div>
        </div>
    </div>
    </div>
    
    <!-- Modal -->
    <!-- ===========<<<<<<<<<<<<< MODAL ARCHIVOS>>>>>>>>================-->
<!--===========<<<<<<<<<<FUNCION COMBO PAIS ARCHIVOS START>>>>>>>=========-->
<script type="text/javascript">

$(document).ready(function(){
    $("#divaba").hide();
    $("#divswift").hide();
$("#comunidad").change(function(){
  var valueComunidad = $(this).val();

    $.ajax({
        url: '../Controllers/comboPais.php',
        type: 'post',
      //  data: {pais:pais},
        dataType: 'json',
        success:function(response){
            var len = response.length;

            $("#pais").empty();
            $("#pais").append("<option value=''>Selecciona un País</option>");
            for( var i = 0; i<len; i++){
                var c_pais = response[i]['c_pais'];
                var nombre_pais = response[i]['nombre_pais'];
                
                $("#pais").append("<option value='"+c_pais+"'>"+ nombre_pais +"</option>");

            }

            if(valueComunidad == 1){
                $('select[name=pais]').val('MEX');
                //$("#pais").append("<option value='MEX'>México</option>");
                $("#pais").attr('readonly', true);
                $("#pais").prop('required',false);
                $("#divaba").hide();
                $("#divswift").hide();
                
            }else{
                $("#pais").attr('readonly', false);
                $("#pais").prop('required',true);
                $("#divaba").show();
                $("#divswift").show();
            }

             
        }
    });

    


});

}); 
function buscaProveedor(){
    var cadena = $("#nameProveedor").val();
    $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/filtrarProveedores.php?cadena='+cadena, datatype:'json',type:'GET'}).trigger('reloadGrid');
}

$( document ).ready(function() {
    var tipoproveedor = "";
    $('#tipo_proveedor').on('change', function() {
    //alert( this.value );
    tipoproveedor = this.value;
    $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/filtrarProveedoresTipo.php?tipo_proveedor='+tipoproveedor, datatype:'json',type:'GET'}).trigger('reloadGrid');
    //alert(tipoproveedor);

})
});

function poblarDatosBanco(){
    var nombrebanco = $("#nombreBanco").val();
    $.ajax({
        url: '../Controllers/poblarDatosBanco.php',
        type: 'POST',
        data: {nombrebanco:nombrebanco},
        dataType: 'html',
        success:function(answer){
            var datosBanco = answer.split("[_]");
            $("#codigoSantander").val(datosBanco[0]);
            $("#claveSAT").val(datosBanco[1]);
        }
    });
}
</script>
<!--===========<<<<<<<<<<FUNCION COMBO PAIS ARCHIVOS END>>>>>>>===========-->




<!-- ****************** Funcion Validar input clabe interbancaria y cuenta ******************* -->
<script>
 



function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



</script>
<!-- ***************************************************************************************** -->
</body>
</html>

