<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/area.php'); #Modelo Usuario
$area = new Area();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/Areas.php');
    exit;
}else{
    $id=$_POST['id'];
}
#Recepcion de datos $_POST

$area->set('id',$id);
$area->consultaArea();

$id=$area->get('id');
$nombreArea= utf8_encode($area->get('nombreArea'));
$ceco=$area->get('ceco');


echo'<form method="POST" id="formUpdateDivisa">
        <div class="row">
        <!-- <div class="form-group row"> -->
            <div class="col-md-8">
                <label for="" class="">Nombre área:</label>
                <input class="form-control" type="text" id="nombreArea" name="nombreArea" value="'.$nombreArea.'"  placeholder="..." required>
                <label for="" class="">CECO:</label>
                <input class="form-control" type="text" id="ceco" name="ceco" value="'.$ceco.'"  placeholder="..." required>
                <input type="hidden" name="id" id="id" class="form-control" value="'.$id.'">
            </div>
        <!-- </div> -->
        
        <!-- </div> -->
        <div class="col-12">
            <br>
            <button type="submit" class="btn btn-info wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Modificar</button>
            
        </div>
        </div>
    </form>';
?>
<!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary" >
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
 <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO START>>>>>>>>===========-->
    <script type="text/javascript">
        $("#formUpdateDivisa").on("submit", function(e){
                e.preventDefault();
                var formData = new FormData(document.getElementById("formUpdateDivisa"));
                $.ajax({
                    url: "../Controllers/modificaArea.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){

                        $('#msg').text('SE MODIFICO EL ÁREA CON EXITO');
                        $("#modalMsg").modal('show');
                        setTimeout(function () {
                          location.reload();
                        }, 1000);
                     //swal('Muy Bien!', 'Evento Agregado!', 'success');
                       //  setTimeout(function () {
                         //   location.reload();
                        //}, 1000);
                    
                    });
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO END>>>>>>>>===========-->