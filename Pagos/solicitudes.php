<?php
    include_once '../app/config.php'; //Modelo usuario
    if(!$_SESSION['_pid']){
        header('Location: '.URL.'login.php?e=n');
    }
    $idUsuario  = $_SESSION['_pid'];
    $nombre     = $_SESSION['_pname'];
    $nombreAll  = $_SESSION['_pnamefull'];

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
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <!-- <link href="css/mdb.min.css" rel="stylesheet"> -->
    
    <script src="../js/jquery-3.1.1.js"></script>
    
    <script type="text/javascript" src="../js/tether.min.js"></script>
    <!-- <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../js/i18n/grid.locale-es.js" type="text/javascript"></script>
    <script src="../js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/ui.jqgrid-bootstrap.css"/>
    <!-- <script type="text/javascript" src="js/mdb.min.js"></script> -->
    
    <script>
      $.jgrid.defaults.responsive = true;
      $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>
    <style>
        body{
            background: #F8F9F9;
            /* font-size: 15px; */
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
        }
        .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 45px;
            margin-top: -14px;
            margin-bottom: -12px;
            display: inine-block;
            font-size: 15px;
        }
        .jqgrow{
            font-size: 14px;
        }

        .ui-jqgrid-labels{
            background:#E5E8E8;;
        } */

        .folder{
            color:#F39C12;
        }
        .folderEmpty{

            color:#BFC9CA;

        }
        .pdf{
            color: #3498DB;
        }
        .pdfEmpty{
            color:#BFC9CA;
        }

        .txtEmpty{
            color:#BFC9CA;
        }
        .linkIcono{
            text-decoration:none;
        }
    </style>
    <link rel="stylesheet" href="../css/grid.css"/>
