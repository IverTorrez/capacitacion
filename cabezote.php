 <?php
session_start();
$datos=$_SESSION["usuarioC"];
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Capacitate | Itech</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="recursos/img/plantilla/logoserrate3.jfif">

   <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="recursos/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="recursos/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="recursos/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="recursos/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="recursos/dist/css/skins/_all-skins.min.css">
  <!-- Estilo Imagingif cargando -->
  <link rel="stylesheet" href="recursos/dist/css/style_propios.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
 <header class="main-header">
    
    <!--=====================================
    LOGOTIPO
    ======================================-->
    <a  class="logo">
        
        <!-- logo mini -->
        <span class="logo-mini">
            
            <img src="recursos/img/plantilla/logoserrate3.jfif" class="img-responsive" style="padding:10px">

        </span>

        <!-- logo normal -->

        <span class="logo-lg">
            
            <img src="recursos/img/plantilla/logo.jpg" class="img-responsive" style="padding:10px 0px">

        </span>

    </a>

    <!--=====================================
    BARRA DE NAVEGACIÓN
    ======================================-->
    <nav class="navbar navbar-static-top" role="navigation">
        
        <!-- Botón de navegación -->
<!-- CONDICION DE SESSION -->
      <?php
      if ($_SESSION["usuarioC"]!=null) 
      {
      ?>
         <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            
            <span class="sr-only">Toggle navigation</span>
        
        </a>

      <?php 
      }
      ?>
       
        <!-- perfil de usuario -->

        <div class="navbar-custom-menu">
                
            <ul class="nav navbar-nav">
                
                <li class="dropdown user user-menu">
 <!-- CONDICION DE SESSION --> 
               <?php
               if ($_SESSION['usuarioC']!=null) 
               {?>
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        
                        <img src="recursos/img/usuarios/default/anonymous.png" class="user-image">

                        <span class="hidden-xs">Capacitador : <?php echo $datos['nombre'] ?></span>

                </a>

                
                <?php 
               }
               else
               {
                ?>
                <a href="index.php" >
                        
                        
                        <span><i class="fa fa-sign-in"></i></span>
                        <span class="hidden-xs">Ingresar</span>

                </a>
               <?php
               }
                ?>              
                    

                    <!-- Dropdown-toggle -->

                   <!--  <ul class="dropdown-menu">
                        
                        <li class="user-body">
                            
                            <div class="pull-right">
                                
                                <a href="cerrarSession.php" class="btn btn-default btn-flat">Salir</a>

                            </div>

                        </li>

                    </ul> -->

                     <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="recursos/img/usuarios/default/anonymous.png" class="user-image">

                <p>
                  <?php echo $datos['nombre'] ?>
                  
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                   <a href="mis_datos.php" class="btn btn-default btn-flat">Mis datos</a>
                </div>
                <div class="pull-right">
                  <a href="cerrarSession.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>

                </li>

            </ul>

        </div>

    </nav>

 </header>