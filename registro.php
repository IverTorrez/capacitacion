<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Capacitacion Itech</title>
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
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
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
<body class="hold-transition register-page">
<div class="register-box" style="margin-top: 20px;">
  <div class="register-logo" style="margin-bottom: 0px;">
    <a ><b>ITECH</b></a>
  </div>
 

  <div class="register-box-body">
    <p class="login-box-msg">Registrate como procurador para realizar tu capacitación</p>

    <form >
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Nombre" name="text_nombre" id="text_nombre" autocomplete="off">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Apellidos" name="text_apellido" id="text_apellido" autocomplete="off">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="text_email" id="text_email" autocomplete="off">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="number" class="form-control" placeholder="Telefono celular" name="text_telefono" id="text_telefono" autocomplete="off">
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Direccion" name="text_direccion" id="text_direccion" autocomplete="off">
        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Casa de estudio" name="text_casaEstudio" id="text_casaEstudio" autocomplete="off">
        <span class="glyphicon glyphicon-education form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Nombre de usuario de ingreso" name="text_userName" id="text_userName" autocomplete="off">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="text_passUser" id="text_passUser" autocomplete="off">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <label>
              <input type="checkbox" id="mostrar_contrasena" name="mostrar_contrasena"> Ver password <a href="#"></a>
            </label>
      </div>

      
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="button" class="btn btn-primary  btn-flat" id="btnregistrar" name="btnregistrar">Registrarme<img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <br>


    <a href="index.php" class="text-center">Ya tengo una cuenta</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="recursos/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>



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
</script>


 <script>
      $(document).ready(function () {
        /*
         * Al hacer clic sobre el checkbox verificamos si esta activado o no
         * y asi alternamos entre el tipo de input donde esta la contrasena
         * entre text y password
         */
        $('#mostrar_contrasena').click(function () {
          if ($('#mostrar_contrasena').is(':checked')) {
            $('#text_passUser').attr('type', 'text');
          } else {
            $('#text_passUser').attr('type', 'password');
          }
        });
      });



//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA INICIAR UNA CAPACITACION ##########
$(document).ready(function() { 
   $("#btnregistrar").on('click', function() {
     $('#img_cargando').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataRegProc = new FormData(); 
  
   var passuser=$('#text_passUser').val();
   var userName=$('#text_userName').val();
   var text_nombre=$('#text_nombre').val();
   var text_apellido=$('#text_apellido').val();
   var text_email=$('#text_email').val();
   var text_telefono=$('#text_telefono').val();
   var text_direccion=$('#text_direccion').val();
   var text_casaEstudio=$('#text_casaEstudio').val();

   var noValidoPass= / /;
   var noValidoUser= / /;
   // VERIFICAMOS SI TIENE ESPACIOS LA CONTRASEÑA

if ( (passuser=='') || (userName=='') || (text_nombre=='') || (text_apellido=='') || (text_email=='') || (text_telefono=='') || (text_direccion=='') || (text_casaEstudio=='')) 
{
  setTimeout(function(){  }, 2000); swal('ATENCION','Debe de completar todos los datos','warning'); 
   $('#img_cargando').hide(); 
}
else
{

  /*VERIFICAMOS SI EL PASSWORD TIENE ESPACIOs*/
   if (noValidoPass.test(passuser)) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No se permite espacios en la contraseña','warning');
      $('#img_cargando').hide(); 
   }
   /*POR FALSO, NO TIENE ESPACIOS EL PASSWORD, PUEDE CONTINUAR CON LA VERIFICACION*/
   else
   {
    /*VERIFICAMOS SI EL username TIENE ESPACIOs*/
     if (noValidoPass.test(userName)) 
     {
      setTimeout(function(){  }, 2000); swal('ATENCION','No se permite espacios en el nombre de usuario','warning');
       $('#img_cargando').hide();
     }
     /*por falso, no tiene espacios el username, seguimos con la verificacion*/
     else
     {
        /*verificamos que el username tenga mas de 6 caracteres y menor igual a 20*/
       if (userName.length>6 && userName.length<=20) 
       {
         
         /*verificamos que el password tenga mas de  caracteres y menor igual a 20*/
         if (passuser.length>7 && passuser.length<=20) 
         {
            
           // SE REGITRAA
            /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el item*/
             formDataRegProc.append('text_nombre',text_nombre);
             formDataRegProc.append('text_apellido',text_apellido);
             formDataRegProc.append('text_email',text_email);
             formDataRegProc.append('text_telefono',text_telefono);
             formDataRegProc.append('text_direccion',text_direccion);
             formDataRegProc.append('text_casaEstudio',text_casaEstudio);
             formDataRegProc.append('userName',userName);
             formDataRegProc.append('passuser',passuser);
             
              $.ajax({ url: 'controlador/control-RegProcurador.php', 
                       type: 'post', 
                       data: formDataRegProc, 
                       contentType: false, 
                       processData: false, 
                       success: function(response) { 
                         if (response == 1) { 
                            setTimeout(function(){ location.href='capacitaciones.php' }, 2000); swal('BIENVENIDO','Redireccionando.....','success'); 
                            } 
                            if (response==0) 
                           {
                           /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                            
                            setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                             $('#img_cargando').hide();
                            //alert('Formato de imagen incorrecto.'); 
                            }
                            if (response==2) 
                             {
                   
                              setTimeout(function(){  }, 2000); swal('ATENCION','Debe cambiar su contraseña','warning');
                               $('#img_cargando').hide();
                              //alert('Formato de imagen incorrecto.'); 
                              }
                          
                         
                        } 
                    }); 

         }/*FIN DEL IF QUE EL PASSWORD ESTE ENTE 7 Y 20 CARACTERES(se pasa a registrar)*/
         else
         {
           
           setTimeout(function(){  }, 2000); swal('ATENCION','La contraseña de ingreso debe tener entre 7 y 20 caracteres','warning');
            $('#img_cargando').hide();
         }

       }
       /*por falso mostramos alerta de los rangos permitidos para el user name*/
       else
       {  
         setTimeout(function(){  }, 2000); swal('ATENCION','El nombre de usuario debe tener entre 7 y 20 caracteres','warning');
          $('#img_cargando').hide();
       }
      
     }/*FIN DEL ELSE CUANDO EL username NO TIENE ESPACIOS*/
    
   }/*FIN DEL ELSE CUANDO EL PASWORD NO TIENE ESPACIOS*/

}/*FIN DEL ELSE CUANDO TODOS LOS CAMPOS ESTAN COMPLETADOS*/ 
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA INICIAR UNA CAPACITACION#############
    </script>

</body>
</html>
