<?php 
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioP"]))
{
  header("location:index.php");
}

require_once("cabezoteProc.php");
require_once("menuProc.php");
include_once('modelo/clsCapacitacion.php');
$datosp=$_SESSION["usuarioP"];
?>
<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

<div class="content-wrapper">
	<section class="content-header">
      <h1 >
      Capacitaciones Para Procuradores 
       <small>Elije una capacitación y preparate como procurador, debes superar todas las diapositivas de la capactación.</small>
      </h1>
     <!--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>
      </ol> -->

      <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/d8odPbC8Yhk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
      
    </section>
    <section class="content">
    	<div class="box">
    		
    		<div class="box-body">
    		
             
             <?php
              $objCap=new Capacitacion();
              $resulCap=$objCap->listarCapacitacionesQuePuedeTomarUnProcurador($datosp['id_procurador']);
              while ($filcap=mysqli_fetch_object($resulCap)) 
              {
              	$datosCapacitacion=$filcap->idcapacitacion; //."||".
		       // $filcap->nombrecapacitacion;
		          echo "<input type='hidden' id='nombrecapa$filcap->idcapacitacion' name='nombrecapa$filcap->idcapacitacion' value='$filcap->nombrecapacitacion'>";
		       
              ?>
		          <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-blue">
		            <div class="inner">
		              <h3><i class="fa fa-laptop"></i> </h3>

		              <h4> <?php echo $filcap->nombrecapacitacion; ?></h4>
		            </div>
		            <div class="icon">
		              <i class="fa fa-mortar-board"></i>
		            </div>
		            <a class="small-box-footer">
		            	<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-info" onclick="CargarinfoDeCapacitacionEnModal('<?php echo $datosCapacitacion ?>')">Capacitarme Ahora</button>
		            </a>
		            
		          </div>
		        </div>
		        <!-- ./col -->
              <?php
              }/*FIN DEL WHILE QUE MJESTRA TODOS LOS CURSOS DE CAPACITACION DISPONIBLES PARA QUE TOME UN PROCURADOR*/
              ?>

				
    		</div>
    		
    	</div>
    </section>
</div>






 <!-- MODAL ACEPTAR CAPACITACION -->
 <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal_titulo_capacitacion">Info Modal</h4>
              </div>
              <div  style="color: black;">
                <div class="box-body">
                	<input type="hidden" name="textid_capacitacion" id="textid_capacitacion">
                	<input type="hidden" name="textid_procurador" id="textid_procurador" value="<?php echo $datosp['id_procurador'] ?>">
	                <label style="color: black;" for="confirmacion" >Esta seguro de tomar esta capacitacion ahora?</label>
	                <div class="input-group">
	                  
	                </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btnempezacapacitacion" name="btnempezacapacitacion">Empezar Capacitacion<img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal --> 


 <script type="text/javascript">

  function CargarinfoDeCapacitacionEnModal(datosCapacitacion) 
  {
    
    f=datosCapacitacion.split('||');
     $('#textid_capacitacion').val(f[0]);
     var nombre_capac = $('#nombrecapa'+f[0]).val();
      $('#modal_titulo_capacitacion').text(nombre_capac);
           
          // $('#textidalim').val(f[0]);

  }
</script>


<!--CODIGO JAVAESCRIPT QUE LLAMA AL CONTROLADOR CREAR UN EMPEZAR UNACAPACITACION (GUARDA EN LA TABLA proceso_capacitacion)-->
<script> 

   $(document).ready(function() { 
   $("#btnempezacapacitacion").on('click', function() {
      $('#img_cargando').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   
   var textid_capacitacion=$('#textid_capacitacion').val();
   var textid_procurador=$('#textid_procurador').val();
   

   if ( (textid_capacitacion=='') || (textid_procurador=='')  ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina e intente nuevamente','warning'); 
      $('#img_cargando').hide();
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataUp.append('textid_capacitacion',textid_capacitacion);
     formDataUp.append('textid_procurador',textid_procurador);
     
      $.ajax({ url: 'controlador/control-RegProcesoCapacitacion.php', 
               type: 'post', 
               data: formDataUp, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.href='mis_capacitaciones.php'; }, 500); swal('EXELENTE','Capacitacion Iniciada','success'); 
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
   </script>

<?php require_once("footer.php");?>

