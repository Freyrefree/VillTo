<?php
#parametros requeridos
include_once '../app/config.php'; #Configuracion
include_once str_replace(DS, "/", ROOT . 'Models/proveedor.php'); #Modelo Proveedor
$proveedor = new Proveedor();
#parametros requeridos

#Recepcion de datos $_POST
if (!$_POST) {
    header('Location: ' . URL . 'Administracion/proveedores.php');
    exit;
}else{
    $id=$_POST['id'];
}
#Recepcion de datos $_POST

$proveedor->set('id',$id);
$proveedor->consultaProveedor();

$id=$proveedor->get('id');
$numproveedor=$proveedor->get('numproveedor');
$rfc=$proveedor->get('rfc');
$razonsocial=$proveedor->get('razonsocial');
$direccion=$proveedor->get('direccion');
$cp=$proveedor->get('cp');
$aliascomercial=$proveedor->get('aliascomercial');
$email=$proveedor->get('email');
$contacto=$proveedor->get('contacto');
$tel1=$proveedor->get('tel1');
$tel2=$proveedor->get('tel2');

$comunidad=$proveedor->get('comunidad');
$pais=$proveedor->get('pais');

$filecaratula=$proveedor->get('filecaratula');
$filecedula=$proveedor->get('filecedula');

$aba=$proveedor->get('aba');
$swift=$proveedor->get('swift');

$activo=$proveedor->get('activo');
$tipo=$proveedor->get('tipo');

$html='<form method="POST" id="formUpdateProveedor" enctype="multipart/form-data">
<div class="row">
    
    <div class="col-md-6">
        <label for="" class="">Número Proveedor :</label>
        <input type="hidden" name="key" id="key" class="form-control" value="'.$id.'">
        <input class="form-control" type="text" id="numproveedor" name="numproveedor" value="'.$id.'" placeholder="Número Proveedor" readonly>
    </div>

    <div class="col-md-6">
        <label for="" class="">RFC | TAX ID</label>
        <input type="text" name="rfc" id="rfc" value="'.$rfc.'" placeholder="RFC | TAX ID" class="form-control" required>
        <input type="hidden" name="rfcValidate" id="rfcValidate" value="'.$rfc.'">
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Razón Social: </label>
        <input class="form-control" type="text" value="'.utf8_encode($razonsocial).'" placeholder="Razón Social" id="razonsocial" name="razonsocial" required>
        <input type="hidden" value="'.utf8_encode($razonsocial).'" id="razonsocialValidate" name="razonsocialValidate">
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Alias Comercial: </label>
        <input class="form-control" type="text" id="aliascomercial" value="'.$aliascomercial.'" placeholder="Alias Comercial" name="aliascomercial" required>
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Direccion: </label>
        <input class="form-control" type="text" id="direccion" value="'.$direccion.'" placeholder="Direccion" name="direccion" required>
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Direccion: </label>
        <input class="form-control" type="text" id="direccion" value="'.$direccion.'" placeholder="Direccion" name="direccion" required>
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Correo: </label>
        <input class="form-control" type="email" id="email" value="'.$email.'" placeholder="ejemplo@mail.com" name="email" required>
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Contacto: </label>
        <input class="form-control" type="text" id="contacto" value="'.$contacto.'" placeholder="Contacto" name="contacto" required>
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Teléfono: </label>
        <input class="form-control" type="text" id="tel1" value="'.$tel1.'" placeholder="Teléfono 1" name="tel1">
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Teléfono 2: </label>
        <input class="form-control" type="text" id="tel2" value="'.$tel2.'" placeholder="Teléfono 2" name="tel2">
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">Nacionalidad: </label>
        <select id="comunidad" name="comunidad" class="form-control" required>
            <option value="">Selecciona una Opción</option>
            <option value="1">Nacional</option>
            <option value="2">Extranjero</option>                                        
        </select>
    </div>
                           
    <div class="col-md-5">
            <label for="" class="col-form-label">País: </label>
            <select id="pais2" name="pais2" class="form-control" required>                                                                                                                     
            </select>
    </div>

    <div class="col-md-1">
        <label for="" class="col-form-label">C.P.: </label>
        <input class="form-control" type="text" id="cp" value="'.$cp.'" placeholder="CP" name="cp">
    </div>
                                
    <div class="col-md-6">
            <label for="" class="col-form-label">Archivo Carátula: </label>
            <input  type="hidden" value="'.$filecaratula.'" id="filecaratulahidd" name="filecaratulahidd" accept=".pdf,.png,.jpg">
            <input class="btn btn-info btn-sm" type="file" id="filecaratula" name="filecaratula" >
            <small class="form-text text-muted">Archivos requeridos(.pdf|.png|.jpg)</small>                           
    </div>

    <div class="col-md-6">
            <label for="" class="col-form-label">Archivo Cédula: </label>
            <input  type="hidden" value="'.$filecedula.'" id="filecedulahidd" name="filecedulahidd" accept=".pdf,.png,.jpg">
            <input class="btn btn-info btn-sm" type="file" id="filecedula" name="filecedula" >
            <small class="form-text text-muted">Archivos requeridos(.pdf|.png|.jpg)</small>
    </div>
                                            
    <div class="col-md-6">
        <label for="" class="col-form-label">ABA: </label>
        <input class="form-control" type="text" id="aba" value="'.$aba.'" placeholder="ABA" name="aba" >
    </div>

    <div class="col-md-6">
        <label for="" class="col-form-label">SWIFT: </label>
        <input class="form-control" type="text" id="swift" value="'.$swift.'" placeholder="SWIFT" name="swift" >
    </div>