</head>
<body>
   <?php include_once "../layout.php"; ?>
   
    <div class="container-fluid">

     <!--===========<<<<<<<<<<<<<Listado solicitudes de pago>>>>>>>>>>>>>===========-->
     <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                        <!--  -->
                       <h6 style="float:left">Solicitudes / Pagos</h6>

                        <div class="col-md-3" style="text-align: right;float:right;">
                            <!--<input type="text" onkeyup="buscar(this.value);" class="form-control" style="background-color: transparent;border-bottom-color: white;color:white">-->
                            <!-- <input type="text" placeholder="Buscar..." id="search" name="search" class="search"  onkeyup="buscar(this.value);"> 
                            <i class="fa fa-search" onclick="buscarclick();" style="cursor: pointer;" aria-hidden="true"></i> -->
                        </div>
                    </div>
                    
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-block">
                    <!-- <hr class="my-4"> -->
                        <div class="row">
                            <div class="col-sm-9">
                            <button type="button" class="btn btn-primary btn-md" id="nuevo" onclick="nuevaSolicitud();"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Nuevo</button>
                            <!-- <button type="button" class="btn btn-warning btn-md" id="nuevo" onclick="AplicarReembolso();"><i class="fa fa-reply-all" aria-hidden="true"></i> Reembolso</button> -->
                            
                            <!-- <button type="button" class="btn btn-info btn-md" id="nuevo"    onclick="modalFiltros()"><i class="fa fa-filter" aria-hidden="true"></i> Filtros</button> -->
                            <!-- <button type="button" class="btn btn-success" id="nuevo" onclick="solicitudesExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>  -->

                            </div>
                            <div class="col-sm-3">
                            <!-- <div class="input-group">
                            <input type="text" onChange="filtrar();" name="coincidencia" id="coincidencia" class="form-control form-control-md" placeholder="buscar...">
                            <span class="input-group-btn"> 
                                <button type="button" onclick="filtrar();" class="btn btn-primary btn-md"  title="Buscar" id="btn_bfc" name="btn_bfc" value="">
                                    <i class="fa fa-search" aria-hidden="true"></i> 
                                </button>
                            </span>
                            </div> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-12'>
                                <table id="jqGrid" class="table table-bordered" style="font-zise:12px;"></table>
                                <div id="jqGridPager"></div>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>
                <!-- <br> -->
            </div>
            
        </div>
     <!--===========<<<<<<<<<<<<<Listado solicitudes de pago>>>>>>>>>>>>>===========-->

     <!--*********************************** MODAL DETALLE FOLIO ***********************************-->
    <div class="modal fade" bd-example-modal-lg id="detalleFolioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Villa Tours | Detalle - Historial</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- ------------------------------------ -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#facturas"><i class="fa fa-clipboard" aria-hidden="true"></i> Detalle Solicitud</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#uploadfacturas"><i class="fa fa-server" aria-hidden="true"></i> Historial Solicitud</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="facturas" class="container tab-pane active">
                    <!-- Apartado detalle de solicitud -->
                    <div class="detalleFolio"></div>
                    <!-- Apartado detalle de solicitud -->
                </div>
                <div id="uploadfacturas" class="container tab-pane fade">
                    <table id="jqGridLog" class="table table-bordered"></table>
                    <div id="jqGridPager"></div>
                </div>
            </div>
            <!-- ------------------------------------ -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    <!-- ***************************************************************************************** -->

     <!-- ===========<<<<<<<<<<<<< Modal Devoluciones de pago>>>>>>>>================-->
    <div class="modal fade" id="modalReembolso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Reembolso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="formReembolso">
                <div class="row">
                    <input class="form-control" type="hidden" id="_folio" name="_folio">
                    <div class="col-md-12"><br><h5>Folio de Solicitud: <strong id="folio_i"></strong></h5><hr></div>

                    <!-- <div class="col-md-12"></div> -->

                    <div class="col-md-12">
                        <label for="" class="col-form-label">* Motivo del Reembolso: </label>
                        <textarea class="form-control" id="motivo" name="motivo" placeholder="Descripción del Reembolso" rows="3" required></textarea>
                    </div>

                    <div class="col-12">
                        <br/>
                        <button type="submit" class="btn btn-warning wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-reply-all" aria-hidden="true"></i> Registrar Reembolso</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-primary">Guardar</button>-->
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ===========<<<<<<<<<<<<< Modal Devoluciones de pago>>>>>>>>================-->

    <!-- ===========<<<<<<<<<<<<< Modal Cancelacion de pago>>>>>>>>================-->
    <div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Cancelación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="formCancelacion">
                <div class="row">
                    <input class="form-control" type="hidden" id="_folioca" name="_folioca">
                    <div class="col-md-12"><br><h5>Folio de Solicitud: <strong id="folio_ic"></strong></h5><hr></div>
                    <!-- <div class="col-md-12"></div> -->
                    <div class="col-md-12">
                        <label for="" class="col-form-label">* Motivo de Cancelación: </label>
                        <textarea class="form-control" id="motivoc" name="motivoc" placeholder="Describe la cancelación" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <br/>
                        <button type="submit" class="btn btn-danger wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ===========<<<<<<<<<<<<< Modal Cancelacion de pago>>>>>>>>================-->

    <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Pagos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id='msg'></div>
        </div>
        <div class="modal-footer">
            <button type="button" style="display:none" id="opcionsi" onclick="reload();" class="btn btn-success">SI</button>
            <button type="button" style="display:none" id="opcionno" onclick="listado();" class="btn btn-warning">NO</button>
            <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-primary">Guardar</button>-->
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE END>>>>>>>>================-->

    <!-- =========================== Modal Facturas ========================-->
    <div class="modal fade" id="modalFacturas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Facturas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                <a class="nav-link disabled" data-toggle="tab" href="#"><i class="fa fa-bookmark" aria-hidden="true"></i> Folio : <span id="foliof">5125</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#facturass"><i class="fa fa-clipboard" aria-hidden="true"></i>Factura(s)</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#uploadfacturass"><i class="fa fa-upload" aria-hidden="true"></i>Cargar Factura(s)</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="facturass" class="container tab-pane active">
                <hr>
                <div id="FacturasLista">
                </div>
                </div>
                <div id="uploadfacturass" class="container tab-pane fade"><br>
                    <!-- <p>Formulario para carga de Comprobante.</p> -->
                    <form method="POST" id="formFacturas">
                        <input class="form-control" type="hidden" id="_foliof" name="_foliof">
                        <div class="row">
                        <div class="col-md-5">
                        <label for="" class="col-form-label">* Factura(s): </label>
                            <input class="form-control" type="text" id="facturas" name="facturas" placeholder="A-00000 | A-00001" aria-describedby="inputHelp" required>
                            <small id="inputHelp" class="form-text text-muted">En el caso de ser mas de 1 factura dividir con el caracter |</small>
                        </div>
                        <div class="col-md-7">
                        <label for="" class="col-form-label">* Documento(s): </label>
                            <br>
                            <input type="file" class="form-control-file btn btn-danger btn-sm" id="cfdfacturas" name="cfdfacturas[]" aria-describedby="fileHelp" multiple>
                            <small id="fileHelp" class="form-text text-muted">Cargar sus facturas para pago en formato y extencion (.pdf).</small>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                            <button type="button" name='listado' id='listado' onclick="closeFacturas();" class="btn btn-danger wow btn-md fadeInDown" data-wow-delay="0.2s"> Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button> -->
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- =========================== Modal Facturas ========================-->

    <!-- =========================== Modal Comprobante ========================-->
    <div class="modal fade" id="modalComprobantes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Comprobantes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                <a class="nav-link disabled" data-toggle="tab" href="#"><i class="fa fa-bookmark" aria-hidden="true"></i> Folio : <span id="folioc">5125</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home"><i class="fa fa-clipboard" aria-hidden="true"></i>comprobante(s)</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu1"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Cargar Comprobante(s)</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="container tab-pane active">
                    <hr>
                    <div id="ComprobantesLista"></div>
                    <!-- <button type="button" class="btn btn-primary btn-sm">Documento 1</button>-->
                </div>

                <div id="menu1" class="container tab-pane fade"><br>
                    <form method="POST" id="formComprobantes">

                        <input type="hidden" name="usuarioSolicitante" id="usuarioSolicitante" value = "<?php echo $nombreAll ?>">
                        <input class="form-control" type="hidden" id="_folioc" name="_folioc">
                        <div class="row">
                        <div class="col-md-5">
                        <label for="" class="col-form-label">* No. comprobante(s): </label>
                            <input class="form-control" type="text" id="Nocomprobantes" name="Nocomprobantes" placeholder="00000 | 00001" aria-describedby="inputHelp" required>
                            <small id="inputHelp" class="form-text text-muted">En el caso de ser mas de 1 comprobante dividir con el caracter |</small>
                        </div>
                        <div class="col-md-7">
                        <label for="" class="col-form-label">* Comprobante(s): </label>
                            <br>
                            <input type="file" class="form-control-file btn btn-primary btn-sm" id="comprobantes" name="comprobantes[]" aria-describedby="fileHelp" multiple>
                            <small id="fileHelp" class="form-text text-muted">Cargar sus comprobantes de pago en formato y extencion (.pdf).</small>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                            <button type="button" name='listado2' id='listado2' onclick="closeComprobantes();" class="btn btn-danger wow btn-md fadeInDown" data-wow-delay="0.2s"> Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button> -->
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- =========================== Modal Comprobante ========================-->

    <!-- =========================== Modal TXT ========================-->
    <div class="modal fade" id="modalTXT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | TXT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                <a class="nav-link disabled" data-toggle="tab" href="#"><i class="fa fa-bookmark" aria-hidden="true"></i> Folio : <span id="folioc">5125</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home"><i class="fa fa-clipboard" aria-hidden="true"></i>TXT</a>
                </li>
                <li class="nav-item">
                <!-- <a class="nav-link" data-toggle="tab" href="#menu1"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Cargar Comprobante(s)</a> -->
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="container tab-pane active">
                    <hr>
                    <div id="TXTLista"></div>
                    <!-- <button type="button" class="btn btn-primary btn-sm">Documento 1</button>-->
                </div>

                <div id="menu1" class="container tab-pane fade"><br>
                    <!-- <form method="POST" id="formComprobantes">
                        <input class="form-control" type="hidden" id="_folioc" name="_folioc">
                        <div class="row">
                        <div class="col-md-5">
                        <label for="" class="col-form-label">* No. comprobante(s): </label>
                            <input class="form-control" type="text" id="Nocomprobantes" name="Nocomprobantes" placeholder="00000 | 00001" aria-describedby="inputHelp" required>
                            <small id="inputHelp" class="form-text text-muted">En el caso de ser mas de 1 comprobante dividir con el caracter |</small>
                        </div>
                        <div class="col-md-7">
                        <label for="" class="col-form-label">* Comprobante(s): </label>
                            <br>
                            <input type="file" class="form-control-file btn btn-primary btn-sm" id="comprobantes" name="comprobantes[]" aria-describedby="fileHelp" multiple>
                            <small id="fileHelp" class="form-text text-muted">Cargar sus comprobantes de pago en formato y extencion (.pdf).</small>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                            <button type="button" name='listado' id='listado' onclick="closeComprobantes();" class="btn btn-danger wow btn-md fadeInDown" data-wow-delay="0.2s"> Cancelar</button>
                        </div>
                    </form> -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary">Guardar</button> -->
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- =========================== Modal TXT ========================-->

    <!-- ===========<<<<<<<<<<<<< MODAL FILTROS START>>>>>>>>================-->
    <div class="modal fade" id="modalFiltro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <!-- style="background: #5cb85c" -->
            <h5 class="modal-title">Villa Tours | Pagos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
            <div class="row">
                    <div class="col-md-6 ml-auto">
                    <div class="form-check">
  <input class="form-check-input" type="radio" name="selectorFecha" id="selectorFecha1" value="1" checked>
  <label class="form-check-label" for="exampleRadios1">
    Fecha Solicitud
  </label>
