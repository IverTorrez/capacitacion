<?php 
require_once("cabezote.php");
require_once("menu.php");
require_once("modelo/clsProcurador.php");
?>

<!-- Content Wrapper. Contains page content -->
<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6" >
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Ingresa ahora</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" id="frmloginusu">
              <div class="box-body">

                <label for="inputEmail3" class="col-sm-2 control-label">Usuario</label>
                <div class="input-group">
                    <span class="input-group-addon" id="" ><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" id="usulogin" name="usulogin" placeholder="Usuario">
                 
                </div>

               <br>
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="input-group">
                   
                  <span class="input-group-addon" id="show_password" onclick="mostrarPasswordLogin()"><i class="fa fa-eye-slash iconlogin"></i></span>
                  <input type="password" class="form-control" id="textpasslogin" name="textpasslogin" placeholder="Password">
                 
                </div>


                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="button" id="btnloginusu" name="btnloginusu" class="btn btn-info">Ingresar</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

        </div>






        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div><!-- /.WALPER -->

<script type="text/javascript"> 
       function mostrarPasswordLogin(){ 
           var cambio = document.getElementById("textpasslogin"); 
              if(cambio.type == "password"){ 
                  cambio.type = "text"; 
                 $('.iconlogin').removeClass('fa fa-eye-slash').addClass('fa fa-eye'); 
               }
               else{ 
                cambio.type = "password"; 
                $('.iconlogin').removeClass('fa fa-eye').addClass('fa fa-eye-slash'); 
              } 
            } 
         
</script>

<!--CODIGO JAVAESCRIPT QUE LLAMA AL CONTROLADOR CREAR UN PROCURADOR-->
<script> 

	

   $(document).ready(function() { 
   $("#btnloginusu").on('click', function() {

   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   
   var usulogin=$('#usulogin').val();
   var textpasslogin=$('#textpasslogin').val();
   
   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
  

   if ( (usulogin=='') || (textpasslogin=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
   }
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
                    setTimeout(function(){ location.href='capacitaciones.php' }, 2000); swal('Bienbenido','Redireccionando.....'); 
                    } 
                    if (response == 2) { 
                    setTimeout(function(){ location.href='crear_procurador.php' }, 2000); swal('Bienbenido','Redireccionando.....'); 
                    }
                    if (response==3) 
                   {                    
                   setTimeout(function(){  }, 2000); swal('Atencion!!','El usuario no existe en la base de datos','warning');
                    }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
   </script>





<?php require_once("footer.php");?>
