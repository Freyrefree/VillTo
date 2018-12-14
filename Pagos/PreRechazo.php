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
</head>

<?php
    $idSolicitud = $_GET["id"];
    $usuarioLog = @$_GET["nombreGerenteCorreo"];
?>
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-block titulo bg-primary">
                    <h5 style="float:left">Solicitudes / Pagos / Rechazar / Gerencia</h5>
                    <div class="col-md-3" style="text-align: right;float:right;">
                    </div>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block">
                    <div class="row">
                        <div class='col-md-12'>
                            <h5> La solicitud con el <strong>Folio: <?= $idSolicitud; ?> </strong> Será rechazada.</h5>
                        </div>
                        <div class='col-md-12'>
                        <form method="POST" id="formRechazo" action="rechazarSolicitud.php">
                        <input type="hidden" name="usuarioLog" id="usuarioLog" value="<?php echo $usuarioLog; ?>">
                            <input class="form-control" type="hidden" value="<?= $idSolicitud; ?>" id="_folio" name="_folio">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="" class="col-form-label">* Motivo del rechazo: </label>
                                    <textarea class="form-control" id="motivo" name="motivo" placeholder="Descripción del rechazo" rows="3" required></textarea>
                                </div>
                                <div class="col-12">
                                    <br>
                                    <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Guardar</button>
                                    <!-- <button type="button" name='listado' id='listado' class="btn btn-info wow btn-md fadeInDown" data-wow-delay="0.2s"> Listado</button> -->
                                </div>
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