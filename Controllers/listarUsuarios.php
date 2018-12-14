<?php
include_once '../app/config.php'; #Configuracion
// echo str_replace("world","Peter","Hello world!");
#                 Hello Peter!
// echo str_replace(DS,"/",ROOT.'Models/usuario.php');
include_once str_replace(DS,"/",ROOT.'Models/usuario.php');

$usrPerfil = $_SESSION['_prol'];
// include_once URL.'Models/usuario.php';
$usuario = new Usuario();
$answer  = $usuario->listarUsuarios();
$data=array();
$perfil = "";
while($row = mysqli_fetch_array($answer)){//odbc_fetch_array($answer)) { ,MYSQLI_ASSOC

  if($row['perfil'] == 1){ 
    $perfil='Administrador';
  }else if($row['perfil'] == 2){
    $perfil='Supervisor';
  }else if($row['perfil'] == 3){
    $perfil='Ejecutivo';
  }else if($row['perfil'] == 4){
    $perfil='Empleado';
  }else if($row['perfil'] == 5){
    $perfil ='Contabilidad';
  }else if($row['perfil'] == 6){
    $perfil ='Tesoreria';
  }
  
  $operacion = "";

  $idFunction = '"'.$row['id'].'"';
  if($usrPerfil == 5){
    $operacion = "<a href='javascript:editar(".$idFunction.")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;";
  }else{
    $operacion = "<a href='javascript:editar(".$idFunction.")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$idFunction.")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:asignaciones(".$idFunction.")' title='Asignaciones' class='verde'><i class='fa fa-users' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:reasignaciones(".$idFunction.")' title='Reasignaciones' class='naranja'><i class='fa fa-users' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;";
    // <a href='javascript:permisos(".$row['id'].")' title=Permisos class='azul'><i class='fa fa-address-card' aria-hidden='true'></i></a>
  }
  $data[] = array(
    
    'id'      => $row['id'],
    'nombre'  => utf8_encode($row['nombre']).' '.utf8_encode($row['apellidoPaterno']).' '.utf8_encode($row['apellidoMaterno']),
    'puesto'  => utf8_encode($row['puesto']),
    'correo'  => utf8_encode($row['correo']),
    'perfil'  => $perfil,
    'ceco'    => $row['ceco'],
    'area'    => utf8_encode($row['nombreArea']),
    // 'operacion' => "<a href='javascript:editar(".$row['id'].")' class='azul'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:eliminar(".$row['id'].")' class='rojo'><i class='fa fa-trash' aria-hidden='true'></i></a>&nbsp;&nbsp;&nbsp;<a href='javascript:asignaciones(".$row['id'].")' title='Asignaciones' class='verde'><i class='fa fa-users' aria-hidden='true'></i></a>",
    'oficina' => utf8_encode($row['oficina']),
    'operacion' => $operacion,

    );
    //class='btn btn-warning'
    //class='btn btn-danger'
}

echo json_encode($data); 
?>