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
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/solicitud.php'); #Modelo solicitud
$solicitud = new Solicitud();
#parametros requeridos
$envio = false;
$idSolicitud = $_GET["id"];
$solicitud->set('id', $idSolicitud);
$answer  = $solicitud->buscarSolicitud();
while($row = mysqli_fetch_array($answer)){
    #validacion estatus salir si ya se autorizo por el nivel actual
    $estatus = $row["estatus"];
    if($estatus != "aceptada" && $estatus != "Aceptado" && $estatus != "Aceptado DF" && $estatus != "Aceptado DG"){
        echo '<body>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                        <h5 style="float:left">Solicitudes / Pagos / Autorización</h5>
                        <div class="col-md-3" style="text-align: right;float:right;">
                        </div>
                    </div>
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <h4><i class="fa fa-hand-paper-o" aria-hidden="true"></i> La solicitud de pago con el Folio: <strong>'.$idSolicitud.' </strong> Ya fue '.$estatus.' previamente!!</h4>
                                <br><br>
                                <small class="form-text text-muted">Revisar el listado de solicitudes para conocer el estatus de la solicitud.</small>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </body>
    </html>';
    exit;
    }
    #validacion estatus salir si ya se autorizo por el nivel actual
}
$solicitud->set('estatus', "Pago Programado");
$answer2  = $solicitud->actualizaEstatus();
if($answer2){
    $envio = true;
}

?>
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-block titulo bg-primary">
                    <h5 style="float:left">Solicitudes / Pagos / Autorización CXP</h5>
                    <div class="col-md-3" style="text-align: right;float:right;">
                    </div>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block">
                    <div class="row">
                        <div class='col-md-12'>
                            <?php if($envio == true){ ?>
                            <h5><i class="fa fa-check-circle-o fa-1x" aria-hidden="true"></i> La solicitud de pago con el <strong>Folio: <?= $idSolicitud; ?> </strong> se ha aceptado y programado para pago!!</h5>
                            <br><br>
                            <small class="form-text text-muted">Para confirmar los datos puede acceder al sistema.</small>
                            <?php }else{ ?>
                            <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error al intentar aceptar y programar la solicitud de pago. Favor de intentarlo mas tarde.</h4>
                            <br><br>
                            <small class="form-text text-muted">Si el problema persiste favor de comunicarse con su administrador.</small>
                            <?php } ?>
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