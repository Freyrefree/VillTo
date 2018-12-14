<?php
    include_once '../app/config.php'; //Modelo usuario
    date_default_timezone_set('America/Mexico_City');
    #include_once 'Models/circuito.php'; //Modelo usuario
    #$circuito  = new Circuito();
    #define('URL', "http://localhost/JuliaTravelPagos/"); #representa [ ruta web ] 
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
        .rojo{
            color: #d9534f;
            font-size: 17px;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 9px;
        }
         
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 50px rgba(0,0,0,0.3); /* 105,106,110 */
            border-radius: 10px;
        }
         
        ::-webkit-scrollbar-thumb {
            border-radius: 50px;
            -webkit-box-shadow: inset 0 0 20px rgba(21, 67, 96);
        }
        /* .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 20px;
            margin-top: -8px;
            display: inine-block;
        }
        .ui-jqgrid-labels{
            background:#E5E8E8;
        }*/
        .ui-jqgrid .ui-jqgrid-htable .ui-th-div{
            height: 20px;
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
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE USUARIOS START>>>>>>>>>>>>>===========-->  
     <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                    <h6 style="float:left">Pagos / Nueva solicitud</h6>
                    </div>
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <div class="row">
                                <div class='col-md-12'>
                                    <!-- contenido de formulario -->
                                    <form method="POST" id="formPagos">
                                        <div class="row">
                                        <div class="col-md-4">
                                                <label for="" class="col-form-label">Tipo de solicitud de pago: </label>
                                                <select class="form-control" id="tipoSolicitud" name="tipoSolicitud" required >
                                                </select>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-2">
                                                <!-- <label class="sr-only" for="inlineFormInputGroup">Username</label> -->
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon">Fecha: </div>
                                                    <input type="text" class="form-control" id="fecha" name="fecha" value="<?= date("d/m/Y"); ?>" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-md-12"><h5>Información de la solicitud <a href="#informacionSolicitud" data-toggle="collapse"><i class="fa fa-plus-circle" aria-hidden="true"></i></a></h5><hr></div>
                                            <!-- <div class="col-md-12"><hr></div> -->

                                            <!-- #segmento informacion de la solicitud -->
                                            <div id="informacionSolicitud" class="col-md-12 collapse show">
                                            <div class="row">

                                            <div class="col-md-6">
                                                <label for="" class="col-form-label"> Nombre del beneficiario / Razón Social: </label>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="proveedor" name="proveedor" onblur="poblarBancosExtra();" placeholder="00000 | Nombre Proveedor">
                                                    <!-- required -->
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info" type="button" onclick="" id="btnGet" data-toggle="modal" data-target="#modalProvier"> <i class="fa fa-id-card" aria-hidden="true" id="getFi"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="" class="col-form-label">* Centros de costo(s): </label>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="cecos" name="cecos" placeholder="00000 | 00000 | 00000" readonly="true">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-success" type="button" id="btnGet2" data-toggle="modal" data-target="#modalCECOS"> <i class="fa fa-cc" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <!-- <label for="" class="col-form-label">Localizador: </label> -->
                                                <div class="input-group">
                                                    <input class="form-control" type="hidden" id="localizador" name="localizador" placeholder="00000">
                                                    <span class="input-group-btn">
                                                        <!-- <button class="btn btn-info" type="button" onclick="" id="btnGet"> <i class="fa fa-id-card" aria-hidden="true" id="getFi"></i></button> -->
                                                    </span>
                                                </div>
                                            </div>                                            

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">Monto a pagar: </label>
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></div>
                                                    <input class="form-control" type="number" id="monto" onblur="importeconletra();" name="monto" placeholder="00,0000.00" step=".01" required>
                                                    <!--  -->
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">Moneda: </label>
                                                <select class="form-control" id="moneda" name="moneda" onchange="importeconletra();" required>
                                                <!-- <select id="moneda" name="moneda" class="form-control selectpicker" data-live-search="true" multiple> -->
                                                <option value="">Elige una opcion</option>
                                                    <option value="DolaresAustralia">AUD</option>
                                                    <option value="Real">BRL</option>
                                                    <option value="DolaresCanada">CAD</option>
                                                    <option value="Euros">EUR</option>
                                                    <option value="DolaresFidji">FJD</option>
                                                    <option value="Libra">GBP</option>
                                                    <option value="Yen">JPY</option>
                                                    <option value="Pesos">MXN</option>
                                                    <option value="DolaresZelanda">NZD</option>
                                                    <option value="DolaresSingapur">SGD</option>
                                                    <option value="Baht">THB</option>
                                                    <option value="Dolares">USD</option>
                                                    <option value="Rand">ZAR</option>
                                                </select>
                                            </div>

                                            <div class="col-md-8">
                                                <label for="" class="col-form-label">* Monto a pagar en letra: </label>
                                                <input class="form-control" type="text" id="montoletra" name="montoletra" placeholder="" readonly="true">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">Tipo de cambio: </label>
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></div>
                                                    <input class="form-control" type="number" id="tipocambio" name="tipocambio" onchange="conversionDivisa();" placeholder="00.00" step=".01" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">Moneda de Pago: </label>
                                                <select class="form-control" id="monedaPago" name="monedaPago" onchange="conversionDivisa();" required readonly disabled>
                                                <!-- <select id="moneda" name="moneda" class="form-control selectpicker" data-live-search="true" multiple> -->
                                                <option value="">Elige una opcion</option>
                                                    <option value="DolaresAustralia">AUD</option>
                                                    <option value="Real">BRL</option>
                                                    <option value="DolaresCanada">CAD</option>
                                                    <option value="Euros">EUR</option>
                                                    <option value="DolaresFidji">FJD</option>
                                                    <option value="Libra">GBP</option>
                                                    <option value="Yen">JPY</option>
                                                    <option value="Pesos">MXN</option>
                                                    <option value="DolaresZelanda">NZD</option>
                                                    <option value="DolaresSingapur">SGD</option>
                                                    <option value="Baht">THB</option>
                                                    <option value="Dolares">USD</option>
                                                    <option value="Rand">ZAR</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">Conversion Divisa: </label>
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></div>
                                                    <input class="form-control" type="number" id="conversion" name="conversion" placeholder="00.00" step=".01" readonly="true">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="" class="col-form-label">Forma de pago: </label>
                                                <select class="form-control" id="formapago" name="formapago" required>
                                                    <option value="">Elige una opcion</option>
                                                    <option value="Efectivo">Efectivo</option>
                                                    <option value="Transferencia">Transferencia Electrónica</option>
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-4"></div> -->

                                            <div class="col-md-8">
                                                <label for="" class="col-form-label">* Concepto de pago: </label>
                                                <textarea class="form-control" id="concepto" name="concepto" placeholder="Descripción del pago" rows="3" required></textarea>
                                                <!-- <input class="form-control" type="text" id="concepto" name="concepto" placeholder="Concepto de pago" required> -->
                                            </div>
                                            <!-- <div class="col-md-4"></div> -->

                                            <div class="col-md-2">
                                            <label for="" class="col-form-label">* Fecha limite de pago: </label>
                                                <input class="form-control" type="date" value="<?= date("Y-m-d"); ?>" id="fechalimite" name="fechalimite">
                                            </div>

                                            <div class="col-md-2">
                                                <!-- <label for="" class="col-form-label">importancia: </label>
                                                <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                                    <input type="checkbox" class="custom-control-input" id="importancia" name="importancia" value="si">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"> <strong> Pago urgente</strong></span>
                                                </label> -->
                                            </div>

                                            </div>
                                            </div>
                                            <!-- #segmento informacion de la solicitud -->

                                            <div class="col-md-12"><br><h5>Facturas y/o Comprobantes <a href="#facturasComprobantes" data-toggle="collapse"><i class="fa fa-plus-circle" aria-hidden="true"></i></a> </h5><hr></div>

                                            <!-- #segmento Facturas o Comprobantes -->
                                            <div id="facturasComprobantes" class="col-md-12 collapse">
                                            <div class="row">

                                            <div class="col-md-5">
                                            <label for="" class="col-form-label">* Factura(s): </label>
                                            <!-- <br> -->
                                                <input class="form-control" type="text" id="facturas" name="facturas" placeholder="NA-0000">
                                                <!-- <input type="file" class="form-control-file btn btn-primary btn-sm" id="facturas" name="facturas" aria-describedby="fileHelp">
                                                <small id="fileHelp" class="form-text text-muted">Cargar sus comprobantes de pago en formato (.pdf).</small> -->
                                            </div>

                                            <div class="col-md-5">
                                            <label for="" class="col-form-label">* Documentos(s): </label>
                                                <br>
                                                <input type="file" class="form-control-file btn btn-primary btn-sm" id="facturas2" name="facturas[]" aria-describedby="fileHelp" multiple>
                                                <small id="fileHelp" class="form-text text-muted">Cargar sus comprobantes de pago en formato (.pdf | .xml).</small>
                                            </div>
                                            
                                            </div>
                                            </div>
                                            <!-- #segmento Facturas o Comprobantes -->
                                            <div class="col-md-12"><br></div>

                                            <div class="col-md-12"><h5>Datos bancarios <a href="#Datosbancarios" data-toggle="collapse"><i class="fa fa-plus-circle" aria-hidden="true"></i></a> </h5><hr></div>

                                            <!-- #segmento datos bancarios -->
                                            <div id="Datosbancarios" class="col-md-12 collapse">
                                            <div class="row">
                                            
                                            <!-- <div class="col-md-5">
                                                <label for="" class="col-form-label">* Banco | Cuenta: </label>
                                                <div class="input-group">
                                                    <select class="form-control" onchange="poblarClabeInterbancaria();" id="bancoCuenta" name="bancoCuenta">
                                                        <option value="">Elige una opcion</option> -->
                                                        <!-- <option value="1">SANTANDER | 198983928982</option>
                                                        <option value="2">BANCOMER | 989953588951</option> -->
                                                    <!-- </select>
                                                    <span class="input-group-btn"> -->
                                                        <!-- <button class="btn btn-info" type="button" onclick="listadoCuentas();" id="btnMC"> <i class="fa fa-credit-card-alt" aria-hidden="true"></i></button> -->
                                                        <!-- data-toggle="modal" data-target="#modalCuentas" -->
                                                    <!-- </span>
                                                </div>
                                            </div> -->


                                            <div class="col-md-3">
                                                <label for="" class="col-form-label">* Banco | Cuenta: </label>
                                                <div class="input-group">
                                                    <select class="form-control" onchange="poblarClabeInterbancaria();" id="bancoCuenta" name="bancoCuenta">
                                                        <option value="">Elige una opcion</option>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info" type="button" onclick="listadoCuentas();" id="btnMC"> <i class="fa fa-credit-card-alt" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">* Banco: </label>
                                                <input class="form-control" type="text" id="banco" name="banco" placeholder="">
                                            </div>  

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">* Clabe interbancaria: </label>
                                                <input class="form-control" type="text" id="clabeinter" name="clabeinter" placeholder="00000000">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="" class="col-form-label">Referencia: </label>
                                                <input class="form-control" type="text" id="referencia" name="referencia" placeholder="00000000">
                                            </div>

                                            </div>
                                            </div>
                                            <!-- #segmento datos bancarios -->
                                            <div class="col-md-12"><br></div>
                                            <div class="col-md-12"><h5>Pagos al extranjero <a href="#PagoExtrangeros" data-toggle="collapse"><i class="fa fa-plus-circle" aria-hidden="true"></i></a> </h5><hr></div>

                                            <!-- #segmento Pago a Extrangeros -->
                                            <div id="PagoExtrangeros" class="col-md-12 collapse">
                                            <div class="row">

                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">Extranjero: </label>
                                                <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                                    <input type="checkbox" class="custom-control-input" onclick="poblarDatosExtra();" id="extrangero" name="extrangero">
                                                    <span class="custom-control-indicator"></span>
                                                    <span class="custom-control-description"> <strong> Aplica Extranjero </strong></span>
                                                </label>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="" class="col-form-label">ABA: </label>
                                                <input class="form-control" type="text" id="_aba" name="_aba" placeholder="00000000">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="" class="col-form-label">SWIFT: </label>
                                                <input class="form-control" type="text" id="_swift" name="_swift" placeholder="00000000">
                                            </div>
                                            
                                            </div>
                                            </div>
                                            <!-- #segmento Pago a Extrangeros -->

                                        <div class="col-md-12">
                                            <br>
                                            <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s" id="solicitarPago"><i class="fa fa-envelope" aria-hidden="true"></i> Solicitar</button>
                                            <button type="button" name='listado' id='listado' onclick="listarSolicitudes();" class="btn btn-danger wow btn-md fadeInDown" data-wow-delay="0.2s"> Cancelar</button>
                                            &nbsp;&nbsp;&nbsp;<img id="process" style="display:none;" src="../img/loadingimg.gif" height="42" width="42" alt="Loading">&nbsp;<span id="txtprocess" style="color: #0c84e4;display:none;"> Procesando...</span>
                                            <!-- <i class="fa fa-cog fa-spin fa-2x fa-fw"></i>
                                            <span class="sr-only">Loading...</span> -->
                                        </div>
                                        </div>
                                    </form>
                                    <!-- contenido de formulario -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <br> -->
            </div>
        </div>
     <!--===========<<<<<<<<<<<<<PANEL DE REGISTROS DE USUARIOS END>>>>>>>>>>>>>===========-->

    <!-- ====================== MODAL SELECCION DE CECOS ==========================-->
    <div class="modal fade" id="modalCECOS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | CECOS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class='col-md-12'>
                <table id="jqGridCECOS" class="table table-bordered"></table>
                <div id="jqGridPager"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="getRowsCecos();">Aceptar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ====================== MODAL SELECCION DE CECOS ==========================-->

    <!-- ====================== MODAL REGISTRO PROVEEDOR ==========================-->
    <div class="modal fade" id="modalProvier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Proveedor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class='col-md-12'>
            <form method="POST" id="formNewProv" enctype="multipart/form-data">
                <div class="row">
                <!-- <div class="form-group row"> -->                                
                    <!-- <div class="col-md-3"> -->
                        <!-- <label for="" class="">No. Proveedor :</label> -->
                        <input class="form-control" type="hidden" id="numproveedor" name="numproveedor"  placeholder="Número Proveedor">
                    <!-- </div> -->
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                    <div class="col-md-6">
                        <label for="" class="">RFC | TAX ID</label>
                        <input type="text" name="rfc" id="rfc" placeholder="RFC | TASK ID" class="form-control" required>
                    </div>
                
                <!-- </div> -->
                

                <!-- <div class="form-group row"> -->
                    <div class="col-md-6">
                        <label for="" class="col-form-label">Razón Social: </label>
                        <input class="form-control" type="text" placeholder="Razón Social" id="razonsocial" name="razonsocial" required>
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-6">
                        <label for="" class="col-form-label">Alias Comercial: </label>
                        <input class="form-control" type="text" id="aliascomercial" placeholder="Alias Comercial" name="aliascomercial" required>
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                    <div class="col-md-6">
                        <label for="" class="col-form-label">Direccion: </label>
                        <input class="form-control" type="text" id="direccion" placeholder="Direccion" name="direccion" required>
                    </div>
                <!-- </div> -->
                
                    
                    <!-- <div class="form-group row"> -->
                    <div class="col-md-6">
                        <label for="" class="col-form-label">Correo: </label>
                        <input class="form-control" type="email" id="email" placeholder="ejemplo@mail.com" name="email">
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-6">
                        <label for="" class="col-form-label">Contacto: </label>
                        <input class="form-control" type="text" id="contacto" placeholder="Contacto" name="contacto" required>
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-3">
                        <label for="" class="col-form-label">Teléfono: </label>
                        <input class="form-control" type="text" id="tel1" placeholder="Teléfono" name="tel1">
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-3">
                        <label for="" class="col-form-label">Teléfono 2: </label>
                        <input class="form-control" type="text" id="tel2" placeholder="Teléfono 2" name="tel2">
                    </div>
                <!-- </div> -->
                                            <!-- <div class="form-group row"> -->
                <!-- <div class="col-md-6">                                   
                </div> -->
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-2">
                        <label for="" class="col-form-label">Nacionalidad: </label>
                        <select id='comunidad' name='comunidad' class="form-control" required>
                            <option value="">Selecciona una Opción</option>
                            <option value="1">Nacional</option>
                            <option value="2">Extranjero</option>                                        
                        </select>
                </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-2">
                        <label for="" class="col-form-label">País: </label>
                        <select id='pais' name='pais' class="form-control" required>                                                                                                                     
                        </select>
                </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-2">
                        <label for="" class="col-form-label">CP: </label>
                        <input type =text id='cp' name='cp' class="form-control" placeholder="CP">
                </div>
                <!-- </div> -->

                <!-- <div class="form-group row"> -->
                <div class="col-md-6">
                        <label for="" class="col-form-label">Carátula Bancaria: </label>
                        <input class="btn btn-info btn-sm" type="file" id="filecaratula" name="filecaratula" accept=".pdf,.png,.jpg">
                        <small class="form-text text-muted">Archivos requeridos(.pdf|.png|.jpg)</small>                           
                </div>
                <!-- </div> -->
                <!-- <div class="form-group row"> -->
                <div class="col-md-6">
                        <label for="" class="col-form-label">Archivo Cédula: </label>
                        <input class="btn btn-info btn-sm" type="file" id="filecedula" name="filecedula" accept=".pdf,.png,.jpg">
                        <small class="form-text text-muted">Archivos requeridos(.pdf|.png|.jpg)</small>
                </div>
                <!-- </div> --> 
                    <!-- <div class="form-group row"> -->
                    <div class="col-md-6" id="divaba">
                        <label for="" class="col-form-label">ABA: </label>
                        <input class="form-control" type="text" id="aba" placeholder="ABA" name="aba" >
                    </div>
                <!-- </div> -->
                    <!-- <div class="form-group row"> -->
                    <div class="col-md-6" id="divswift">
                        <label for="" class="col-form-label">SWIFT: </label>
                        <input class="form-control" type="text" id="swift" placeholder="SWIFT" name="swift" >
                    </div>
                <!-- </div> -->               
                

                
                <!-- </div> -->
                <div class="col-12">
                    <br>
                    <button id="btnNewProv" type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-address-card" aria-hidden="true"></i> Registrar</button>
                    &nbsp;&nbsp;&nbsp;<img id="proceso" style="display:none;" src="../img/loadingimg.gif" height="42" width="42" alt="Loading">&nbsp;<span id="txtproceso" style="color: #0c84e4;display:none;"> Creando...</span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </form>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="">Aceptar</button>
            
        </div> -->
        </div>
    </div>
    </div>
    </div>
    <!-- ====================== MODAL REGISTRO PROVEEDOR ==========================-->

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
                    <table id="jqGridCuentas" class="table table-bordered"></table>
                    <div id="jqGridPagerCuentas"></div>
                </div>
                <div  id="collapseFormCuentas" class="collapse show" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="card-block">
                        <form method="POST" id="formNuevaCuenta">
                            <div class="row">
                                <input class="form-control" type="hidden" id="idproveedor" placeholder="Banco" name="idproveedor">
                                <div class="col-md-4">
                                    <label for="" class="col-form-label">Banco: </label>
                                    <select class="form-control" id="nombreBanco" name="nombreBanco" onchange="poblarDatosBanco();"; required>
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
                                    <select class="form-control" id="divisa" name="divisa" onchange="cuentaDivisa();">
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
                                    <input class="form-control" type="text" id="numCuenta" placeholder="Número Cuenta" name="numCuenta" onkeypress="return isNumberKey1(event);">
                                    <small id="smallc" class="form-text text-muted">10 u 11 Dígitos (Capture Sin Espacios)</small>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="col-form-label">Clabe Interbancaria: </label>
                                    <label class='error'>Clabe Inválida</label>
                                    <input class="form-control" type="text" id="clabeInter" name="clabeInter" placeholder="Clabe Intebancaria" onkeypress="return isNumberKey(event)"    required title="Ingrese 15, 16 o 18 dígitos (Capture Sin Espacios)" >
                                    <small id="smallcbi" class="form-text text-muted">15,16 o 18 Dígitos (Capture Sin Espacios)</small>
                                </div>

                                <div class="col-md-12"><hr><small><i class="fa fa-arrow-right" aria-hidden="true"></i> Datos Opcionales </small></div>
                                <div class="col-md-6">
                                    <div id="loadGif"></div>
                                </div>
                                <div class="col-md-6" align="right">                
                                    <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar Cuenta</button>
                                </div>
                            </div>
                        </form> 
                    </div>                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ===========<<<<<<<<<<<<< MODAL CUENTAS>>>>>>>>================-->

    <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
                <div id='msg'></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE END>>>>>>>>================-->


<!--******************** Modal solicitud nueva o listado ********************************-->
<div class="modal fade" id="modalMsgConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Villa Tours | Pagos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id='msgconfirm'></div>
      </div>
      <div class="modal-footer">
        <button  type="button" id="opcionsi" onclick="reload();" class="btn btn-success">SI</button>
        <button  type="button" id="opcionno" onclick="listado();" class="btn btn-warning">NO</button>
      </div>
    </div>
  </div>
</div>
<!-- ***************************************************************************************** -->

    <script>
         $(document).ready(function () {

          $("#jqGridCECOS").jqGrid({
            url:'../Controllers/listarCecos.php',
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [        
                {label: 'Id', name: 'id', width: 4, hidden:true},
                {label: 'Área', name: 'area', width: 25, key: true},
                {label: 'CECOS', name: 'ceco', width: 10, key: true},
            ],
            loadonce: true,
            viewrecords: true,
            // autowidth: true,
            width:440,
            height:250,
            rowNum: 2000,
            multiselect: true
            // rowList : [7,10,15],
            // pager: '#jqGridPager' 

          });
          jQuery("#jqGridCECOS").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:"cn"});

          $(".ui-pg-selbox").removeClass("ui-pg-selbox");

          $("#jqGridCuentas").jqGrid({
            url:'../Controllers/listarCuentas.php?id=' + 1,
            datatype: "json",
            styleUI : 'Bootstrap',
            colModel: [

                {label: 'Id', name: 'id', width: 50, key: true, hidden:true},
                {label: 'Banco', name: 'banco', width: 180 },    
                {label: 'Número Cuenta', name: 'num_cuenta', width: 180 },
                {label: 'Clabe Interbancaria', name: 'clabeinter', width: 180 },
                {label: 'Clabe SAT', name: 'claveSAT', width: 85 },
                {label: 'Cod Santander', name: 'codSantader', width: 70},
                {label: 'Divisa', name: 'divisa', width: 70},
            ],
            loadonce: true,
            viewrecords: true,
            scroll :true,
            autowidth: true
        });

      });

      function getRowsCecos() {
            var grid = $("#jqGridCECOS");
            var rowKey = grid.getGridParam("selrow");

            if (!rowKey){

                $('#msg').text('Error: No se selecciono ningun centro de costo');
                $("#modalMsg").modal('show');

            }else {
                var selectedIDs = grid.getGridParam("selarrrow");
                var answer = "";
                for (var i = 0; i < selectedIDs.length; i++) {
                    answer += selectedIDs[i] + " | ";
                }
                answer = answer.slice(0,-2);
                $("#cecos").val(answer);
                $("#modalCECOS").modal('toggle');
                // alert(result);
            }
        }
    </script>
    
    <!--===========<<<<<<<<<<FUNCION DE GUARDAR USUARIO START>>>>>>>>===========-->
    <script type="text/javascript">
        $("#formPagos").on("submit", function(e){
            $('#monedaPago').prop("disabled", false);
            $("#solicitarPago").prop("disabled", true);
            $("#process").css("display", "inline");
                $("#txtprocess").css("display", "inline");
                e.preventDefault();
                var formData = new FormData(document.getElementById("formPagos"));
                $.ajax({
                    url: "../Controllers/registraSolicitud.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                       // alert(res);
                        if(res == 1){

                            $('#msgconfirm').html('Correcto: La solicitud de pago fue enviada con éxito. ¿Desea registrar otra solicitud?');
                            $("#modalMsgConfirm").modal('show');
                            $("#process").css("display", "none");
                            $("#txtprocess").css("display", "none");
                            $("#solicitarPago").prop("disabled", false);
                            // setTimeout(function () {
                            //     location.reload();
                            // }, 1000);
                        }else{
                            $('#msgconfirm').html('Error: No se pudo completar el proceso de solicitud, revisar la información y volver a intentar');
                            $("#modalMsgConfirm").modal('show');
                            $("#process").css("display", "none");
                            $("#txtprocess").css("display", "none");
                            $("#solicitarPago").prop("disabled", false);
                        }

                     //swal('Muy Bien!', 'Evento Agregado!', 'success');
                       //  setTimeout(function () {
                         //   location.reload();
                        //}, 1000);
                    
                    });
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });

