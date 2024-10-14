<?php
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioC"]))
{
  header("location:index.php");
} 
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
        <!-- left column 
        <div class="col-md-6" >-->
          <!-- general form elements 
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Crea un Procurador Nuevo</h3>
            </div>-->
            <!-- /.box-header -->
            <!-- form start 
             <form role="form">
              <input type="hidden" name="textidautor" id="textidautor" placeholder="id autor" value="1">
              <div class="box-body">

                <label for="exampleInputEmail1">Nombre del Procurador</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textnombre" name="textnombre" placeholder="Nombres" required="" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Apellido</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textapellido" name="textapellido" placeholder="Apellidos" required="" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Telefono</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                  <input type="text" class="form-control" id="text_telefono" name="text_telefono" placeholder="Telefono celular" required="" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Usuario</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textuser" name="textuser" placeholder="Nombre de Usuario " required="" autocomplete="off">
                </div>

                 <label for="exampleInputEmail1">Password</label>

                <div class="input-group">
                    <span class="input-group-addon" id="show_password" onclick="mostrarPassword()"><i class="fa fa-eye-slash icon"></i></span>
                   <input type="password" autocomplete="off" class="form-control" name="textpassw" id="textpassw" placeholder="Contraseña de ingreso">    
                </div>

              </div>-->
              <!-- /.box-body

              <div class="box-footer">
              	<button type="button" class="btn btn-primary" id="btnguardar" name="btnguardar">Crear Procurador</button>

                
              </div>
            </form>
          </div> -->
          <!-- /.box 

        </div>-->







        <!--/.col (left) -->
        <!-- right column  OBJETOS A LA DERECHA LISTADO DE MIS CURSOS -->
        <div class="col-md-6" style="width: 100%;">
          <!-- Horizontal Form -->
          <div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">Listado de procuradores</h3>
            </div>
            <!-- /.box-header -->
             

             <div class="" >
            
            <!-- /.box-header -->
            <div class="box-body" >
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  
                <tr>
                  <th width="">Nombre</th>
                  <th>Apellido</th>
                  <th>Telefono</th>
                  <th>Email</th>
                  <th>Direccion</th>
                  <th>Casa de Estudio</th>
                  <th>Usuario</th>
                  <th>Password</th>
                  <th>Opciones</th>
                  
                </tr>
                </thead>
                <tbody>
   
                  <?php
                   $objcur=new Procurador();
                   $resultc=$objcur->listarProcuradores();
                   while ($fil=mysqli_fetch_object($resultc)) 
                   {
                            
                     echo "<tr>";
                       echo "<td>$fil->nombre</td>";

                       echo "<td>$fil->apellido</td>";
                       echo "<td>$fil->telefono</td>";
                       echo "<td>$fil->email</td>";
                       echo "<td>$fil->direccion</td>";
                       echo "<td>$fil->casa_estudio</td>";
                       echo "<td>$fil->usuario_procu</td>";
                       echo "<td>$fil->password_procu</td>";
                       

                      ?>

                       <td><button class='btn-box-tool' onclick="location.href='detalles_procurador.php?cod=<?php echo $fil->id_procurador ?> '" style='color:black;'>Ver. <i class='fa fa-eye'></i></button>
                       
                          <button class='btn btn-danger btn-xs' data-toggle="modal" data-target="#modal-elimProcurador" onclick="llevaridProcEliminar('<?php echo $fil->id_procurador ?>')">Eliminar <i class='fa fa-trash'></i></button>
                          
                       </td>
                      <?php
                     echo "</tr>";
                   }
                  ?>
               
                </tbody>

               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          
          </div>
          <!-- /.box -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->


