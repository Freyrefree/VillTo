<?php

$idUsuario  = $_SESSION['_pid'];
$perfil     = $_SESSION['_prol'];
$contrasena = $_SESSION['_ppass'];

?>

<!-- .navbar -->
<style>
    .btn{
        /* box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); */
    }
    .btn:hover {
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
    }

    ::-webkit-scrollbar {
        width: 5px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 50px rgba(0,0,0,0.3); /* 105,106,110 */
        border-radius: 0px;
    }
        
    ::-webkit-scrollbar-thumb {
        border-radius: 30px;
        -webkit-box-shadow: inset 0 0 20px rgba(21, 67, 96);
    }

</style>
<input type="hidden" name='estatuspass' id="estatuspass" value="<?=$contrasena?>">
    <nav class="navbar navbar-inverse sticky-top bg-primary flex-nowrap navbar-toggleable-sm">
        <!-- navbar-fixed-top -->
        <!--  -->
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex">
            <a class="navbar-brand" href="<?= URL; ?>Pagos/inicio.php"><strong><h5>Villa Tours | Pagos</h5></strong></a>
            <!-- Villa Tours -->
            <!--mt-1-->
            <!--navbar-text -->
        </div>
        <div class="navbar-collapse collapse justify-content-between" id="collapsingNavbar">
            <!--justify-content-end-->
            <ul class="navbar-nav">
                <?php if($perfil == 1 || $perfil == 2 || $perfil == 3 || $perfil == 4 || $perfil == 5 || $perfil == 6){ ?>
                    <li class="nav-item dropdown bg-primary">
                        <a class="nav-link dropdown-toggle bg-primary" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Solicitud Pagos</a>
                        <div class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                            <a class="dropdown-item bg-primary inverse" href="<?= URL; ?>Pagos/nuevaSolicitud.php">Nueva Solicitud</a>
                            <a class="dropdown-item bg-primary inverse" href="<?= URL; ?>Pagos/solicitudes.php">Listado Solicitudes</a>
                            <!-- <a class="dropdown-item bg-primary inverse" href="<?//= URL; ?>Pagos/nuevoGrupo.php">Reembolso Pago</a> -->
                        </div>
                    </li>
                <?php } ?>
                <?php if($perfil == 1 || $perfil == 2){ ?>
                    <!-- $perfil == 2 ||  -->
                    <li class="nav-item dropdown bg-primary">
                        <a class="nav-link dropdown-toggle bg-primary" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administración</a>
                        <div class="dropdown-menu bg-primary" aria-labelledby="dropdown01">
                            <?php if($perfil == 1){ ?><a class="dropdown-item bg-primary inverse" href="<?= URL; ?>Administracion/Areas.php">Áreas | cecos</a><?php } ?>
                            <?php if($perfil == 1 || $perfil == 2){ ?><a class="dropdown-item bg-primary inverse" href="<?= URL; ?>Administracion/usuarios.php">Usuarios</a><?php } ?>
                            <?php if($perfil == 1 || $perfil == 3){ ?><a class="dropdown-item bg-primary inverse" href="<?= URL; ?>Administracion/proveedores.php">Proveedores</a><?php } ?>
                            <!-- <?php if($perfil == 1){ ?><a class="dropdown-item bg-primary inverse" href="<?= URL; ?>Administracion/cecos.php">CECOS</a><?php } ?> -->
                        </div>
                    </li>
                <?php } ?>
                <?php if($perfil == 0){ #|| $perfil == 3 || $perfil == 2 || $perfil == 4 ?>
                    <li class="nav-item bg-primary">
                        <a class="nav-link bg-primary" href="reportes.php">Reportes</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav flex-row">
                <!--<li class="nav-item"><a class="nav-link" href=""><i class="fa fa-facebook"></i></a></li>-->
                <li class="nav-item dropdown bg-primary">
                    <a class="nav-link dropdown-toggle bg-primary" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i> <?= $nombre ?> </a>
                    <div class="dropdown-menu bg-primary" aria-labelledby="dropdown02">
                     <!-- <a class="dropdown-item bg-primary inverse" href="" data-toggle="modal" data-target="#modalCambioPass"><i class="fa fa-edit" aria-hidden="true"></i> Contraseña</a> -->
                     <a class="dropdown-item bg-primary inverse" href="#" onclick = "cambiarPSW();"><i class="fa fa-lock" aria-hidden="true"></i> Cambiar <br/> Contraseña</a>
                     <a class="dropdown-item bg-primary inverse" href="<?= URL; ?>logout.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Salir</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="">&nbsp;</a></li>
                <li class="nav-item"><a class="nav-link" href="">&nbsp;</a></li>
            </ul>
        </div>
    </nav>
    <div  style="height:10px;"></div>
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
            <button type="button" class="btn btn-info" id="onoff" data-dismiss="modal">Cerrar</button>
            
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ===========<<<<<<<<<<<<< MODAL MENSAJE END>>>>>>>>================-->
    <!-- ===========<<<<<<<<<<<<< MODAL TABLA DETALLE START>>>>>>>>================-->
      <div id='modalCambioPass' class='modal fade '>
        <div class='modal-dialog'>
          <div class='modal-content' >
                    <div class='modal-header' style="background: #0275d8">
                        <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Cambio de Contraseña</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form name="formCambio" id="formCambio" method="POST">
                    <div class='modal-body'>
                        <input type="hidden" name="cambioid" id="cambioid" value="<?=$idUsuario?>">
                            <div class="col-md-12">
                                <label for="" class="">Correo:</label>
                                <input class="form-control" type="text" id="usuario" name="usuario"  placeholder="Correo" required>
                            </div>
                            <div class="col-md-12">
                              <label for="" class="">Contraseña Actual:</label>
                              <input class="form-control" type="password" id="actual" name="actual"  placeholder="Contraseña Actual" required>
                            </div>
                            <div class="col-md-12">
                              <label for="" class="">Nueva Contraseña:</label>
                              <input class="form-control" type="password" id="nueva" name="nueva"  placeholder="Nueva Contraseña" required>
                            </div>
                            <div class="col-md-12">
                              <label for="" class="">Confirmar nueva contraseña:</label>
                              <input class="form-control" type="password" id="confirmacion" name="confirmacion"  placeholder="Confirmacion de Contraseña" required>
                            </div>
                    </div>
                    <div class='modal-footer'>
                        <input type="submit" name="guardar" id="guardar" value="Guardar" class="btn btn-success">
                        <button type='button' class='btn btn-info' data-dismiss='modal'>cerrar</button>
                     
                    </div>
                    </form>
                </div>
            </div>
        </div> 
    <!-- ===========<<<<<<<<<<<<< MODAL TABLA DETALLE END>>>>>>>>================-->
    <script >
    function cambiarPSW(){
        $("#modalCambioPass").modal("show");
    }

        $(document).ready(function () {
            var valorestatus= $("#estatuspass").val();
            if(valorestatus != "si"){
                $("#modalCambioPass").modal("show");
            }
        });
    </script>
    <script type="text/javascript">
        $("#formCambio").on("submit", function(e){
                e.preventDefault();
                var formData = new FormData(document.getElementById("formCambio"));
                $.ajax({
                    url: "../Controllers/cambioPassword.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                        if(res != 1){
                            $("#modalCambioPass").modal("hide");
                            $("#msg").html("¡Datos Incorrectos!");
                            $("#modalMsg").modal("show");
                            
                        }else{
                            $("#modalCambioPass").modal("hide");
                            $("#msg").html("Se Modifico la contraseña con exito");
                            $("#modalMsg").modal("show");

                            setTimeout(function () {
                                window.location.replace("../logout.php");
                            }, 1000);
                        }
                       
                                           
                    });
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });
    </script>
        <style type="text/css">
        .ui-jqgrid .ui-search-table td.ui-search-clear {
            display: none;
        }    
        </style>