</div>
                    </div>
                    <div class="col-md-6 ml-auto">
                    <div class="form-check">
  <input class="form-check-input" type="radio" name="selectorFecha" id="selectorFecha2" value="2">
  <label class="form-check-label" for="exampleRadios2">
    Fecha Límite
  </label>
</div>
                    </div>
                    <div class="col-md-6 ml-auto">
                        <div class="form-group">
                            <label for="" class="col-form-label" id="labelf1"></label>
                            <input type="date" class="form-control" id="fechaSolicitudi" name="fechaSolicitudi">
                         </div>
                    </div>
                    <div class="col-md-6 ml-auto">
                        <div class="form-group">
                            <label for="" class="col-form-label" id="labelf2"></label>
                            <input type="date" class="form-control" id="fechaSolicitudf" name="fechaSolicitudf">
                         </div>
                    </div>
                    <div class="col-md-12 ml-auto">
                        <div class="form-group">
                            <label for="" class="col-form-label">Estatus Solicitud:</label>
                            <!-- <button type="button" class="btn btn-success btn-md" id="nuevo" onclick=""><i class="fa fa-file-excel-o" aria-hidden="true"></i> Reporte</button>  -->
                            <select class="form-control" id="selectTipo" name="selectTipo">
                                    <option value="0">Selecciona un Estatus</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="pagado">Pagado</option>
                                    <option value="Aceptado">Aceptado</option>
                                    <option value="Rechazado">Rechazado </option>
                                    <option value="Rechazado CXP">Rechazado CXP</option>
                                    <option value="Pago Programado">Pago Programado</option>
                            </select>
                         </div>
                    </div>
                </div>
            </div>


            <!-- <div id='modalFiltromsg'></div> -->

        </div>
        <div class="modal-footer">            
            <button type="button" class="btn btn-primary" onclick="solicitudesFiltro();" data-dismiss="modal">Aceptar</button>            
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ===========<<<<<<<<<<<<< MODAL FILTROS END>>>>>>>>================-->
    <script>
    $(document).ready(function () {
        $("#jqGrid").jqGrid({
        url:'../Controllers/listarSolicitudes.php',
        datatype: "json",
        styleUI : 'Bootstrap',
        colModel: [
            {label: 'Folio', name: 'id', width: 3, key: true},
            {label: 'Oficina', name: 'empresa', width:7},
            {label: 'Tipo <br> Solicitud', name: 'tiposol', width: 7},
            {label: 'No.<br> Prov.', name: 'numProveedor', width: 5},
            {label: 'Beneficiario', name: 'proveedor', width: 10 },
            {label: 'localizador', name: 'localizador', width: 7,hidden:true},
            {label: 'Moneda', name: 'monedaImporte', width: 5 },
            {label: 'Importe', name: 'monto', width: 5 }, 
            {label: 'Tipo <br> Cambio', name: 'tipocambio', width: 5 },
            {label: 'Moneda <br> Pago', name: 'monedaPago', width: 5 },
            {label: 'Importe <br> Pago', name: 'montoPago', width: 5 }, 
            {label: 'Fecha<br> Solicitud', name: 'fechaSolicitud', width: 8},
            {label: 'Fecha<br> Limite', name: 'fechaLimite', width: 8},
            {label: 'Solicitante', name: 'solicitante', width: 8},
            {label: 'Estatus', name: 'estatus', width: 15},
            {label: 'factura', name: 'factura', width: 3},
            {label: 'comprobante',name: 'comprobante', width: 3},
            {label: 'txt',name: 'txt', width: 3},
            {label: 'más',name: 'vermas', width: 4}
        ],
        loadonce: true,
        viewrecords: true,
        autowidth: true,
        /*width:1280,*/
        height:350,
        rowNum: 7,
        rowList : [7,10,15],
        pager: '#jqGridPager',
        // multiselect: true,
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

        $("#jqGridLog").jqGrid({
            url:'../Controllers/listarLog.php?id=' + 1,
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [
                {label: 'Id', name: 'id', width: 10, key: true, hidden:true},
                {label: 'Folio', name: 'folio', width: 30 },
                {label: 'Responsable', name: 'responsable', width: 100},
                {label: 'Descripción', name: 'descripcion', width: 150},
                {label: 'Fecha', name: 'fecha', width: 90},
            ],
            loadonce: true,
            viewrecords: true,
            scroll: true,
            width: 750
            // autowidth: true


    });
    });
    function nuevaSolicitud(){
        window.location.href = 'nuevaSolicitud.php';
    }

    function AplicarReembolso(){

    var grid   = $("#jqGrid");
    var rowKey = grid.getGridParam("selrow");

    if(rowKey){
        var datos  = grid.getRowData(rowKey);
        console.log(datos.id);
        console.log(rowKey);
        $("#_folio").val(datos.id);
        $("#folio_i").text(datos.id);
        $("#modalReembolso").modal("show");
    }else{
        $('#msg').text('Debe seleccionar una solicitud');
        $("#modalMsg").modal('show');
    }
    }

    function facturas(folio){
        $("#_foliof").val(folio);
        $("#foliof").text(folio);
        // var url = 'solicitudes.php';
        // $('#modalFacturas').load(url + ' #modalFacturas');
        
        $.ajax({
            url: "../Controllers/listarFacturas.php",
            type: "POST",
            dataType: "html",
            data: "_folio=" + folio,
            success:  function (answer) {
            $("#FacturasLista").html(answer);
            }
        });
        $("#modalFacturas").modal("show");

    }

    function comprobantes(folio){
        $("#_folioc").val(folio);
        $("#folioc").text(folio);

        $.ajax({
            url: "../Controllers/listarComprobantes.php",
            type: "POST",
            dataType: "html",
            data: "_folio=" + folio,
            success:  function (answer) {
            $("#ComprobantesLista").html(answer);
            }
        });

        $("#modalComprobantes").modal("show");
    }

    $("#formReembolso").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("formReembolso"));
        $.ajax({
            url: "../Controllers/aplicarReembolso.php",
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
                if(res==1){
                    // $("#modalReembolso").modal("hidden");
                    $('#modalReembolso').modal('toggle');
                    $('#msg').text('Correcto: El proceso de reembolso se realizó con éxito.');
                    $("#modalMsg").modal('show');
                }else{
                    $('#msg').text('Error: No se pudo completar el proceso de registro reembolso');
                    $("#modalMsg").modal('show');
                }
            });
        e.preventDefault(); //stop default action
    });

    $("#formCancelacion").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("formCancelacion"));
        $.ajax({
            url: "../Pagos/deshabilitaSolicitud.php",
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
                if(res==1){
                    $('#modalCancelar').modal('toggle');
                    $('#msg').text('Correcto: El proceso de cancelación se realizó con éxito.');
                    $("#modalMsg").modal('show');
                }else{
                    $('#msg').text('Error: No se pudo completar el proceso de cancelacion de solicitud');
                    $("#modalMsg").modal('show');
                }
            });
        e.preventDefault(); //stop default action
    });

    $("#formFacturas").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("formFacturas"));
        $.ajax({
            url: "../Controllers/cargaFacturas.php",
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
                console.log(res);
                if(res==1){
                    $('#modalFacturas').modal('toggle');
                    $('#msg').text('Correcto: La factura(s) se registraron correctamente.');
                    $("#modalMsg").modal('show');
                    document.getElementById("formFacturas").reset();
                    $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarSolicitudes.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
                }else{
                    $('#msg').text('Error: No se pudo completar el proceso carga de facturas');
                    $("#modalMsg").modal('show');
                }
            });
        e.preventDefault(); //stop default action
    });

    $("#formComprobantes").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(document.getElementById("formComprobantes"));
        $.ajax({
            url: "../Controllers/cargaComprobantes.php",
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
                console.log(res);
                if(res==1){
                    $('#modalComprobantes').modal('toggle');
                    $('#msg').text('Correcto: El comprobante(s) se registro correctamente.');
                    $("#modalMsg").modal('show');
                    document.getElementById("formComprobantes").reset();
                    $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarSolicitudes.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
                }else{
                    $('#msg').text('Error: No se pudo completar el proceso carga de comprobantes');
                    $("#modalMsg").modal('show');
                }
            });
        e.preventDefault(); //stop default action
    });