<!--MODAL PARA ELIMINAR UN PROCURADOR -->
        <div class="modal modal-danger fade" id="modal-elimProcurador">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Procurador <small style="color: #ffffff;"></small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_procurador" id="textid_procurador" placeholder="id procurador" value="">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Está seguro de eliminar este procurador?</label>
                
                </div>

              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btneliminarProcurador" name="btneliminarProcurador">Eliminar<img style="width: 20px;display: none;" id="img_cargando_elimProc" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<script type="text/javascript">
  function llevaridProcEliminar(idprocurador)
  {
    $('#textid_procurador').val(idprocurador);
  }

 /************************ JS QUE LLAMA AL CONTROLADOR PARA ELIMINAR UN PROCURADOR*/
   $(document).ready(function() { 
   $("#btneliminarProcurador").on('click', function() {
     $('#img_cargando_elimProc').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataElim = new FormData(); 
   
   var textid_procurador=$('#textid_procurador').val();
   /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
  
   if ( (textid_procurador=='')  ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina y vuelva a intentar','warning');
      $('#img_cargando_elimProc').hide(); 
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
     formDataElim.append('textid_procurador',textid_procurador);
     
      $.ajax({ url: 'controlador/control-ElimProcurador.php', 
               type: 'post', 
               data: formDataElim, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 500); swal('EXELENTE','Se elimino con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                     $('#img_cargando_elimProc').hide(); 
                    //alert('Formato de imagen incorrecto.'); 
                    }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
   /*FIN DEL JS QUE LLAMA AL CONTROLADOR PARA ELIMINAR UN PROCURADOR*/
</script>
<!-- <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script> -->
 <!-- viewer.html?file=%2Fyourpdf.pdf -->

<!-- <h1>EJEMPLO DE PDF.JS</h1> -->
 
<!-- <canvas id="canvas_pdf"></canvas>
<script type="text/javascript">
  // Primero ponemos la ruta del fichero pdf.
var url = 'pfdbeto.pdf';
 
// Debemos especificar la ruta de worker.js (en este caso será la de github)
PDFJS.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
 
// Carga del pdf asíncrona
var loadingTask = PDFJS.getDocument(url);
loadingTask.promise.then(function(pdf) {
  console.log('PDF cargado');
 
  // Carga la primera página
  var pageNumber = 1;
  pdf.getPage(pageNumber).then(function(page) {
    console.log('Page loaded');
 
    var scale = 1.5;
    var viewport = page.getViewport(scale);
 
    // Prepara el cambas según el tamaño que definimos en las variables
//scale y viewport
    var canvas = document.getElementById('canvas_pdf');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;
 
    // Pinta el PDF en el canvas
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.then(function () {
        console.log('Todo Correcto');
      });
  });
}, function (reason) {
  // Pinta el error en casode que se de
  console.error(reason);
});
</script> -->




    </section>
    <!-- /.content -->
  </div><!-- /.WALPER -->

<script type="text/javascript"> 
       function mostrarPassword(){ 
           var cambio = document.getElementById("textpassw"); 
              if(cambio.type == "password"){ 
                  cambio.type = "text"; 
                 $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye'); 
               }
               else{ 
                cambio.type = "password"; 
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash'); 
              } 
            } 
         
</script>

<!--CODIGO JAVAESCRIPT QUE LLAMA AL CONTROLADOR CREAR UN PROCURADOR-->
<script> 

	

   $(document).ready(function() { 
   $("#btnguardar").on('click', function() {

   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   
   var textnombre=$('#textnombre').val();
   var textapellido=$('#textapellido').val();
   var text_telefono=$('#text_telefono').val();
   var textuser=$('#textuser').val();
   var textpassw=$('#textpassw').val();
   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
  

   if ( (textnombre=='') || (textapellido=='') || (textuser=='') || (textpassw=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
     formDataUp.append('textnombre',textnombre);
     formDataUp.append('textapellido',textapellido);
     formDataUp.append('text_telefono',text_telefono);
     formDataUp.append('textuser',textuser);
     formDataUp.append('textpassw',textpassw); 
     
      $.ajax({ url: 'controlador/control-RegProcurador.php', 
               type: 'post', 
               data: formDataUp, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 500); swal('EXELENTE','Los datos se crearon con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    //alert('Formato de imagen incorrecto.'); 
                    }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
   </script>





<?php require_once("footer.php");?>

