<?php 
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioP"]))
{
  header("location:index.php");
}
require_once("cabezoteProc.php");
require_once("menuProc.php");
include_once("modelo/clsCapacitacion.php");
include_once("modelo/clsProcurador.php");
$datosP=$_SESSION["usuarioP"];
$objCap1=new Procurador();
$resulnombre=$objCap1->mostrarUnProcurador($idprocuradorGET);
$filnombr=mysqli_fetch_object($resulnombre);
$nombreProcurador=$filnombr->nombre.' '.$filnombr->apellido;
?>

<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

<div class="content-wrapper">
	<section class="content-header">
     
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>
      </ol> -->
    </section>
    <section class="content">

    <div class="row" >
      <!-- left column -->
        <div class="col-md-6" >
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Actualiza tus datos <?php echo $datosP['nombre']; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form">
              <input type="hidden" name="textid_procurador" id="textid_procurador" placeholder="id proc" value="<?php echo $datosP['id_procurador'] ?>">
              <div class="box-body">

                <label for="exampleInputEmail1">Nombre</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_nombre" name="text_nombre" placeholder="Nombres" value="<?php echo $datosP['nombre'] ?>" required="" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Apellido</label>
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_apellido" name="text_apellido" placeholder="Apellidos" required="" value="<?php echo $datosP['apellido'] ?>" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Email</label>
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_email" name="text_email" placeholder="Email" required="" value="<?php echo $datosP['email'] ?>" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Telefono</label>
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_telefono" name="text_telefono" placeholder="Telefono" required="" value="<?php echo $datosP['telefono'] ?>" autocomplete="off">
                </div>
                <label for="exampleInputEmail1">Direccion</label>
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_direccion" name="text_direccion" placeholder="Direccion" required="" value="<?php echo $datosP['direccion'] ?>" autocomplete="off">
                </div>
                <label for="exampleInputEmail1">Casa de Estudio</label>
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_casaEstudio" name="text_casaEstudio" placeholder="Casa de Estudio" required="" value="<?php echo $datosP['casa_estudio'] ?>" autocomplete="off">
                </div>


                <label for="exampleInputEmail1">Usuario</label>
                <div class="input-group">
                  
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_userName" name="text_userName" placeholder="Usuario de ingreso" required="" value="<?php echo $datosP['usuario_procu'] ?>" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Password</label>
                <div class="input-group">
                 
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_passUser" name="text_passUser" placeholder="Password" required="" autocomplete="off" value="<?php echo $datosP['password_procu'] ?>">
                </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="button" class="btn btn-primary" id="btnactualizard" name="btnactualizard">Actualizar datos<img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>

                
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
    </div>

    </section>
    <!-- /.content -->

</div>
 <!-- /.content-wrapper -->
 <script type="text/javascript">
//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA INICIAR UNA CAPACITACION ##########
$(document).ready(function() { 
   $("#btnactualizard").on('click', function() {
    $('#img_cargando').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataRegProc = new FormData(); 
   
   var passuser=$('#text_passUser').val();
   var userName=$('#text_userName').val();
   var textid_procurador=$('#textid_procurador').val();
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
             formDataRegProc.append('textid_procurador',textid_procurador);
             formDataRegProc.append('text_nombre',text_nombre);
             formDataRegProc.append('text_apellido',text_apellido);
             formDataRegProc.append('text_email',text_email);
             formDataRegProc.append('text_telefono',text_telefono);
             formDataRegProc.append('text_direccion',text_direccion);
             formDataRegProc.append('text_casaEstudio',text_casaEstudio);
             formDataRegProc.append('userName',userName);
             formDataRegProc.append('passuser',passuser);
             
              $.ajax({ url: 'controlador/control-EditarProcurador.php', 
                       type: 'post', 
                       data: formDataRegProc, 
                       contentType: false, 
                       processData: false, 
                       success: function(response) { 
                         if (response == 1) { 
                            setTimeout(function(){ location.reload(); }, 2000); swal('EXELENTE','Los datos se actualizaron con exito','success'); 
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
         setTimeout(function(){  }, 2000); swal('ATENCION','El nombre de usuario debe tener entre 6 y 20 caracteres','warning');
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

<?php require_once("footer.php");?>

