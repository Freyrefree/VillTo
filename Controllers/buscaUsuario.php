<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/usuario.php'); #Modelo Usuario

$usuario = new Usuario();
#parametros requeridos
$usrPerfil = $_SESSION['_prol'];
#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/usuarios.php');
    exit;
}else{
    $id=$_POST['id'];
}
#Recepcion de datos $_POST
$accion = "";
if($usrPerfil == 5 || $usrPerfil == 2){
    $accion = "disabled";
}

$usuario->set('id',$id);
$usuario->consultaUsuario();

$id=$usuario->get('id');
$nombre=$usuario->get('nombre');
$app=$usuario->get('app');
$apm=$usuario->get('apm');
$puesto=$usuario->get('puesto');
$correo=$usuario->get('correo');
$perfil=$usuario->get('perfil');
$idarea=$usuario->get('idarea');
$oficina=$usuario->get('oficina');
$nombrePerfil = "";
$opcion1="";
$opcion2="";
$opcion3="";
$opcion4="";
$opcion5="";
$opcion6="";
switch ($perfil) {
    case 1:
        $nombrePerfil = "Administrador";
        $opcion1="selected";
        break;
    case 2:
        $nombrePerfil = "Supervisor";
        $opcion2="selected";
        break;
    case 3:
        $nombrePerfil = "Ejecutivo";
        $opcion3="selected";
        break;
    case 4:
        $nombrePerfil = "Empleado";
        $opcion4="selected";
        break;
    case 5:
        $nombrePerfil = "Contabilidad";
        $opcion5="selected";
        break;
    case 6:
        $nombrePerfil = "Tesorería";
        $opcion6="selected";
        break;
        
}

echo'<form method="POST" id="formUpdateUser">
                            <div class="row">
                            <!-- <div class="form-group row"> -->
                            <div class="col-md-6">
                                    <label for="" class="">No:</label>
                                    <input class="form-control" type="text" name="key" id="key" class="form-control" placeholder="00000" value="'.$id.'" required>
                                    <input type="hidden" name="keyold" id="keyold" class="form-control" value="'.$id.'">
                            </div>

                                <div class="col-md-6">
                                    <label for="" class="">Nombre:</label>
                                    <input class="form-control" type="text" id="nombre" name="nombre" value="'.utf8_encode($nombre).'"  placeholder="Nombre" required>
                                    
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="">Apellido Paterno:</label>
                                    <input type="text" name="app" id="app" placeholder="Apellido Paterno" value="'.utf8_encode($app).'" class="form-control" required>
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Apellido Materno: </label>
                                    <input class="form-control" type="text" placeholder="Apellido Materno" value="'.utf8_encode($apm).'" id="apm" name="apm" required>
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Puesto: </label>
                                    <input class="form-control" type="text" id="puesto" placeholder="Puesto" value="'.utf8_encode($puesto).'" name="puesto" required>
                                </div>
                            <!-- </div> -->
                            
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Correo: </label>
                                    <input class="form-control" type="text" id="correo" value="'.$correo.'" placeholder="ejemplo@gmail.com" name="correo" required>
                                </div>
                            <!-- </div> -->
                            <!-- <div class="form-group row"> -->
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Perfil: </label>
                                    <select id="perfil" name="perfil" class="form-control" '.$accion.' >';
                          
                                       echo'<option value="1" '.$opcion1.' >Administrador</option>
                                            <option value="2" '.$opcion2.' >Supervisor</option>
                                            <option value="3" '.$opcion3.' >Ejecutivo</option>
                                            <option value="4" '.$opcion4.' >Empleado</option>
                                            <option value="5" '.$opcion5.' >Contabilidad</option>
                                            <option value="6" '.$opcion6.' >Tesorería</option>';
                                    
                                   
                                       
                                    echo '</select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Área: </label>
                                    <select id="area" name="area" class="form-control">
                                    <option value="">Elige una opcion</option>';
                                    include_once str_replace(DS,"/",ROOT.'Controllers/poblarArea.php');
                                    echo '</select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">Oficina: </label>
                                    <select id="oficina" name="oficina" class="form-control" required>
                                        <option value="">Elige una Oficina</option>';
                                         include str_replace(DS,"/",ROOT.'Controllers/poblarOficinas.php');
                                    echo'</select>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">* Contraseña: </label>
                                    <input class="form-control" type="text" id="contrasena" name="contrasena" placeholder="**************">
                                </div>
                            <!-- </div> -->
                            <!-- </div> -->
                            <div class="col-md-8">
                                <br>
                                <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Modificar</button>
                                <button type="button" name="listado2" id="listado2" class="btn btn-default wow btn-md fadeInDown" data-wow-delay="0.2s"> Listado</button>
                            </div>
                            <div class="col-md-2"><br>
                             
                            </div>
                            </div>
                        </form>';
                        //<a href="javascript:restablecer('.$id.')"><button type="button" class="btn btn-success wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-refresh" aria-hidden="true"></i> Restablecer contraseña</button></a>
