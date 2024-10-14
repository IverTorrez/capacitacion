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
$idcapacitacion=$_GET['cod'];

$objcapacitacion=new Capacitacion();
$resulcap=$objcapacitacion->MostrarUnaCapacitacion($idcapacitacion);
$filcap=mysqli_fetch_object($resulcap);

  $nombreCap=$filcap->nombre_capacitacion;
  $tipo=$filcap->tipo_capacitacion;
  $estadoCapacitacion=$filcap->estado;



?>

<!-- Content Wrapper. Contains page content -->
<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <a href="admin_capacitacion.php?cod=<?php echo $idcapacitacion;?>"><?php
           echo $nombreCap;
          ?> </a>

          <?php
          if ($estadoCapacitacion=='inactiva') 
          {?>
<i style="font-size: 25px;" class="fa fa-edit" data-toggle="modal" data-target="#modal-editarnameCap"></i>

          <?php
          }
          ?> 
          
        </h1>    
      </section>
      <!--End Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">



      

      <div class="row">
        <!-- left column -->
        <div class="col-md-6" >
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Seleccione el Tipo de Diapositiva a crear</h3>
              <?php
              if ($estadoCapacitacion=='inactiva') 
              {
              ?>
               <button type="button" id="btnmodalIniciar" name="btnmodalIniciar" data-toggle="modal" data-target="#modal-activarCap" class="btn btn-primary btn-xs">Iniciar</button>
              <?php 
              }
              else
              {
                if ($estadoCapacitacion=='activa') 
                {
                 ?>
                  <button class='btn-box-tool' data-toggle="modal" data-target="#modal-desactivar" onclick="" style='color:black;'> Desactivar <i style="color:red;" class='fa fa-times-circle'></i></button>
                 <?php
                } else 
                {
                  if ($estadoCapacitacion=='cancelada') 
                  {
                    ?>
                    <button class='btn-box-tool' data-toggle="modal" data-target="#modal-reactivar" onclick="" style='color:black;'>Reactivar <i style="color:green;" class='fa fa-check-circle'></i></button>
                    <?php
                  }
                  
                }
                
              }
              ?>
              <button class='btn-box-tool' data-toggle="modal" data-target="#modal-eliminarCap" style='color:black;'>Eliminar capacitacion <i style="color:black;" class='fa fa-trash'></i></button>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form">

              <div class="box-body">

              <?php
              // POR VERDADERO MUESTRA LOS BOTONES PARA CREAR ITEM
              if ($estadoCapacitacion=='inactiva') 
              {
              ?>

              <button type="button" data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-xs">Archivo PDF <i  class="fa fa-file-pdf-o"></i> </button>

              <button type="button" data-toggle="modal" data-target="#modal-danger" class="btn btn-danger btn-xs">Link de YouTube <i  class="fa fa-youtube"></i> </button>

              <button type="button" data-toggle="modal" data-target="#modal-warning" class="btn btn-warning btn-xs">Examen <i  class="fa fa-pencil-square-o"></i> </button> 

              <?php 
              } /*FIN DEL IF PARA MOSTRAR LOS BOTONES PARA CREAR LOS ITEM*/

              // POR FALSO MOSTRARA LOS BOTONES INANTIVOS(NO LOS PODRA USAR)
              else 
              {
              ?>
               <button type="button" class="btn btn-default btn-xs" disabled="">Archivo PDF <i  class="fa fa-file-pdf-o"></i> </button>

              <button type="button"  class="btn btn-default btn-xs" disabled="">Link de YouTube <i  class="fa fa-youtube"></i> </button>

              <button type="button"  class="btn btn-default btn-xs"  disabled="" >Examen <i  class="fa fa-pencil-square-o"></i> </button>
              <?php
              }/*FIN DEL ELSE QUE MUESTRA LOS BOTONES INACTIVOS*/
              
              ?>
             
                


              </div>
              <!-- /.box-body -->

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
              <h3 class="box-title">Listado de Diapositivas</h3>
            </div>
            <!-- /.box-header -->
             

             <div class="" >
            
            <!-- /.box-header -->
            <div class="box-body" >
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Tipo</th>
                  <th>Tiempo</th>
                  <th>Opciones</th>
                  
                </tr>
                </thead>
                <tbody>
   
                  <?php
                   $contador=1;
                   $contadorTotalItem=0;
                   $objcur=new Capacitacion();
                   $resultc=$objcur->listarTodosLosItemDeUnaCapacitacion($idcapacitacion);
                   while ($fil=mysqli_fetch_object($resultc)) 
                   {

          /*CONVERTIMOS EL TIEMPO DEL ITEM EN SEGUNDOS PARA USARLOS, SEPARAMOS MINUTOS DE SEGUNDOS*/
                         $TiempoDeItem=date_create($fil->tiempo_item);
                         $TiempoDeItemFormato=date_format($TiempoDeItem, 'H:i:s');

                         $horaNula= date("00:00:00");/*HORA NULA PARA SACAR LA DIFERENCIA ENTRE EL TIEMPO DEL ITEM*/
                         $DtTimeHoraNula =new DateTime($horaNula);/*CREACION DEL OBJETO DateTime*/
                         $DtTiempoDeItemFormato =new DateTime($TiempoDeItemFormato);/*CREACION DEL OBJETO DateTime*/
                         
                         $Intervalo= $DtTimeHoraNula->diff($DtTiempoDeItemFormato);

                         $HorasEnteros=intval($Intervalo->format('%H'));
                         $minutosEnteros=intval($Intervalo->format('%i'));
                         $segundosEnteros=intval($Intervalo->format('%s'));

                         if ($segundosEnteros==0) 
                         {
                          $segundosEnteros='00';
                         } 
                         if ($fil->tipo_item=='LINK') 
                         {
                           $tiempoItem='--------';
                         }
                         else
                         {
                          $tiempoItem=$fil->tiempo_item;
                         }
                         

                    $datosItem=$fil->id_item."||".
                    $fil->numero_item."||".
                    $fil->tipo_item."||".
                    $fil->numero_item."||".
                    $minutosEnteros."||".
                    $segundosEnteros;

              echo "<input type='hidden' id='$fil->id_item' name='$fil->id_item' value='$fil->nombre_item_interno'>";
              echo "<input type='hidden' id='name$fil->id_item' name='name$fil->id_item' value='$fil->nombre_item'>";
                            
                     echo "<tr>";
                       echo "<td>$fil->numero_item</td>";

                       echo "<td><a href='item_capacitacion.php?cod=$fil->id_item'>$fil->nombre_item</a> </td>";
                       echo "<td>$fil->tipo_item</td>";
                       echo "<td>$tiempoItem</td>";
                      
                       

                      ?>

                       <td>
                      <?php
                      if ($fil->tipo_item=='PDF' AND $estadoCapacitacion=='inactiva') 
                      {
                      ?>
                       <button type="button" class='btn btn-success btn-xs' data-toggle="modal" data-target="#modal-editPDF" onclick="cargarInfoDeItemEnModalEdit('<?php print $datosItem; ?>')">Editar <i class='fa fa-file-pdf-o'></i></button>
                      <?php  
                      }
                      if ($fil->tipo_item=='LINK' AND $estadoCapacitacion=='inactiva') 
                      {
                      ?>
                       <button type="button" class='btn btn-danger btn-xs' data-toggle="modal" data-target="#modal-editLINK" onclick="cargarInfoDeItemLinkEnModalEdit('<?php print $datosItem; ?>')">Editar <i class='fa fa-youtube'></i></button>
                      <?php
                      }
                      if ($fil->tipo_item=='EXAMEN' AND $estadoCapacitacion=='inactiva') 
                      {
                      ?>
                        <button type="button" class='btn btn-warning btn-xs' data-toggle="modal" data-target="#modal-editEXAMEN" onclick="cargarInfoDeItemEXAMEN_EnModalEdit('<?php echo $datosItem; ?>')">Editar <i class='fa fa-pencil-square-o'></i></button>
                      <?php
                      }


                      if ($estadoCapacitacion=='inactiva') 
                      {
                      ?>
                       <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-moverItem" onclick="cargarInfoEnModalMoverItem('<?php echo $datosItem; ?>')">Mover</button>

                       <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-eliminarItem" onclick="cargarInfoEnModalElim('<?php echo $datosItem; ?>')">Eliminar</button>

                      <?php  
                      }
                      else
                      {
                      ?>
                        <button type="button" class="btn btn-default btn-xs" disabled="" >Editar</button>
                        <button type="button" class="btn btn-default btn-xs" disabled="" >Mover</button>
                        <button type="button" class="btn btn-default btn-xs" disabled="">Eliminar</button>
                      <?php
                      } 
                      
                      ?>
                        
                        

                       </td>
                      <?php
                     echo "</tr>";
                     $contador++;
                     $contadorTotalItem++;
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




<?php require_once("footer.php");?>




<!-- MODAL SUBIR ITEM PDF PARA LA DIAPOSITIVA-->
  <div class="modal modal-success fade" id="modal-success">
          <div class="modal-dialog">
           
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Subir Archivo PDF <small style="color: #ffffff;">Suba un archivo PDF para la diapositiva de capacitación</small> </h4>
              </div>
              <div class="" style="background: white;">
                 <!-- form start -->      
              <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion ?>">
              <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Titulo del archivo PDF</label>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textituloPDF" name="textituloPDF" placeholder="Titulo del archivo...." required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Tiempo</label>
                <div class="form-group">                  
                    <!-- /.box-header -->
                <!--MINUTOS DEL ITEM -->  
                 <span style="color: black;">Min.</span>   
                 <select style="color: black;" id="select_minPdf" name="select_minPdf">
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       <option value="4">4</option>
                       <option value="5">5</option>
                       <option value="6">6</option>
                       <option value="7">7</option>
                       <option value="8">8</option>
                       <option value="9">9</option>
                       <option value="10">10</option>
                    </select>  
                <!-- SEGUNDOS DEL ITEM-->
                 <span style="color: black;">Seg.</span> 
                 <select style="color: black;" id="select_segPdf" name="select_segPdf">
                       <option value="00">00</option>
                       <option value="10">10</option>
                       <option value="20">20</option>
                       <option value="30">30</option>
                       <option value="40">40</option>
                       <option value="50">50</option>
                      
                    </select>                        
                </div>
                <label style="color: black;">Archivo</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-archive"></i></span>                
                  <input type="file" class="form-control" name="file_pdf" id="file_pdf" >                
                </div>
              </div>
              <!-- /.box-body -->     
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnguardarItem" name="btnguardarItem">Crear Item<img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



<!-- MODAL EDITAR ITEM PDF PARA LA DIAPOSITIVA-->
  <div class="modal modal-success fade" id="modal-editPDF">
          <div class="modal-dialog">
           
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editat Diapositiva PDF <small style="color: #ffffff;"></small> </h4>
              </div>
              <div class="" style="background: white;">
                 <!-- form start -->      
              <input type="hidden" name="textid_itemPDF_edit" id="textid_itemPDF_edit" placeholder="id item" value="">
              <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Titulo del archivo PDF</label>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textituloPDF_EDIT" name="textituloPDF_EDIT" placeholder="Titulo del archivo...." required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Tiempo</label>
                <div class="form-group">                  
                    <!-- /.box-header -->
                <!--MINUTOS DEL ITEM -->  
                 <span style="color: black;">Min.</span>   
                 <select style="color: black;" id="select_minPdf_EDIT" name="select_minPdf_EDIT">
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       <option value="4">4</option>
                       <option value="5">5</option>
                       <option value="6">6</option>
                       <option value="7">7</option>
                       <option value="8">8</option>
                       <option value="9">9</option>
                       <option value="10">10</option>
                    </select>  
                <!-- SEGUNDOS DEL ITEM-->
                 <span style="color: black;">Seg.</span> 
                 <select style="color: black;" id="select_segPdf_EDIT" name="select_segPdf_EDIT">
                       <option value="00">00</option>
                       <option value="10">10</option>
                       <option value="20">20</option>
                       <option value="30">30</option>
                       <option value="40">40</option>
                       <option value="50">50</option>
                      
                    </select>                        
                </div>
                <label style="color: black;">Archivo</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-archive"></i></span>                
                  <input type="file" class="form-control" name="file_pdf_EDIT" id="file_pdf_EDIT" > 

                </div>
                <label style="color: black;">Archivo PDF actual</label>
                 <iframe style="width: 100%;" id="iframe_pdf" name="iframe_pdf" src=""></iframe> 
              </div>
              <!-- /.box-body -->     
              </div>
              <div class="modal-footer">

                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btngEditItemPDF" name="btngEditItemPDF">Editar Item<img style="width: 20px;display: none;" id="img_cargando_editpdf" src="recursos/gif/cargando.gif"></button>



              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->






<!--MODAL PARA EL LINK DE YOUTUBE -->
        <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Subir Link de YouTube <small style="color: #ffffff;">Suba un link de YouTube para la diapositiva de capacitación</small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Titulo Para el Link</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textituloLink" name="textituloLink" placeholder="Titulo del link...." required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Link</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-link"></i></span>
                  <input type="text" class="form-control" id="textLink" name="textLink" placeholder="Link de YouTube" required="" autocomplete="off">
                </div>
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnguardarlink" name="btnguardarlink">Subir Link<img style="width: 20px;display: none;" id="img_cargando_link" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


<!--MODAL PARA EDITAR EL LINK DE YOUTUBE -->
        <div class="modal modal-danger fade" id="modal-editLINK">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edtitar Link de YouTube <small style="color: #ffffff;"></small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_itemLINK_edit" id="textid_itemLINK_edit" placeholder="id item" value="">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Titulo Para el Link</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                  <input type="text" class="form-control" id="textituloLink_edit" name="textituloLink_edit" placeholder="Titulo del link...." required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Link</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-link"></i></span>
                  <input type="text" class="form-control" id="textLink_Edit" name="textLink_Edit" placeholder="Link de YouTube" required="" autocomplete="off">
                </div>
                 <label style="color: black;">Video actual</label>

                 <div id="embed-youtube">
                   
                 </div>
                 <!-- <iframe style="width: 100%;" id="iframe_link" name="iframe_link" src=""></iframe>  -->
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnEditLINK" name="btnEditLINK">Editar Link<img style="width: 20px;display: none;" id="img_cargando_linkEdit" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



<!--MODAL PARA LA CREAR EL EXAMEN PARA EL PROCURADOR -->
        <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Examen Para el procurador <small style="color: #ffffff;">Registre un examen para la diapositiva de capacitacion</small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Titulo del examen</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textituloexamen" name="textituloexamen" placeholder="Titulo del examen...." required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Tiempo</label>
                <div class="form-group">                  
                    <!-- /.box-header -->
                <!--MINUTOS DEL ITEM -->  
                 <span style="color: black;">Min.</span>   
                 <select style="color: black;" id="select_minExamen" name="select_minExamen">
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       <option value="4">4</option>
                       <option value="5">5</option>
                       <option value="6">6</option>
                       <option value="7">7</option>
                       <option value="8">8</option>
                       <option value="9">9</option>
                       <option value="10">10</option>
                    </select>  
                <!-- SEGUNDOS DEL ITEM-->
                 <span style="color: black;">Seg.</span> 
                 <select style="color: black;" id="select_segExamen" name="select_segExamen">
                       <option value="00">00</option>
                       <option value="10">10</option>
                       <option value="20">20</option>
                       <option value="30">30</option>
                       <option value="40">40</option>
                       <option value="50">50</option>
                      
                    </select>                        
                </div>

                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnguardarexamen" name="btnguardarexamen">Registrar<img style="width: 20px;display: none;" id="img_cargando_examen" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



<!--MODAL PARA LA EDITAR EL EXAMEN PARA EL PROCURADOR -->
        <div class="modal modal-warning fade" id="modal-editEXAMEN">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Examen Para el procurador <small style="color: #ffffff;">Para poder editar las preguntas o respuestas y ver a detalle el examen, presiones sobre el nombre del examen en la lista de diapositivas</small> </h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_itemEXAMEN_edit" id="textid_itemEXAMEN_edit" placeholder="id item examen" value="">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Titulo del examen</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                  <input type="text" class="form-control" id="textituloexamen_edit" name="textituloexamen_edit" placeholder="Titulo del examen...." required="" autocomplete="off">
                </div>

                <label style="color: black;" for="exampleInputEmail1">Tiempo</label>
                <div class="form-group">                  
                    <!-- /.box-header -->
                <!--MINUTOS DEL ITEM -->  
                 <span style="color: black;">Min.</span>   
                 <select style="color: black;" id="select_minExamenEdit" name="select_minExamenEdit">
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       <option value="4">4</option>
                       <option value="5">5</option>
                       <option value="6">6</option>
                       <option value="7">7</option>
                       <option value="8">8</option>
                       <option value="9">9</option>
                       <option value="10">10</option>
                    </select>  
                <!-- SEGUNDOS DEL ITEM-->
                 <span style="color: black;">Seg.</span> 
                 <select style="color: black;" id="select_segExamenEdit" name="select_segExamenEdit">
                       <option value="00">00</option>
                       <option value="10">10</option>
                       <option value="20">20</option>
                       <option value="30">30</option>
                       <option value="40">40</option>
                       <option value="50">50</option>
                      
                    </select>                        
                </div>

                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnEditarExamen" name="btnEditarExamen">Editar Examen<img style="width: 20px;display: none;" id="img_cargando_examenEdit" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




<!--MODAL PARA ACTIVAR LA CAPACITACION -->
        <div class="modal modal-primary fade" id="modal-activarCap">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Iniciar La Capacitación</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Esta seguro de iniciar??
                Los procuradores ahora podran empezar esta capacitación y usted ya no podra crear, modificar o eliminar las diapositivas</label>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_iniciar_cap" name="btn_iniciar_cap">Iniciar <img style="width: 20px;display: none;" id="img_cargando_iniciarCap" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA ACTIVAR LA CAPACITACION -->



<!--MODAL PARA EDITAR EL NOMBRE DE LA CAPACITACION -->
        <div class="modal modal-primary fade" id="modal-editarnameCap">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar nombre de la Capacitación</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Nombre de la capacitación</label>
                <input type="text" class="form-control" name="text_editNameCap" id="text_editNameCap" placeholder="Nombre" value='<?php echo $nombreCap; ?>'>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_editname_cap" name="btn_editname_cap">Editar <img style="width: 20px;display: none;" id="img_cargando_editnameCap" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA EDITAT EL NOMBRE FR LA CAPACITACION -->






<!--MODAL PARA ELIMINAR UN ITEM DE LA CAPACITACION -->
        <div class="modal modal-danger fade" id="modal-eliminarItem">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar DIapositiva</h4>
              </div>
              <div class="">

        <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">
        <input type="hidden" name="textid_item" id="textid_item" value="" placeholder="id de item">
          <input type="hidden" name="text_numeroItem" id="text_numeroItem" value="" placeholder="numero item">
          <input type="hidden" name="text_tipoItem" id="text_tipoItem" value="" placeholder="Tipo de Item">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Esta seguro de eliminar esta diapositiva??
                </label>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_eliminar_item" name="btn_eliminar_item">Eliminar<img style="width: 20px;display: none;" id="img_cargando_elim" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA ELIMINAR UN ITEM DE LA CAPACITACION -->


<!--MODAL PARA DESACTIVAR LA CAPACITACION -->
        <div class="modal modal-info fade" id="modal-desactivar">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Desactivar Capacitación</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Los procuradores ya no podran ver esta capacitación, para poder tomarla</label>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_desactivar_cap" name="btn_desactivar_cap">Desactivar <img style="width: 20px;display: none;" id="img_cargando_desactivar" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA DESACTIVAR LA CAPACITACION -->






<!--MODAL PARA REACTIVAR LA CAPACITACION -->
        <div class="modal modal-info fade" id="modal-reactivar">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reactivar Capacitación</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Los procuradores ahora podran ver esta capacitación, para poder tomarla</label>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_reactivar_cap" name="btn_reactivar_cap">Reactivar <img style="width: 20px;display: none;" id="img_cargando_reactivar" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA REACTIVAR LA CAPACITACION -->



<!--MODAL PARA ELIMINAR LA CAPACITACION -->
        <div class="modal modal-danger fade" id="modal-eliminarCap">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar Capacitación</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Se eliminaran todos los datos de esta capacitación</label>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_eliminar_cap" name="btn_eliminar_cap">Eliminar <img style="width: 20px;display: none;" id="img_cargando_eliminarCap" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA ELIMINAR LA CAPACITACION -->



<!--MODAL PARA ELIMINAR LA CAPACITACION -->
        <div class="modal modal-info fade" id="modal-moverItem">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mover Diapositiva</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_capacitacion" id="textid_capacitacion" placeholder="id capacitación" value="<?php echo $idcapacitacion; ?>">

                 <input type="hidden" name="text_numeroItemActual" id="text_numeroItemActual" placeholder="numero actual de la diapositiva" value="">
                 <input type="hidden" name="textid_itemMover" id="textid_itemMover" placeholder="id item actual" value="">
                 <div class="box-body">
                    <label id="nombreItem"></label>
                    <p id="numeroActual"></p>
                 </div>
                 
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Seleccione el número donde desea mover la diapositiva</label>
                 <select style="color: black;" id="select_numeroItemNuevo" name="select_numeroItemNuevo">
                      <?php
                       $contadorDeOpciones=1;
                       while ($contadorDeOpciones<=$contadorTotalItem) 
                       {
                         echo " <option value='$contadorDeOpciones'>$contadorDeOpciones</option>";
                         $contadorDeOpciones++;
                       }

                      ?>
                       
                      
                    </select>  
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_moverItem" name="btn_moverItem">Mover <img style="width: 20px;display: none;" id="img_cargando_mover" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA ELIMINAR LA CAPACITACION -->



<!-- /********//////////////SECTOR PARA LAS FUNCIONES EN JAVASCRIPT************//// /////////////   -->
<script type="text/javascript">
/*---------------FUNCION QUE SE EJECUTA AL CARGAR UN FILE PARA SUBIR UN ITEM PDF-----------------------*/
  $(function(){
    $('#file_pdf').on('change', function(){
          if (isDocumento($(this).val()) ) 
          {
         

          }
         else{
               
               
                  setTimeout(function(){  }, 2000); swal('ATENCION!!','Este archivo no es admitido, solo puede cargar documentos en PDF','warning');
                 
                // $('#texto_nombre_doc_previsual').text(f[1]);
                 $('#file_pdf').val('');
             }
    });

  });
/*--------------fin de FUNCION QUE SE EJECUTA AL CARGAR UN FILE PARA SUBIR UN ITEM PDF-------*/


  
/********VERIFICAMOS SI ES UN DOCUMENTO************/
  function isDocumento(filemane){
    var ext=getExtension(filemane);
    if (   (ext.toLowerCase()=='pdf') )
    {
      return true
    }
    else
    {
      return false;
    }
    
  }
/********FIN DE VERIFICAMOS SI ES UN DOCUMENTO************/



/*********OBTENEMOS LA EXTENCION DEL ARCHIVO***********/
  function getExtension(filemane){
    var parts=filemane.split('.');
    return parts[parts.length -1];
  }
/*********fin de OBTENEMOS LA EXTENCION DEL ARCHIVO***********/




//####################### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO PDF ##########
$(document).ready(function() { 
   $("#btnguardarItem").on('click', function() {
    $('#img_cargando').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   var files_PDF = $('#file_pdf')[0].files[0];
   var textituloPDF=$('#textituloPDF').val();
   var select_minPdf=$('#select_minPdf').val();
   var select_segPdf=$('#select_segPdf').val();
   var textid_capacitacion=$('#textid_capacitacion').val();
   var name_filepdf=$('#file_pdf').val();/*PARA VERIFICAR SI ESTA VACIO EL INPUT FILE/

   
    /*CARGAMOS EL GIF DE CARGANDO Y PONEMOS DISABLED EL BOTON*/
   if ( (textituloPDF=='' || name_filepdf=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning');
      $('#img_cargando').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el item*/
     formDataUp.append('textituloPDF',textituloPDF);
     formDataUp.append('select_minPdf',select_minPdf);
     formDataUp.append('select_segPdf',select_segPdf);
     formDataUp.append('textid_capacitacion',textid_capacitacion);
     formDataUp.append('files_PDF',files_PDF);
     
      $.ajax({ url: 'controlador/control-RegItemPDF.php', 
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
                    if (response==3) 
                     {
           
                      setTimeout(function(){  }, 2000); swal('ATENCION','Ya hay un archivo con ese nombre, por favor cambie el nombre del nuevo archivo que desea subir','warning');
                      $('#img_cargando').hide(); 
                      //alert('Formato de imagen incorrecto.'); 
                      }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//######################### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO PDF#############







//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO LINK DE YOUTUBE ##########
$(document).ready(function() { 
   $("#btnguardarlink").on('click', function() {
      $('#img_cargando_link').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataLink = new FormData(); 
   var textituloLink=$('#textituloLink').val();
   var textLink=$('#textLink').val();
   var textid_capacitacion=$('#textid_capacitacion').val();

   if ( (textituloLink=='' || textLink=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning');
      $('#img_cargando_link').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el item*/
     formDataLink.append('textituloLink',textituloLink);
     formDataLink.append('textLink',textLink);
     formDataLink.append('textid_capacitacion',textid_capacitacion);
      $.ajax({ url: 'controlador/control-RegItemLink.php', 
               type: 'post', 
               data: formDataLink, 
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
                     $('#img_cargando_link').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//######### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO LINK DE YOUTUBE#############




//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO examen ##########
$(document).ready(function() { 
   $("#btnguardarexamen").on('click', function() {
 $('#img_cargando_examen').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataP = new FormData(); 
   var textituloexamen=$('#textituloexamen').val();
   var select_minExamen=$('#select_minExamen').val();
   var select_segExamen=$('#select_segExamen').val();
   var textid_capacitacion=$('#textid_capacitacion').val();

   if ( (textituloexamen=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     $('#img_cargando_examen').hide();     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el item*/
     formDataP.append('textituloexamen',textituloexamen);
     formDataP.append('select_minExamen',select_minExamen);
     formDataP.append('select_segExamen',select_segExamen);
     formDataP.append('textid_capacitacion',textid_capacitacion);
      $.ajax({ url: 'controlador/control-RegItemExamen.php', 
               type: 'post', 
               data: formDataP, 
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
                    $('#img_cargando_examen').hide();  
                    //alert('Formato de imagen incorrecto.'); 
                    }           
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//######### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO LINK DE examen#############










//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA INICIAR UNA CAPACITACION ##########
$(document).ready(function() { 
   $("#btn_iniciar_cap").on('click', function() {
      $('#img_cargando_iniciarCap').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataIniciar = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();

   if ( textid_capacitacion=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina por favor e intente de nuevo','warning'); 
      $('#img_cargando_iniciarCap').hide();     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataIniciar.append('textid_capacitacion',textid_capacitacion);
      $.ajax({ url: 'controlador/control-IniciarCapacitacion.php', 
               type: 'post', 
               data: formDataIniciar, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','La capacitacion se inicio con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_iniciarCap').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA INICIAR UNA CAPACITACION#############



//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA DESACTIVAR UNA CAPACITACION ##########
$(document).ready(function() { 
   $("#btn_desactivar_cap").on('click', function() {
      $('#img_cargando_desactivar').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataDesact = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();

   if ( textid_capacitacion=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina por favor e intente de nuevo','warning'); 
      $('#img_cargando_desactivar').hide();     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataDesact.append('textid_capacitacion',textid_capacitacion);
      $.ajax({ url: 'controlador/control-DesactivarCapacitacion.php', 
               type: 'post', 
               data: formDataDesact, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','La capacitacion se Desactivo con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_desactivar').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA DESACTIVAR UNA CAPACITACION#############





//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA REACTIVAR UNA CAPACITACION ##########
$(document).ready(function() { 
   $("#btn_reactivar_cap").on('click', function() {
      $('#img_cargando_reactivar').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataDesact = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();

   if ( textid_capacitacion=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina por favor e intente de nuevo','warning'); 
      $('#img_cargando_reactivar').hide();     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataDesact.append('textid_capacitacion',textid_capacitacion);
      $.ajax({ url: 'controlador/control-IniciarCapacitacion.php', 
               type: 'post', 
               data: formDataDesact, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','La capacitacion se Reactivo con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_reactivar').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA REACTIVAR UNA CAPACITACION#############






//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA ELIMINAR UNA CAPACITACION ##########
$(document).ready(function() { 
   $("#btn_eliminar_cap").on('click', function() {
      $('#img_cargando_eliminarCap').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataDesact = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();

   if ( textid_capacitacion=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina por favor e intente de nuevo','warning'); 
      $('#img_cargando_eliminarCap').hide();     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataDesact.append('textid_capacitacion',textid_capacitacion);
      $.ajax({ url: 'controlador/control-EliminarCapacitacion.php', 
               type: 'post', 
               data: formDataDesact, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.href='crear_capacitacion.php'; }, 1000); swal('EXELENTE','Se elimino con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_eliminarCap').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                     if (response==2) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','No puede eliminar hay procesos','error');
                    $('#img_cargando_eliminarCap').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA ELIMINAR UNA CAPACITACION#############




/*############## FUNCION JAVASCRIPT QUE CARGA LOS DATOS DE UN ITEM AL MODAL ELIMINAR*/
  function cargarInfoEnModalElim(datosItem)  
  { 
    f1=datosItem.split('||');
           $('#textid_item').val(f1[0]);
           $('#text_numeroItem').val(f1[1]);
           $('#text_tipoItem').val(f1[2]);

  }
  /*############## FIN FUNCION JAVASCRIPT QUE CARGA LOS DATOS DE UN ITEM AL MODAL ELIMINAR*/


  /*############## FUNCION JAVASCRIPT QUE CARGA LOS DATOS DE UN ITEM AL MODAL MOVER ITEM*/
  function cargarInfoEnModalMoverItem(datosItem)  
  { 
    f1=datosItem.split('||');
           $('#textid_itemMover').val(f1[0]);
           $('#text_numeroItemActual').val(f1[1]);
           var nombre_item = $('#name'+f1[0]).val();
            $('#nombreItem').text(nombre_item);
            $('#numeroActual').text('Número actual.- '+f1[1]);
            

  }
  
  /*############## FIN FUNCION JAVASCRIPT QUE CARGA LOS DATOS DE UN ITEM AL MOVER ITEM*/


  /*############## FUNCION JAVASCRIPT QUE CARGA LOS DATOS DE UN ITEM AL MODAL EDITAR ITEM PDF*/
  function cargarInfoDeItemEnModalEdit(datosItem)  
  { 
    f1=datosItem.split('||');
           $('#textid_itemPDF_edit').val(f1[0]);
           var nombre_item = $('#name'+f1[0]).val();
           $('#textituloPDF_EDIT').val(nombre_item);
           $('#select_minPdf_EDIT').val(f1[4]);
           $('#select_segPdf_EDIT').val(f1[5]);
           /*cargamos el mobre del pdf*/
           var valoriframe = $('#'+f1[0]).val();
           $('#iframe_pdf').attr('src','archivos_pdf_capacitacion/'+valoriframe);

  }


  function cargarInfoDeItemLinkEnModalEdit(datosItem)  
  { $('#textid_itemLINK_edit').val('');
    $('#textituloLink_edit').val('');
    $('#textLink_Edit').val('');
    f1=datosItem.split('||');
        
           $('#textid_itemLINK_edit').val(f1[0]);
           var nombre_item = $('#name'+f1[0]).val();
           $('#textituloLink_edit').val(nombre_item);

           var valoriframe = $('#'+f1[0]).val();
           $('#textLink_Edit').val(valoriframe);
           document.getElementById("embed-youtube").innerHTML=valoriframe;
            //$('#iframe_link').attr('src',f1[4]);

  }

  function cargarInfoDeItemEXAMEN_EnModalEdit(datosItem)  
  { 
    f1=datosItem.split('||');
           $('#textid_itemEXAMEN_edit').val(f1[0]);
           var nombre_item = $('#name'+f1[0]).val();
           $('#textituloexamen_edit').val(nombre_item);
           $('#select_minExamenEdit').val(f1[4]);
           $('#select_segExamenEdit').val(f1[5]);
  }
  
  /*############## FIN FUNCION JAVASCRIPT QUE CARGA LOS DATOS DE UN ITEM AL MODAL EDITAR ITEM PDF*/
  



  //####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA ELIMINAR UN ITEM ##########
$(document).ready(function() { 
   $("#btn_eliminar_item").on('click', function() {
    $('#img_cargando_elim').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataElim = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();
   var textid_item=$('#textid_item').val();
   var text_numeroItem=$('#text_numeroItem').val();
   var text_tipoItem=$('#text_tipoItem').val();

   if ( textid_capacitacion=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina por favor e intente de nuevo','warning');
     $('#img_cargando_elim').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataElim.append('textid_capacitacion',textid_capacitacion);
     formDataElim.append('textid_item',textid_item);
     formDataElim.append('text_numeroItem',text_numeroItem);
     formDataElim.append('text_tipoItem',text_tipoItem);
      $.ajax({ url: 'controlador/control-eliminarItem.php', 
               type: 'post', 
               data: formDataElim, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se elimino con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_elim').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA ELIMINAR UN ITEM #############




  //####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA MOVER UN ITEM ##########
$(document).ready(function() { 
   $("#btn_moverItem").on('click', function() {
    $('#img_cargando_mover').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataMover = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();
   var textid_itemMover=$('#textid_itemMover').val();
   var text_numeroItemActual=$('#text_numeroItemActual').val();
   var select_numeroItemNuevo=$('#select_numeroItemNuevo').val();

   if ( text_numeroItemActual==select_numeroItemNuevo) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No puede mover una diapositiva a su mismo número','warning');
     $('#img_cargando_mover').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataMover.append('textid_capacitacion',textid_capacitacion);
     formDataMover.append('textid_itemMover',textid_itemMover);
     formDataMover.append('text_numeroItemActual',text_numeroItemActual);
     formDataMover.append('select_numeroItemNuevo',select_numeroItemNuevo);

      $.ajax({ url: 'controlador/control-MoverDeNumeroItem.php', 
               type: 'post', 
               data: formDataMover, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se movio con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal, intente nuevamente por favor','error');
                    $('#img_cargando_mover').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR MOVER UN ITEM #############



  //####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR UN ITEM DE TIPO PDF  ##########
$(document).ready(function() { 
   $("#btngEditItemPDF").on('click', function() {
    $('#img_cargando_editpdf').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataEditPdf = new FormData(); 
  
   var textid_itemPDF_edit=$('#textid_itemPDF_edit').val();
   var textituloPDF_EDIT=$('#textituloPDF_EDIT').val();
   var select_minPdf_EDIT=$('#select_minPdf_EDIT').val();
   var select_segPdf_EDIT=$('#select_segPdf_EDIT').val();
   var file_pdf_EDIT=$('#file_pdf_EDIT')[0].files[0];


   if ( textituloPDF_EDIT=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No puede dejar vacio el campo "Titulo del archivo"','warning');  
      $('#img_cargando_editpdf').hide();    
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataEditPdf.append('textid_itemPDF_edit',textid_itemPDF_edit);
     formDataEditPdf.append('textituloPDF_EDIT',textituloPDF_EDIT);
     formDataEditPdf.append('select_minPdf_EDIT',select_minPdf_EDIT);
     formDataEditPdf.append('select_segPdf_EDIT',select_segPdf_EDIT);
     formDataEditPdf.append('file_pdf_EDIT',file_pdf_EDIT);
      $.ajax({ url: 'controlador/control-EditarUnItemPDF.php', 
               type: 'post', 
               data: formDataEditPdf, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se Edito con Exito','success'); 
                    }
                    if (response == 2) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se Edito PDF con Exito','success'); 
                    } 
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');

                    $('#img_cargando_editpdf').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                     if (response==3) 
                     {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                       
                    setTimeout(function(){  }, 2000); swal('ATENCION','Ya hay un archivo con ese nonbre cambie el nombre del archivo PDF e intente nuevamente por favor','warning');
                    $('#img_cargando_editpdf').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                    
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR UN ITEM TIPO PDF #############




//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR UN ITEM DE TIPO LINK  ##########
$(document).ready(function() { 
   $("#btnEditLINK").on('click', function() {
 $('#img_cargando_linkEdit').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataEditLink = new FormData(); 
  
   var textid_itemLINK_edit=$('#textid_itemLINK_edit').val();
   var textituloLink_edit=$('#textituloLink_edit').val();
   var textLink_Edit=$('#textLink_Edit').val();
  
   if ( textituloLink_edit=='' || textLink_Edit=='') 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Debe completar todos los campos','warning'); 
         $('#img_cargando_linkEdit').hide();  
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataEditLink.append('textid_itemLINK_edit',textid_itemLINK_edit);
     formDataEditLink.append('textituloLink_edit',textituloLink_edit);
     formDataEditLink.append('textLink_Edit',textLink_Edit);
     
      $.ajax({ url: 'controlador/control-EditarUnItemLINK.php', 
               type: 'post', 
               data: formDataEditLink, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se Edito con Exito','success'); 
                    }
                  
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_linkEdit').hide(); 
                    //alert('Formato de imagen incorrecto.'); 
                    }
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR UN ITEM TIPO LINK #############


//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR UN ITEM DE TIPO EXAMEN  ##########
$(document).ready(function() { 
   $("#btnEditarExamen").on('click', function() {
    $('#img_cargando_examenEdit').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataEditExamen = new FormData(); 
  
   var textid_itemEXAMEN_edit=$('#textid_itemEXAMEN_edit').val();
   var textituloexamen_edit=$('#textituloexamen_edit').val();
   var select_minExamenEdit=$('#select_minExamenEdit').val();
   var select_segExamenEdit=$('#select_segExamenEdit').val();
  
   if ( textituloexamen_edit=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No puede dejar vacio el campo "Titulo de examen"','warning');
     $('#img_cargando_examenEdit').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataEditExamen.append('textid_itemEXAMEN_edit',textid_itemEXAMEN_edit);
     formDataEditExamen.append('textituloexamen_edit',textituloexamen_edit);
     formDataEditExamen.append('select_minExamenEdit',select_minExamenEdit);
     formDataEditExamen.append('select_segExamenEdit',select_segExamenEdit);
     
      $.ajax({ url: 'controlador/control-EditarUnItemEXAMEN.php', 
               type: 'post', 
               data: formDataEditExamen, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se Edito con Exito','success'); 
                    }
                  
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_examenEdit').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR UN ITEM TIPO EXAMEN #############



//####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR el nombre de la capacitacion  ##########
$(document).ready(function() { 
   $("#btn_editname_cap").on('click', function() {
    $('#img_cargando_editnameCap').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataEditNameCap = new FormData(); 
  
   var textid_capacitacion=$('#textid_capacitacion').val();
   var text_editNameCap=$('#text_editNameCap').val();
   
   if ( text_editNameCap=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No puede dejar vacio el campo "Nombre"','warning');
     $('#img_cargando_editnameCap').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php */
     
     formDataEditNameCap.append('textid_capacitacion',textid_capacitacion);
     formDataEditNameCap.append('text_editNameCap',text_editNameCap); 
      $.ajax({ url: 'controlador/control-EditNombreCapacitacion.php', 
               type: 'post', 
               data: formDataEditNameCap, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 1000); swal('EXELENTE','Se Edito con Exito','success'); 
                    }
                  
                    if (response==0) 
                   {
                   /*QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON*/ 
                    
                    setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    $('#img_cargando_editnameCap').hide();
                    //alert('Formato de imagen incorrecto.'); 
                    }
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//#########FIN CODIGO JS PARA LLAMAR AL CONTROLADOR PARA EDITAR el nombre de la capacitacion #############




</script>