function importeconletra(){
  
  var monto = $('#monto').val();
  var moneda = $('#moneda').val();
  if(moneda == ""){
      return;
  }
  if (monto==''){
      return;
  }else{
      $.ajax({                        
      url: '../Controllers/importeconletra.php',
      type: "POST",
      data: "monto="+monto+"&tipocam="+moneda,
      success: function(datos){
          document.getElementById("montoletra").value = datos;
          var x = document.getElementById("montoletra");
          x.value = x.value.toUpperCase();
      }
      });


    //   if(moneda == "Pesos"){
    //       $("#tipocambio").val("1");
    //       $("#monedaPago").val("Pesos");
    //       $("#conversion").val(monto);
    //   }else{
    //       $("#tipocambio").val("");
    //       $("#monedaPago").val("");
    //       $("#conversion").val("");
    //   }

    $("#tipocambio").val("1");
    $("#monedaPago").val(moneda);
    $("#conversion").val(monto);


  }
}
        $(document).ready(function(){
		    $('#proveedor').keyup(function(event){
		      VerCliente();
		    });
		});
		function VerCliente(){
	          $.getJSON('../Controllers/autoProveedor.php?',function(data){
	              $( "#proveedor" ).autocomplete({
	                source: data
	              });
	          });
		 }
         function reload(){
             setTimeout(function () {
                location.reload();
            }, 1000);
         }

         function listado(){
            window.location.href = 'solicitudes.php';
         }

         function listarSolicitudes(){
            window.location.href = 'solicitudes.php';
         }


