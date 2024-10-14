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
include_once('modelo/clsCapacitador.php');
$datosp=$_SESSION["usuarioP"];
$objcapat=new Capacitador();
$resultelef=$objcapat->mostrarElTelefonoDeUnCapacitadorCualquiera();
$filtel=mysqli_fetch_object($resultelef);
$numeroTelefono=$filtel->telefono;
?>


<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">


<div class="content-wrapper">
	<section class="content-header">
      <h1 >
    Mis  Capacitaciones
         <small>Completa al 100% las capacitaciones superando todas las diapositivas, ten encuenta que algunas diapositivas tienen un tiempo estimado para resolverlas.</small> 
      </h1>
       <a style="font-family: 'Arial Narrow',sans-serif;font-size: 13px;" target="blank" href="https://api.whatsapp.com/send?phone=591<?php echo $numeroTelefono ?>&text=Tengo una consulta" class="btn btn-success btn-xs">Consultar al capacitador <i class="fa fa-whatsapp"></i></a>
     <!--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>
      </ol> -->
    </section>
    <section class="content">
    	<div class="box">
    		
    		<div class="box-body">
    		
             
             <?php
              $objCap=new Capacitacion();
              $resulCap=$objCap->mostrarLasCapacitacionesEnCursoDeProc($datosp['id_procurador']);
              while ($filcap=mysqli_fetch_object($resulCap)) 
              {
                $numeroItemSuperado=$filcap->itemavanzado;
              	// $objCap1=new Capacitacion();
              	$resulTotalitem=$objCap->contadorDeItemsDeUnaCapacitacion($filcap->idcapacitacion);
              	$filtotalitem=mysqli_fetch_object($resulTotalitem);

              	$porcentaje_avanzado=($filcap->itemavanzado*100)/$filtotalitem->totalitem;

                $porcentaje_avanzadoFormato=number_format($porcentaje_avanzado, 0, '.', ' ');
               
// PREGUNTA SI EL NUMERO DE ITEM SUPERADO ES IGUAL AL TOTAL DEL ITEM, PARA QUE LE VUELVA A MOSTRAR DESDE EL PRIMER ITEM
               
                if ($numeroItemSuperado==$filtotalitem->totalitem) 
                {
                  $numeroItemSuperado=1;
                }
                else
                {
                  $numeroItemSuperado=$numeroItemSuperado+1;
                }

              /*HACEMOS LA ENCRIPTACION PARA ENVIAR POR LA URL*/
              $mascaracap=$filcap->idcapacitacion*12345;
              $encriptadaidCap=base64_encode($mascaracap);

              $mascaraNumitem=$numeroItemSuperado*123456;
              $encriptadaNumitem=base64_encode($mascaraNumitem);
              ?>
		        
		        <div class="col-md-4 col-sm-6 col-xs-12">
	    			<!-- Apply any bg-* class to to the info-box to color it -->
					<div class="info-box bg-green"> <!-- red aqua green -->

					  <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
					  <div class="info-box-content">
					    <span class="info-box-text"><b> <?php echo $filcap->nombrecapacitacion; ?></b></span>					  
					    <!-- The progress section is optional -->
					    <div class="progress" style="height: 10px;">
					      <div class="progress-bar" style="width: <?php echo $porcentaje_avanzado; ?>%; height: 10px;"></div>
					    </div>
					    <span class="progress-description ">
					     <b> Progreso <?php  echo $porcentaje_avanzadoFormato; ?>%</b>
					    </span>
					    <br>
					     <span>Tiene un avance de <b style="font-size: 15px;"><?php echo $filcap->itemavanzado ?></b>  diapositivas superadas de un total de <b style="font-size: 15px;"> <?php echo $filtotalitem->totalitem ?></b> diapositivas de la capacitacion</span>
					     <br>
               
               <div>
					    <button class="btn btn-default btn-xs" style="margin-top: 10px;font-family: 'Arial Narrow',sans-serif;font-size: 13px; background: " onclick="location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $encriptadaidCap ?>&num_d=<?php echo $encriptadaNumitem ?> '">Ir a las Diapositivas</button>


              <button class="btn btn-danger btn-xs" style="margin-top: 10px;font-family: 'Arial Narrow',sans-serif;font-size: 13px;" data-toggle="modal" data-target="#modal-restablecer" onclick="llevaridProceso('<?php echo $filcap->idproceso ?>')">Restablecer capacitación <i class="fa fa-refresh"></i></button>
              </div>

					  </div>
					  
					  <!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->

					  	
					  
				</div>
		        <!-- ./col -->
              <?php
              }/*FIN DEL WHILE QUE MUESTRA TODOS LOS CURSOS DE CAPACITACION DISPONIBLES PARA QUE TOME UN PROCURADOR*/
              ?>

				
    		</div>
    		
    	</div>
    </section>
</div>


<!--MODAL PARA DESACTIVAR LA CAPACITACION -->
        <div class="modal modal-success fade" id="modal-restablecer">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Restablecer avance</h4>
              </div>
              <div class="">
                 <input type="hidden" name="textid_proceso" id="textid_proceso" placeholder="id proceso" value="">
               
                <div class="box-body">
                <label style="color: black;" for="exampleInputEmail1">Se restablecera su avance a 0%, esta seguro de restablecer?</label>
                
                </div>


              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline" id="btn_restablecer" name="btn_restablecer">Restablecer <img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif"></button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!-- FIN DE MODAL PARA DESACTIVAR LA CAPACITACION -->




<?php require_once("footer.php");?>
<!-- itemavanzado *100/totalitemde capacitacion
1,2,
3,4,
5,6,
7,8,
9,10,
11,12,
13,14,
15,16,
17,18,
19,20 -->
<script type="text/javascript">
  function llevaridProceso(idproceso) 
  {
    $('#textid_proceso').val(idproceso);
  }




  //####### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA RESTABLECER EL AVANCE ##########
$(document).ready(function() { 
   $("#btn_restablecer").on('click', function() {
      $('#img_cargando').show();
   /*cargamos los inputs a nuevas variables*/ 
   var formDataRestablecer= new FormData(); 
   var textid_proceso=$('#textid_proceso').val();
  
   if ( textid_proceso=='' ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Alguno datos se perdieron, por favor recargue la pagina y vuelva a intentar','warning');
      $('#img_cargando').hide();      
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra el item*/
     formDataRestablecer.append('textid_proceso',textid_proceso);
    
      $.ajax({ url: 'controlador/control-RestablecerProcesoCapacitacion.php', 
               type: 'post', 
               data: formDataRestablecer, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) { 
                    setTimeout(function(){ location.reload(); }, 500); swal('EXELENTE','Se restablecio con exito','success'); 
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
//######### CODIGO JS PARA LLAMAR AL CONTROLADOR PARA GUARDAR UN ITRM TIPO LINK DE YOUTUBE#############


</script>