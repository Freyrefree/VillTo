<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="" type="image/vnd.microsoft.icon" />
    <title>Villa Tours | Pagos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <script src="../js/jquery-3.1.1.js"></script>
    
    <script type="text/javascript" src="../js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <style>
    .titulo{
            color: #F2F2F2;
            padding: 15px;
        }
    </style>

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
            <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>
</head>

<?php
$usuarioS = $_GET['nombreContabilidadCorreo']; // variable para log
$_folioc = $_GET['id'];
?>

<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-block titulo bg-primary">
                    <h5 style="float:left">Solicitudes / Pagos / Carga TXT / Contabilidad</h5>
                    <div class="col-md-3" style="text-align: right;float:right;">
                    </div>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block">
                    <div class="row">
                        <div class='col-md-12'>
                            <h5> La solicitud con el <strong>Folio: <?php echo $_folioc; ?> 
                            </strong> requiere de un archivo .txt (opcional).</h5>
                        </div>
                        <div class='col-md-12'>
                            <form method="POST" id="formComprobantes">
                                <input class="form-control" type="hidden" id="_folioc" name="_folioc" value = <?php echo $_folioc; ?>>
                                <div class="row">
                                <!-- <div class="col-md-5"> -->
                                <!-- <label for="" class="col-form-label">* No. comprobante(s): </label> -->
                                    <!-- <input class="form-control" type="text" id="Nocomprobantes" name="Nocomprobantes" placeholder="00000 | 00001" aria-describedby="inputHelp"> -->
                                    <!-- <small id="inputHelp" class="form-text text-muted"></small> -->
                                <!-- </div> -->
                                <div class="col-md-12">
                                <label for="" class="col-form-label">* Comprobante(s): </label>
                                    <br>
                                    <input type="file" class="form-control-file btn btn-primary btn-sm" id="comprobantes" name="comprobantes"  accept=".txt">
                                    <small id="fileHelp" class="form-text text-muted">Cargar su archivo en formato y extencion (.txt).</small>
                                </div>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-md " ><i class="fa fa-floppy-o" aria-hidden="true"></i> Continuar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html>

<script>

$("#formComprobantes").on("submit", function(e){
    e.preventDefault();
    var formData = new FormData(document.getElementById("formComprobantes"));
    formData.append("nombreContabilidadCorreo","<?php echo $usuarioS; ?>");
    $.ajax({
        url: "cargaTXT.php",
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
        }).done(function(res){
            //console.log(res);
            if(res=="1"){

                location.href = "AceptarSolicitudContabilidad.php?id="+ <?php echo $_folioc; ?>+"&nombreContabilidadCorreo=" + "<?php echo $usuarioS; ?>";
            }else if(res == "0"){
                $('#msg').text('Error: No se pudo completar el proceso carga de txt');
                $("#modalMsg").modal('show');
            }else if(res == "3"){

                location.href = "AceptarSolicitudContabilidad.php?id="+ <?php echo $_folioc; ?>+"&nombreContabilidadCorreo=" + "<?php echo $usuarioS; ?>";

            }
        });
    e.preventDefault(); //stop default action
});

</script>