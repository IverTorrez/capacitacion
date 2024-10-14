<?php 
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioC"]))
{
  header("location:index.php");
}
$datos=$_SESSION["usuarioC"];
require_once("cabezote.php");
require_once("menu.php");
include_once('modelo/clsCapacitacion.php');
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
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Crea un Curso de capacitacion</h3>
              
               <form method="post" action="respaldos/myphp-backup.php" target="_blank" style="display: inline;">
              <button class="btn btn-primary btn-xs">Backup <i class="fa fa-database"></i> </button>
              </form>
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form">
              <input type="hidden" name="textidautor" id="textidautor" placeholder="id autor" value="1">
              <div class="box-body">

                <label for="exampleInputEmail1">Nombre del Curso de Capacitacion</label>
                <div class="input-group">
                  <input type="hidden" name="textid_capacitador" id="textid_capacitador" value="<?php echo $datos['id_capacitador'] ?>">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textnombre" name="textnombre" placeholder="Nombre de la capacitación" required="" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Tipo de Capacitacion</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                    <select class="form-control select2" id="selecttipocap" name="selecttipocap" style="width: 100%;">
                        <option value="Capacitacion" selected="selected">Capacitacion</option>
                        <option value="Actualizacion">Actualizacion</option>
                       
                     </select>
                </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              	<button type="button" class="btn btn-primary" id="btnguardar" name="btnguardar">Crear Capacitacion<img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>

               
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>







        <!--/.col (left) -->
        <!-- right column  OBJETOS A LA DERECHA LISTADO DE MIS CURSOS -->
        <div class="col-md-6" >
          <!-- Horizontal Form -->
          <div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">Listado de Capacitaciones</h3>
            </div>
            <!-- /.box-header -->
             

             <div class="" >
            
            <!-- /.box-header -->
            <div class="box-body" >
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  
                <tr>
                  <th width="">Nombre</th>
                  <th>Tipo</th>
                  <th>Estado</th>
                  <th>Opciones</th>
                  
                </tr>
                </thead>
                <tbody>
   
                  <?php
                  $estadoCap="";
                   $objcur=new Capacitacion();
                   $resultc=$objcur->listarCapacitaciones();
                   while ($fil=mysqli_fetch_object($resultc)) 
                   {
                       if ($fil->estado=='inactiva') 
                      {
                        $estadoCap="Sin Iniciar";
                      }
                      else
                      {
                        if ($fil->estado=='activa') 
                        {
                          $estadoCap="Activa";
                        }
                        else
                        {
                          if ($fil->estado=='cancelada') 
                          {
                            $estadoCap="Desactivada";
                          }
                        }
                      }
                      
                     echo "<tr>";
                       echo "<td>$fil->nombre_capacitacion</td>";

                       echo "<td>$fil->tipo_capacitacion</td>";
                       echo "<td>$estadoCap</td>";
                      
                      
                       

                      ?>

                       <td><button class='btn-box-tool' onclick="window.open('admin_capacitacion.php?cod=<?php echo $fil->id_capacitacion ?> ')" style='color:black;'>Admin. <i class='fa fa-wrench'></i></button>

                      <button class='btn-box-tool' data-toggle="modal" data-target="#modal-clonarCap" onclick="cargarIdCapacitacion('<?php echo $fil->id_capacitacion ?>')" style='color:black;'>Clonar <i class='fa fa-clone'></i></button>

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
     
    </section>
    <!-- /.content -->
  </div><!-- /.WALPER -->













<!--MODAL PARA CLONAR LA CAPACITACION -->
        <div class="modal modal-primary fade" id="modal-clonarCap">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Clonación de Capacitación</h4>
              </div>
              <div class="">

          <input type="hidden" name="textid_capacitacion_aclonar" id="textid_capacitacion_aclonar" placeholder="id capacitación" value="">
          <input type="hidden" name="textid_capacitador" id="textid_capacitador" value="<?php echo $datos['id_capacitador'] ?>">

                <div class="box-body">
                <label for="exampleInputEmail1">Nombre del Curso</label>
                <div class="input-group">
                 
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="text_nombreCapClonacion" name="text_nombreCapClonacion" placeholder="Nombre de la capacitación" required="" autocomplete="off">
                </div>

                <label for="exampleInputEmail1">Tipo de Capacitacion</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                    <select class="form-control select2" id="selecttipo_clonacion" name="selecttipo_clonacion" style="width: 100%;">
                        <option value="Capacitacion" selected="selected">Capacitacion</option>
                        <option value="Actualizacion">Actualizacion</option>
                       
                     </select>
                </div>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnClonarcap" name="btnClonarcap">Clonar <img style="width: 20px;display: none;" id="img_cargando_clonar" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA CLONAR LA CAPACITACION -->

<!--CODIGO JAVAESCRIPT QUE LLAMA AL CONTROLADOR CREAR UN PROCURADOR-->
<script> 
 function cargarIdCapacitacion(idcapacitacion)
 {
    $('#textid_capacitacion_aclonar').val(idcapacitacion);
 }


$(document).ready(function() { 
   $("#btnguardar").on('click', function() {


  $('#img_cargando').show();


   // var img_cargando = document.getElementById("img_cargando");
   // img_cargando.style.display = "block";
   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   
   var textnombre=$('#textnombre').val();
   var selecttipocap=$('#selecttipocap').val();
   var textid_capacitador=$('#textid_capacitador').val();
   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
   if ( (textnombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning');
     $('#img_cargando').hide(); 
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
     formDataUp.append('textnombre',textnombre);
     formDataUp.append('selecttipocap',selecttipocap);
     formDataUp.append('textid_capacitador',textid_capacitador);
     
      $.ajax({ url: 'controlador/control-RegCapacitacion.php', 
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
                    $('#img_cargando').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
/*fin de click del boton crear capacitacion*/





/**********************boton clonar capacitacion*************************************************/
$(document).ready(function() { 
   $("#btnClonarcap").on('click', function() {


  $('#img_cargando_clonar').show();

   /*cargamos los inputs a nuevas variables*/ 
   var formDataClonar = new FormData(); 
   
   var textid_capacitacion_aclonar=$('#textid_capacitacion_aclonar').val();
   var text_nombreCapClonacion=$('#text_nombreCapClonacion').val();
   var selecttipo_clonacion=$('#selecttipo_clonacion').val();
   var textid_capacitador=$('#textid_capacitador').val();
   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
   if ( (text_nombreCapClonacion=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning');
     $('#img_cargando_clonar').hide(); 
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
     formDataClonar.append('textid_capacitacion_aclonar',textid_capacitacion_aclonar);
     formDataClonar.append('text_nombreCapClonacion',text_nombreCapClonacion);
     formDataClonar.append('selecttipo_clonacion',selecttipo_clonacion);
     formDataClonar.append('textid_capacitador',textid_capacitador);
     
      $.ajax({ url: 'controlador/control-ClonarCapacitacion.php', 
               type: 'post', 
               data: formDataClonar, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 500); swal('EXELENTE','Clonación Con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_clonar').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
/*******************************************fin boton clonar capacitacion***********************************/
   </script>





<?php require_once("footer.php");?>