function closeFacturas(){

    $('#modalFacturas').modal('toggle');
}

function closeComprobantes(){
    $('#modalComprobantes').modal('toggle');
}

function filtrar(){

    var cadena = $("#coincidencia").val();
    if(cadena.trim() == ""){
        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarSolicitudes.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
    }else{
        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/filtrarSolicitudes.php?cadena='+cadena, datatype:'json',type:'GET'}).trigger('reloadGrid');
    }
    
}

function detallesolicitud(folio)
{
    $(".detalleFolio").html("");
    $.ajax({
    method: "POST",
    url: "../Controllers/detalleFolioSolicitud.php",
    data: {folio : folio}
    })
    .done(function(respuesta) {
        listadoLog(folio);
        $(".detalleFolio").html(respuesta);
    });
    $("#detalleFolioModal").modal("show");
}

function modalFiltros()
{
    $("#modalFiltro").modal("show");
} 

function solicitudesFiltro()
{
    var fecha_inicio = $("#fechaSolicitudi").val();
    var fecha_fin = $("#fechaSolicitudf").val();
    var estatus = $("#selectTipo").val();
    var selector = $("input[name=selectorFecha]:checked").val();//$("#selectorFecha").val();

    //alert(fecha_inicio + ' ' +fecha_fin +' '+estatus);

    if(fecha_inicio > fecha_fin){
        $("#modalFiltro").modal("hide");
        $('#msg').text('La fecha inicio debe ser menor a fecha fin');
        $("#modalMsg").modal('show');
    }else
    {
        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/solicitudesFiltros.php?fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin+'&estatus='+estatus+'&selectorFecha='+selector, datatype:'json',type:'GET'}).trigger('reloadGrid');     
    }

}
function solicitudesExcel(){
    var fecha_inicio = $("#fechaSolicitudi").val();
    var fecha_fin = $("#fechaSolicitudf").val();
    var estatus = $("#selectTipo").val();
    var selector = $("input[name=selectorFecha]:checked").val();//$("#selectorFecha").val();

    //alert(fecha_inicio + ' ' +fecha_fin +' '+estatus);

    if(fecha_inicio > fecha_fin){
        $("#modalFiltro").modal("hide");
        $('#msg').text('La fecha inicio debe ser menor a fecha fin');
        $("#modalMsg").modal('show');
    }else{
        //$('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/solicitudesFiltros.php?fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin+'&estatus='+estatus, datatype:'json',type:'GET'}).trigger('reloadGrid');
        location.href = '../Controllers/solicitudesFiltrosExcel.php?fecha_inicio='+ fecha_inicio +'&fecha_fin='+ fecha_fin +'&estatus='+ estatus +'&selectorFecha='+selector+''; 
    }
}


