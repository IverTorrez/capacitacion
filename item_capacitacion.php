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
include_once('modelo/clsItemCapacitacion.php');
include_once('modelo/clsPregunta.php');
include_once('modelo/clsRespuesta.php');
$iditem=$_GET['cod'];

$objItem=new Item_Capacitacion();
$resulitem=$objItem->mostrarUnItem($iditem);
$fil_item=mysqli_fetch_object($resulitem);

$nombreitem=$fil_item->nombre_item;
$nombreitemInterno=$fil_item->nombre_item_interno;
$numeroitem=$fil_item->numero_item;
$tipoitem=$fil_item->tipo_item;
$tiempoitem=$fil_item->tiempo_item;

$idCapacitacion=$fil_item->id_capacitacion;

if ($tipoitem=='PDF') 
{
 $recursoIframe='archivos_pdf_capacitacion/'.$nombreitemInterno;
}
if ($tipoitem=='LINK') 
{
  $recursoIframe=$nombreitemInterno;
}



$objCap=new Capacitacion();
$resulCap=$objCap->MostrarUnaCapacitacion($idCapacitacion);
$filcap=mysqli_fetch_object($resulCap);

$estadoCap=$filcap->estado;
$nombreCap=$filcap->nombre_capacitacion;


?>


<!-- Content Wrapper. Contains page content -->
<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
<section class="content-header">
  <p>Capacitacion:<b> <a href="admin_capacitacion.php?cod=<?php echo $idCapacitacion ?>"> <?php echo $nombreCap; ?></a></b></p>

        <h4>
          <label>Nombre:</label>
          <small><?php
           echo $nombreitem;
          ?></small>

          <label>Tipo:</label>
          <small><?php
           echo $tipoitem;
          ?></small>

          <label>Tiempo:</label>
          <small><?php
           echo $tiempoitem;
          ?></small>

          <label>Numero de Diapositiva:</label>
          <small><?php
           echo $numeroitem;
          ?></small>
        </h4>    
      </section>
    <!-- Main content -->
    <section class="content">
       
      <div class="row">
        <!-- left column -->

        <?php
        if ($tipoitem=='EXAMEN') 
        {
        ?>
          <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary" >
            <div class="box-header with-border">
              <h3 class="box-title">Agregue una pregunta al Examen de Capacitacion</h3>
            </div>
            <!-- /.box-header -->
              <!-- form start -->
             <form role="form">
            
              <div class="box-body">
              
              <?php
               if ($estadoCap=='inactiva') 
               {
               ?>
                <button type="button" data-toggle="modal" data-target="#modal-info" class="btn btn-info btn-xs">Agregar Pregunta <i  class="fa fa-question-circle"></i> </button>
               <?php  
               }
               else
               {
              ?>
                <button type="button" disabled=""  class="btn btn-info btn-xs">Agregar Pregunta <i  class="fa fa-question-circle"></i> </button>
              <?php
               }
              ?>
             
              


              <br><br>
<p>Vista previa del examen</p><br>

<?php
$objPregunta=new Preguntas();
$numeroPreg=1;
$resulTpreg=$objPregunta->listarTodasLaPreguntasDeItemExamen($iditem);
while ($filpregunta=mysqli_fetch_object($resulTpreg)) 
{

      echo "<label style='margin-top:15px;'>$numeroPreg) $filpregunta->pregunta</label>";
      echo '</br>';


      $objresP=new Respuesta();
      $resulResp=$objresP->listarRespuestasDeUnaPregunta($filpregunta->id_pregunta);
      $posisionIncisos=0;
      $arrayIncisos=array('A','B','C','D','E','F');
      while ($filrespu=mysqli_fetch_object($resulResp)) 
      {
        if ($filrespu->valor==1) 
        {
          $coloback='blue';
        }
        else
        {
          $coloback='red';
        }
      ?>
       <div class="col-lg-12" style="background: <?php echo $coloback ?>;">

            <div class="input-group">
            <span class="input-group-addon">
               <?php
               echo "<label>$arrayIncisos[$posisionIncisos] )</label>"
               ?>
            <input type="radio" id="radio" value="" name="">
                   
            </span>
                <label class="form-control" ><?php echo $filrespu->respuesta; ?> </label>
            </div>
        <!-- /input-group -->
        
        </div>

      <?php
      $posisionIncisos++;
      }
  echo '</br>';echo '</br>';
  $numeroPreg++;
}
?>


      </div>
      <!-- /.box-body -->

                
      </form>

        
        
        
           
        
        

       
        </br>

          </div>
          <!-- /.box -->
        </div>
        
        <?php 
        }/*FIN DEL IF QUE PREGUNTA SI ES UN EXAMEN, MOSTRARA OPCIONES PARA AGREGAR PREGUNTAS*/

        /*POR FALSO SOLO MOSTRARA LOS IFRAME PARA EL VIDEO O PARA EL PDF*/
        else
        {
        ?>
          <div class="col-md-6" style="width: 100%;">
          <!-- general form elements -->
          <div class="box box-primary" >
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $nombreitem; ?></h3>
            </div>
            <!-- /.box-header -->
              <!-- form start -->
             <form role="form">
            
              <div class="box-body">

              <?php
               if ($tipoitem=='PDF') 
               {
                //$recursos='../../'.$recursoIframe;
               // $NamePDF=$recursos;
                $_SESSION["sessionPDF"]=$nombreitemInterno;
                ?>
                <!-- <object data="<?php echo $recursoIframe; ?>"></object> -->
                <!-- <embed src="<?php echo $recursoIframe; ?>" type="application/pdf" style="width: 100%; height: 450px;"></embed> -->
                 <!-- <iframe src="<?php echo $recursoIframe; ?>" style="width: 100%; height: 450px;"></iframe> -->
                
                  <iframe style="width: 100%; height: 430px;" src="pdfjs_lector/web/viewer.php?nameDoc=<?php echo $nombreitemInterno; ?>"></iframe> 
                <?php 
               }
               else
               {
              ?>
               <div id="embed-youtube"> 
                <?php
                echo $recursoIframe;
                ?>
                </div>
               <?php
               }
              ?>

    <style type="text/css">
      #embed-youtube {
        position:relative;
        width:100%;
        height:99%;
        padding-bottom:56.25%;
        padding-top:30px;
        height:0;
        overflow:hidden;
        }

        #embed-youtube iframe, #embed-youtube object, #embed-youtube embed {
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        }
    </style>          

              </div>
              <!-- /.box-body -->

            </form>
          </div>
          <!-- /.box -->
        </div>
        
        <?php
        }
        ?>
        








     <?php
    if ($tipoitem=='EXAMEN') 
    {
    ?>

   
        <!--/.col (left) -->
        <!-- right column  OBJETOS A LA DERECHA LISTADO DE MIS CURSOS -->
        <div class="col-md-6" >
          <!-- Horizontal Form -->
          <div class="box box-info" >
            <div class="box-header with-border">
              <h3 class="box-title">Listado de Preguntas</h3>
            </div>
            <!-- /.box-header -->
             

             <div class="" >
            
            <!-- /.box-header -->
            <div class="box-body" >
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  
                <tr>
                  <th width="">#</th>
                  <th>Pregunta</th>
                 
                  <th>Opciones</th>
                  
                </tr>
                </thead>
                <tbody>
   
                  <?php
                   $contadorPreguntas=1;
                   $objcur=new Preguntas();
                   $resultc=$objcur->listarTodasLaPreguntasDeItemExamen($iditem);
                   while ($fil=mysqli_fetch_object($resultc)) 
                   {
                    $datospregunta=$fil->id_pregunta."||".
                    $fil->pregunta;

                            
                     echo "<tr>";
                       echo "<td><label>$contadorPreguntas</label></td>";

                       echo "<td>$fil->pregunta</td>";
                      
                       
                      if ($estadoCap=='inactiva') 
                      {
                      ?>
                       <td><button   data-toggle="modal" data-target="#modal-danger" class="btn btn-danger btn-xs" onclick="llevardatosAlmodalElimpreg('<?php echo $datospregunta ?>')">Eliminar <i class='fa fa-trash'></i></button></td>
                      <?php  
                      }
                      else
                      {
                      ?>
                        <td><button disabled=""   class="btn btn-danger btn-xs" onclick="llevardatosAlmodalElimpreg('<?php echo $datospregunta ?>')">Eliminar <i class='fa fa-trash'></i></button></td>
                      <?php
                      }
                      
                     echo "</tr>";
                     $contadorPreguntas++;
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
    <?php 
    }/*FIN DEL IF QUE PREGUNTA SI EL ITEM ES UN EXAMEN*/
     ?>





      </div>
      <!-- /.row -->
     
    </section>
    <!-- /.content -->
  </div><!-- /.WALPER -->










  <!--MODAL PARA EL LINK DE YOUTUBE -->
        <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Pregunta<small style="color: #ffffff;"></small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_itemexamen" id="textid_itemexamen" placeholder="id item examen" value="<?php echo $iditem ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Pregunta</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textpregunta" name="textpregunta" placeholder="Pregunta para el examen" required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Cantidad de respuestas para esta pregunta</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-link"></i></span>
                  <select class="form-control" name="select_cant_respuesta" id="select_cant_respuesta">
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>
                     <option value="5">5</option>
                     <option value="6">6</option>
                  </select>
                </div>
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnguardarPregunta" name="btnguardarPregunta">Crear Pregunta<img style="width: 20px;display: none;" id="img_cargando_pregunta" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




<!--MODAL PARA ELIMINAR UNA PREGUNTA CON TODAS SUS RESPUESTAS -->
        <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Pregunta <small style="color: #ffffff;"></small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_pregunta" id="textid_pregunta" placeholder="id pregunta" value="">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Está seguro de eliminar esta pregunta y sus respuestas?</label>
                
                </div>

              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btneliminarPregunta" name="btneliminarPregunta">Eliminar<img style="width: 20px;display: none;" id="img_cargando_preguntaElim" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



<!--CODIGO JAVAESCRIPT QUE LLAMA AL CONTROLADOR CREAR UN PROCURADOR-->
<script> 

  function llevardatosAlmodalElimpreg(datospregunta)  
  { 
    f1=datospregunta.split('||');
           $('#textid_pregunta').val(f1[0]);
  }



   $(document).ready(function() { 
   $("#btnguardarPregunta").on('click', function() {
     $('#img_cargando_pregunta').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataPregunta = new FormData(); 
   
   var textid_itemexamen=$('#textid_itemexamen').val();
   var textpregunta=$('#textpregunta').val();
   var select_cant_respuesta=$('#select_cant_respuesta').val();
  
   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
   if ( (textpregunta=='') ||  (select_cant_respuesta=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     $('#img_cargando_pregunta').hide();
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
     formDataPregunta.append('textid_itemexamen',textid_itemexamen);
     formDataPregunta.append('textpregunta',textpregunta);
     formDataPregunta.append('select_cant_respuesta',select_cant_respuesta);
     
      $.ajax({ url: 'controlador/control-RegPregunta.php', 
               type: 'post', 
               data: formDataPregunta, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                // console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response!=0) 
                  {
                    
                    setTimeout(function(){ location.href='respuestas_de_pregunta.php?cod='+response; }, 2000); swal('','Redireccionando a las respuestas....',''); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                    $('#img_cargando_pregunta').hide();                   
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });




/**-----------------------------------eliminar pregunta-----------------------*/
   $(document).ready(function() { 
   $("#btneliminarPregunta").on('click', function() {
    $('#img_cargando_preguntaElim').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataPreguntaElim = new FormData(); 
   
   var textid_pregunta=$('#textid_pregunta').val();
      
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
   if ( (textid_pregunta=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagine e intente nuevamente','warning');
     $('#img_cargando_preguntaElim').hide(); 
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el curso*/
     formDataPreguntaElim.append('textid_pregunta',textid_pregunta);

      $.ajax({ url: 'controlador/control-EliminarPregunta.php', 
               type: 'post', 
               data: formDataPreguntaElim, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
               
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.reload() }, 2000); swal('EXELENTE','Se elimino correctamente','success'); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                    $('#img_cargando_preguntaElim').hide();                   
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
/*-------------FIN-ELIMINAR PREGUNTA-------------------------*/

   </script>





<?php require_once("footer.php");?>

