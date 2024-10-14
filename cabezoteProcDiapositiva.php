 <?php
session_start(); 
$datosP=$_SESSION["usuarioP"];
?>




  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Capacitate | Serrate</title>

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


<!-- Bootstrap 3.3.7 -->
  <script src="recursos/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
 <header class="" style="">
    
    <!--=====================================
    LOGOTIPO
    ======================================-->

    <!--=====================================
    BARRA DE NAVEGACIÓN
    ======================================-->
    <nav class=" " role="" style="background: #3c8dbc;height: 0px; ">
        
        <!-- Botón de navegación -->
<!-- CONDICION DE SESSION -->
      <?php
      if ($_SESSION["usuarioP"]!=null) 
      {
      ?>
        

      <?php 
      }
      ?>
       
        <!-- perfil de usuario -->

        

    </nav>

 </header>