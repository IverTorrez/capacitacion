<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Capacitacion Itech | Login</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="recursos/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="recursos/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="recursos/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="recursos/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="recursos/plugins/iCheck/square/blue.css">
  <link rel="icon" href="recursos/img/plantilla/logoserrate3.jfif">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box" style="margin-top: 0px;">
  <div class="login-logo" style="margin-bottom: 0px;">
    <a ><b>ITECH</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicia sesión</p>

    <form >
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Nombre de usuario" id="usulogin" name="usulogin" autocomplete="off">

        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="textpasslogin" name="textpasslogin" autocomplete="off">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <label>
              <input type="checkbox" id="mostrar_contrasena" name="mostrar_contrasena"> Ver password <a href="#"></a>
            </label>
      </div>

      <div class="row">
        <div class="col-xs-8">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="button" class="btn btn-primary btn-block btn-flat" id="btnloginusu" name="btnloginusu">Ingresar<img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   
    <!-- /.social-auth-links -->

    
    <a href="registro.php" class="text-center">Registrarme</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="recursos/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="recursos/plugins/iCheck/icheck.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });


   $(document).ready(function () {
        /*
         * Al hacer clic sobre el checkbox verificamos si esta activado o no
         * y asi alternamos entre el tipo de input donde esta la contrasena
         * entre text y password
         */
        $('#mostrar_contrasena').click(function () {
          if ($('#mostrar_contrasena').is(':checked')) {
            $('#textpasslogin').attr('type', 'text');
          } else {
            $('#textpasslogin').attr('type', 'password');
          }
        });
      });



   $(document).ready(function() { 
   $("#btnloginusu").on('click', function() {
     $('#img_cargando').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   
   var usulogin=$('#usulogin').val();
   var textpasslogin=$('#textpasslogin').val();
   
   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
  

   if ( (usulogin=='') || (textpasslogin=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning');
     $('#img_cargando').hide(); 
     
   }
   else
   {
      var noValidoPass= / /;
      var noValidoUser= / /;
      /*VERIFICAMOS SI EL PASSWORD TIENE ESPACIOs*/
     if (noValidoPass.test(textpasslogin)) 
     {
       setTimeout(function(){  }, 2000); swal('ATENCION','No se permite espacios en la contraseña','warning');
       $('#img_cargando').hide(); 
     }
     /*POR FALSO, NO TIENE ESPACIOS EL PASSWORD, PUEDE CONTINUAR CON LA VERIFICACION*/
     else
     {
          /*VERIFICAMOS SI EL username TIENE ESPACIOs*/
         if (noValidoUser.test(usulogin)) 
         {
          setTimeout(function(){  }, 2000); swal('ATENCION','No se permite espacios en el nombre de usuario','warning');
          $('#img_cargando').hide();
         }
         /*por falso, no tiene espacios el username, mamdalos al controlador*/
         else
         {

            /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
             formDataUp.append('usulogin',usulogin);
             formDataUp.append('textpasslogin',textpasslogin);
              $.ajax({ url: 'controlador/control-loginUsuario.php', 
                       type: 'post', 
                       data: formDataUp, 
                       contentType: false, 
                       processData: false, 
                       success: function(response) { 
                         if (response == 1) { 
                            setTimeout(function(){ location.href='capacitaciones.php' }, 2000); swal('','Ingresando.....'); 
                            } 
                            if (response == 2) { 
                            setTimeout(function(){ location.href='procuradores.php' }, 2000); swal('','Ingresando.....'); 
                            }
                            if (response==3) 
                           {                    
                           setTimeout(function(){  }, 2000); swal('Atencion!!','El usuario no existe en la base de datos del sistema','warning');
                           $('#img_cargando').hide();
                            }
                          
                         
                        } 
                    }); 

         }/*FIN DEL ELSE CUANDO EL username NO TIENE ESPACIOS*/

     }/*FIN DEL ELSE CUANDO EL PASWORD NO TIENE ESPACIOS*/
     

  }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
</script>
</body>
</html>