?>
<!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLongTitle">Villa Tours | Usuario</h5>
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
        $("#formUpdateUser").on("submit", function(e){
            $('select[name="perfil"]').prop('disabled', false);
                e.preventDefault();
                var formData = new FormData(document.getElementById("formUpdateUser"));
                $.ajax({
                    url: "../Controllers/modificaUsuario.php",
                    type: "POST",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                    }).done(function(res){
                        if(res==1){
                            $('#msg').text('SE MODIFICO USUARIO CON EXITO');
                            $("#modalMsg").modal('show');
                            setTimeout(function () {
                            location.reload();
                            }, 1000);
                        }else if(res == 0){
                            $('#msg').text('Error: ocurrio un error en la modificación favor de revisar la informacion e intentarlo nuevamente');
                            $("#modalMsg").modal('show');
                        }else if(res == 2){
                            $('#msg').text('Error: ocurrio un error en la modificación favor de revisar la informacion e intentarlo nuevamente');
                            $("#modalMsg").modal('show');

                        }
                    });
                e.preventDefault(); //stop default action
                //e.unbind(); //unbind. to stop multiple form submit.
            });
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO END>>>>>>>>===========-->
        <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO START>>>>>>>=========-->
    <script type="text/javascript">
        $("#listado2").click(function(){
              $("#formUpdateUser")[0].reset();
            $("#collapseTwo").collapse('hide');
            $("#collapseOne").collapse('show');
        })
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO END>>>>>>>=========-->
    <script>
        function restablecer(id){
              $.ajax({
                    url: "restablecePass.php",
                    type: "POST",
                    dataType: "html",
                    data: "id="+id,
                    }).done(function(res){
                        $('#msg').text('SE REESTABLECIO LA CONTRASEÑA');
                        $("#modalMsg").modal('show');
                        
                     //swal('Muy Bien!', 'Evento Agregado!', 'success');
                       //  setTimeout(function () {
                         //   location.reload();
                        //}, 1000);
                    
                    });

        }
    </script>

    <!-- Funcion para selecionar por defecto el area y la oficina -->
    <script>
    $( document ).ready(function() {
        
        var area = '<?php echo $idarea; ?>';
        var oficina = '<?php echo $oficina; ?>';
       
        $("#area").val(area);        
        $('select[name="oficina"]').val(oficina);
    });


    </script>
    <!-- ******************************************************** -->

<!-- Funcion validar si es supervisor solo pueda modificar a ejecutivo -->
<script>
// $(document).ready(function() {

//     var perfil = "<?php echo $_SESSION['_prol']; ?>";

//     if(perfil == 2){

//         $('select[name="perfil"]').prop('readonly', true);
//         $('select[name="perfil"]').prop('disabled', true);
//         $('select[name="perfil"]').val(3);

//     }
// });
</script>

<!-- ******************************************************** -->