$(document).ready(function() {
    $("input[name$='selectorFecha']").click(function() {
        var test = $(this).val();
        if(test == 1){
            $("#labelf1").html("Fecha Solicitud Inicio:");
            $("#labelf2").html("Fecha Solicitud Fin:");

        }else if(test == 2){
            
            $("#labelf1").html("Fecha Límite Inicio:");
            $("#labelf2").html("Fecha Límite Fin:");
        }

        //alert(test);
    });
});

$(document).ready(function() {
    $("#labelf1").html("Fecha Solicitud Inicio:");
    $("#labelf2").html("Fecha Solicitud Fin:");
});
function modalCancelaSolicitud(id){

    $("#_folioca").val(id);
    $("#folio_ic").text(id);
    $("#modalCancelar").modal("show");
}
function eliminaFactura(rutaFactura){
    var folio = $("#_foliof").val();
    $.ajax({
    method: "POST",
    url: "../Controllers/eliminaFactura.php",
    data: {rutaFactura : rutaFactura}

    }).done(function(respuesta) {

        $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarSolicitudes.php', datatype:'json',type:'GET'}).trigger('reloadGrid');

        $.ajax({
            url: "../Controllers/listarFacturas.php",
            type: "POST",
            dataType: "html",
            data: "_folio=" + folio,
            success:  function (answer) {
            $("#FacturasLista").html(answer);
            }
        });
    });
}