</div>';


$html.='<br/>
<div class="row">    
    <div class="col-md-8">
        <button type="submit" class="btn btn-primary wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-check-circle" aria-hidden="true"></i> Modificar</button>
        <button type="button" name="listadoproveedor2" id="listadoproveedor2" class="btn btn-default wow btn-md fadeInDown" data-wow-delay="0.2s"> Listado</button>
    </div>
    <div class="col-md-2">
    </div>
</div>
</form>';
echo $html;
                        //<a href="javascript:restablecer('.$id.')"><button type="button" class="btn btn-success wow btn-md fadeInDown" data-wow-delay="0.2s"><i class="fa fa-refresh" aria-hidden="true"></i> Restablecer contraseña</button></a>
?>
<!-- ===========<<<<<<<<<<<<< MODAL MENSAJE START>>>>>>>>================-->
    <div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary">
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
 <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO START>>>>>>>>===========-->
    <script type="text/javascript">

$('#formUpdateProveedor').submit(function(e){
    e.preventDefault();
    var formData = new FormData(document.getElementById("formUpdateProveedor"));




            $.ajax({
                    url: "../Controllers/modificaProveedor.php",
                        type: "POST",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
            }).done(function(res){
                if(res==1){
                    $('#msg').text('SE MODIFICO PROVEEDOR CON EXITO');
                    $("#modalMsg").modal('show');
                    setTimeout(function () {
                    location.reload();
                    }, 1000);
                }else if(res == 0){
                    $('#msg').text('Error: ocurrio un error en la modificación del proveedor favor de revisar la informacion e intentarlo nuevamente');
                    $("#modalMsg").modal('show');
                }else if(res == 2){
                    $('#msg').text('Error: Los archivos no son compatibles, por favor seleccione archivos con extensión (.pdf)');
                    $("#modalMsg").modal('show');
                }else if(res == "4"){
                    $('#msg').text('Lo sentimos, ya existe un proveedor con la razón social ingresada.');
                    $("#modalMsg").modal('show');

                }else if(res == "5"){
                    $('#msg').text('Lo sentimos, ya existe un proveedor con el rfc ingresado.');
                    $("#modalMsg").modal('show');

                }
            });
        });



    </script>
    <!--===========<<<<<<<<<<FUNCION DE MODIFICAR USUARIO END>>>>>>>>===========-->
        <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO START>>>>>>>=========-->
    <script type="text/javascript">
        $("#listadoproveedor2").click(function(){
            $("#formUpdateProveedor")[0].reset();
            $("#collapseTwo").collapse('hide');
            $("#collapseOne").collapse('show');
        })
    </script>
    <!--===========<<<<<<<<<<FUNCION DE MOSTRAR EL LISTADO END>>>>>>>=========-->
<!--===========<<<<<<<<<<FUNCION COMBO PAIS ARCHIVOS START>>>>>>>=========-->
<script type="text/javascript">

$(document).ready(function(){
var comunidad = "<?php echo $comunidad ?>";
var tipo = "<?php echo $tipo ?>";
$('select[name=comunidad]').val(comunidad);
$('select[name=tipopro]').val(tipo);
}); 

$(document).ready(function(){

  var c_pais = "<?php echo $pais; ?>";
  var c_pais2 =unescape(encodeURIComponent(c_pais));

//   $("#comunidad").change(function(){
//   var valueComunidad = $(this).val();

    $.ajax({
        url: '../Controllers/comboPais.php',
        type: 'post',
      //  data: {pais:pais},
        dataType: 'json',
        success:function(response){
            var len = response.length;

            $("#pais2").empty();
            $("#pais").append("<option value='0'>Selecciona un País</option>");
            for( var i = 0; i<len; i++){
                var c_pais = response[i]['c_pais'];
                var nombre_pais = response[i]['nombre_pais'];
                
                $("#pais2").append("<option value='"+c_pais+"'>"+ nombre_pais +"</option>");

            }
            $('select[name=pais2]').val(c_pais2);
//             if(valueComunidad == 1){
//                 $('select[name=pais2]').val('MEX');
//                 //$("#pais").append("<option value='MEX'>México</option>");
//                 $("#pais2").attr('readonly', true);
//                 $("#divaba").hide();
//     $("#divswift").hide();
                
//             }
//             else{

//     $("#pais2").attr('readonly', false);
//                 $("#divaba").show();
//     $("#divswift").show();
// }            
        }
   // });
});

}); 
</script>
<!--===========<<<<<<<<<<FUNCION COMBO PAIS ARCHIVOS END>>>>>>>===========-->