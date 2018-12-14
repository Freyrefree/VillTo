<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" href="../img/ICONO2.ico" type="image/vnd.microsoft.icon" /> -->

    <!-- <link rel="shortcut icon" href="img/ICONO2.ico" type="image/vnd.microsoft.icon" /> -->
    <title>Login | Pagos</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link href="css/mdb.min.css" rel="stylesheet"> 
    
    <!--<link rel="stylesheet" href="bootstrap.css">-->

    <script src="js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="js/tether.min.js"></script>
    <script src="http://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script> 
    <style>
        body{
            background: #EBEDEF;
        }
        .titulo{
            background:#5cb85c; 
            /*#0275d8;*/
            color: #F2F2F2;
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
        .form-control{
            margin: 0px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row"><br><br></div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-block titulo bg-primary">
                        <!--<br>-->
                        <center>
                            <!-- <img src="http://www.juliatours.com.mx/juliav2/sites/all/themes/juliatours/logo.png"> -->
                            
                            <!-- <br>
                            <br> -->
                            <h4>Pagos | Inicio</h4>
                        </center>
                    </div>
                    <div class="card-block">
                    <br>
                    <h1><center> Villa Tours </center></h1>
                    <!-- <img class="mk-desktop-logo dark-logo " title="Su agente de viajes" alt="Su agente de viajes" src="http://mariorosado.com.mx/villatours/wp-content/uploads/2018/05/villatours-virtuoso.png"> -->
                    <br><br>
                        <form class="form-horizontal" method="POST" action="access.php">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            <input id="email" type="text" class="form-control" name="email" placeholder="Correo electronico" autofocus>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-unlock-alt" aria-hidden="true">&nbsp;</i></span>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">
                        </div>
                        <br>
                        <div class="form-group pull-right">
                            <button type="submit" class="btn btn-info btn-md wow fadeInDown">Acceder <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
                        </div>
                        <!-- <img src="http://s01.europapress.net/archivos/juliatravel.jpg" alt=""> -->
                        <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <script>
        new WOW().init();
    </script>
</body>
</html>