//********************* AGREGAR PROVEEDOR ***********************

$('#formNewProv').submit(function(e){
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
                url: "../Controllers/agregaProveedorPagos.php",
                        type: "POST",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                }).done(function(res) {

                    if(res==1){
                        $('#formNewProv')[0].reset();
                        $("#proceso").css("display", "none");
                        $("#txtproceso").css("display", "none");
                        $('#btnNewProv').prop('disabled', false);

                            $("#modalProvier").modal('hide');
                            $('#msg').text('El proveedor se registro con éxito, notificación enviada al área de Contabilidad');
                            $("#modalMsg").modal('show');
                            //return false();
                            // setTimeout(function () {
                            //     location.reload();
                            // }, 1000);
                        }else if(res == 0){
                            $("#proceso").css("display", "none");
                            $("#txtproceso").css("display", "none");
                            $('#btnNewProv').prop('disabled', false);

                            $("#modalProvier").modal('hide');
                            $('#msg').text('Error: No se pudo registrar el proveedor, favor de revisar la informacion e intentarlo nuevamente');
                            $("#modalMsg").modal('show');
                        }else if(res == 2){
                            $("#proceso").css("display", "none");
                            $("#txtproceso").css("display", "none");
                            $('#btnNewProv').prop('disabled', false);

                            $("#modalProvier").modal('hide');
                            $('#msg').text('Error: Los archivos no son compatibles, por favor seleccione archivos con extensión (.pdf)');
                            $("#modalMsg").modal('show');
                        }  
                        
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
    <!--===========<<<<<<<<<<FUNCION DE GUARDAR USUARIO END>>>>>>>>===========-->
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



    function poblarBancosExtra(){
        var proveedor = $("#proveedor").val();
        $.ajax({
            url: '../Controllers/poblarCuentas.php',
            type: 'post',
            data: {proveedor:proveedor},
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#bancoCuenta").empty();
                $("#bancoCuenta").append("<option value='0'>Selecciona una cuenta</option>");
                for( var i = 0; i<len; i++){
                    var idCuenta = response[i]['id'];
                    var banco = response[i]['banco'];
                    var cuenta = response[i]['cuenta'];
                    $("#bancoCuenta").append("<option value='"+idCuenta+"|"+banco+"|"+cuenta+"'>"+banco+"|"+cuenta+"</option>");
                }
            }
        });
    }

    

    
   function listadoCuentas(){
        $("#collapseFormCuentas").collapse('hide');
        $("#collapseListaCuentas").collapse('show');
        $("#modalCuentas").modal('show');

        var proveedor = $("#proveedor").val();
        var provier = proveedor.split("|");
        var key = provier[0];
        // alert(key);
        $('#jqGridCuentas').jqGrid('setGridParam',{url:'../Controllers/listarCuentas.php?id=' + key , datatype:'json',type:'GET'}).trigger('reloadGrid');
    }

    function poblarDatosExtra(){
        
        var proveedor = $("#proveedor").val();
        $.ajax({
            url: '../Controllers/poblarDatosExtra.php?proveedor='+proveedor,
            type: "POST",
            // data: {proveedor:proveedor},
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false
            }).done(function(res){
                // alert(res);
                var datosExtra = res.split("|");
                $("#_aba").val(datosExtra[0]);
                $("#_swift").val(datosExtra[1]);
            });
    }

    function conversionDivisa(){
        var resultado = 0;
        if($("#monedaPago").val() != ""){
            if($("#moneda").val() == "Pesos"){
                resultado = (parseFloat($("#monto").val()) / parseFloat($("#tipocambio").val()));
            }else{
                resultado = (parseFloat($("#monto").val()) * parseFloat($("#tipocambio").val()));
            }
            $("#conversion").val(resultado.toFixed(2));  //Resultado
        }
    }


    

</script>

<script>
$( document ).ready(function() {
var id = "<?php echo $idVendedor; ?>";
$("#tipoSolicitud").empty();

$.ajax({
method: "POST",
url: "../Controllers/poblarTipoSolicitud.php",
data: {idUsuario : id},
dataType: 'json',
}).done(function(res) {
    //alert(res.length);

    $("#tipoSolicitud").append("<option value=''>Selecciona un tipo de solicitud</option>");

    if(res.length == 1){
        
        $.each(res, function(key, item) {
        $("#tipoSolicitud").append("<option value='"+item.identificadorTipo+"' selected>"+item.tipo+"</option>");
        });


    }else if(res.length > 1){

        $.each(res, function(key, item) {
        $("#tipoSolicitud").append("<option value='"+item.identificadorTipo+"'>"+item.tipo+"</option>");
        });

    }
    

});

});
</script>
<!--****************************** Función agregar Cuenta ***************************-->
<script>
    function crearCuenta(){//al proveedor se le asigna una cuenta segun su id en el listado
    var proveedor = $("#proveedor").val();
    var provier = proveedor.split("|");
    var idprov = provier[0];
    //alert(idprov);
    if(idprov == ""){
        $("#modalCuentas").modal("hide");
        $('#msg').text('Error: Se debe elegir un proveedor antes de agregar una cuenta');
        $("#modalMsg").modal('show');
        return false;
    }
    $("#idproveedor").val(idprov);
    
    $("#formNuevaCuenta").on("submit", function(e){

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

            e.preventDefault(); //stop default action                
            $("#formNuevaCuenta").off();//off. to stop multiple form submit.
            var formData = new FormData(document.getElementById("formNuevaCuenta"));
            formData.append("envioCorreo","si");
            $.ajax({
                url: "../Controllers/agregaCuenta.php",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
                }).done(function(res){
                    $("#loadGif").html("");

                    if(res==1){
                        $("#formNuevaCuenta")[0].reset();
                        $("#collapseFormCuentas").collapse('hide');
                        //$('#msg').text('SE AGREGO CON EXITO LA CUENTA');
                        //$("#modalCuentas").modal('hide');
                        //$("#modalMsg").modal('show');
                        $('#jqGridCuentas').jqGrid('setGridParam',{url:'../Controllers/listarCuentas.php?id=' + idprov , datatype:'json',type:'GET'}).trigger('reloadGrid');
                        poblarBancosExtra();
                        return falase();
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

   }


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








function poblarClabeInterbancaria(){
        var bancoCuenta = $("#bancoCuenta").val();
        $.ajax({
            url: '../Controllers/poblarClabeInterancaria.php',
            type: 'POST',
            data: {bancoCuenta:bancoCuenta},
            dataType: 'html',
            success:function(answerC){
                //alert(answerC);
                var dividido = answerC.split("[_]");
                $("#cuentaBanco").val(dividido[0]);
                $("#banco").val(dividido[1]);
                $("#clabeinter").val(dividido[2]);
                $("#clavesat").val(dividido[3]);
                $("#nosantander").val(dividido[4]);
            }
        });
    }

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

function isNumberKey1(evt){

    var divisaCuenta = $("#divisa").val();
    if (divisaCuenta != "MXN") {

        return true

    }else{
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;

    }
    
   
}

function isNumberKey(evt){
    
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

 function cuentaDivisa(){


        $('#numCuenta').val('');

 }




//  $(document).ready(function(){
//    $('#clabeInter').on("cut copy paste",function(e) {
//       e.preventDefault();
//    });
// });

</script>
<!-- ************************************************** -->
</body>
</html>