function eliminaComprobante(rutaComprobante){
    var folio = $("#_folioc").val();

    $('#jqGrid').jqGrid('setGridParam',{url:'../Controllers/listarSolicitudes.php', datatype:'json',type:'GET'}).trigger('reloadGrid');
    
    $.ajax({
    method: "POST",
    url: "../Controllers/eliminaComprobante.php",
    data: {rutaComprobante : rutaComprobante}

    }).done(function(respuesta) {

        

        $.ajax({
            url: "../Controllers/listarComprobantes.php",
            type: "POST",
            dataType: "html",
            data: "_folio=" + folio,
            success:  function (answer) {
                $("#ComprobantesLista").html(answer);
            }
        });
    });
}

function listadoLog(key){
    $('#jqGridLog').jqGrid('setGridParam',{url:'../Controllers/listarLog.php?id=' + key , datatype:'json',type:'GET'}).trigger('reloadGrid');
}
</script>
<!--********************** Funciones TXT ********************-->
<script>
function txt(folio){
    //alert(id);
    $.ajax({
        url: "../Controllers/listartxt.php",
        type: "POST",
        dataType: "html",
        data: "_folio=" + folio,
        success:  function (answer) {
        $("#TXTLista").html(answer);
        }
    });

    //$("#modalComprobantes").modal("show");
    $("#modalTXT").modal("show");

}
</script>
<!-- ******************************************************* -->
 </div>
</body>
</html>