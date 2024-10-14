<?php 


require_once("cabezoteProc.php");
require_once("menuProc.php");
include_once('modelo/clsCapacitacion.php');
include_once('modelo/clsProcesoCapacitacion.php');
include_once('modelo/clsItemCapacitacion.php');
$datosp=$_SESSION["usuarioP"];
$idcapacitacionGET=$_GET['cod_cap'];
             
             /*OBTENEMOS EL NUMERO DEL ITEM AVANZADO EN SU PROCESO DE CAPACITACION*/
             $objprecesoAvance=new Proceso_Capacitacion();
             $resultproceso=$objprecesoAvance->mostrarItemAvanzadoDeUnaCapacitacionDeProcurador($idcapacitacionGET,$datosp['id_procurador']);
             $filavance=mysqli_fetch_object($resultproceso);

             $numeroItemavanzado=$filavance->nomero_item_avanzado;
             $idproceso=$filavance->id_proceso;

             /*AL ITEM AVANZADO SE LE AUMENTA UNO, YA QUE ESTE ITEM DESPUES */
               $numeroItemPorsuperar=$numeroItemavanzado+1;
            
             
             /*OBTENEMOS EL ITEM QUE LE TOCA SUPERAR*/
             $objpItem=new Item_Capacitacion();
             $resultItem=$objpItem->mostrarUnItemDeCapacitacion($idcapacitacionGET,$numeroItemPorsuperar);
             $filItem=mysqli_fetch_object($resultItem);
             $tipoItemPorSuperar=$filItem->tipo_item;
        // PREGUNTAMOS QUE TIPO DE ITEM ES EL ITEM POR SUPERAR
             if ($tipoItemPorSuperar=='PDF') 
             {
                $recursos='archivos_pdf_capacitacion/'.$filItem->nombre_item_interno;
             }
             else
             {
               if ($tipoItemPorSuperar=='LINK') 
               {
                 $recursos=$filItem->nombre_item_interno;
               }
             }



             /*OBTENEMOS EL TOTAL ITEMS DE UNA CAPACITACION*/
             $resultTotalItemdeCap=$objpItem->contarItemDeUnaCapacitacion($idcapacitacionGET);
             $filTotalitem=mysqli_fetch_object($resultTotalItemdeCap);
             $totalitemDeCap=$filTotalitem->totalItem;



/*CONVERTIMOS EL TIEMPO DEL ITEM EN SEGUNDOS PARA USARLOS EN LA FUNCION JAVASCRIPT DE CUENTA REGRESIVA*/
             $TiempoDeItem=date_create($filItem->tiempo_item);
             $TiempoDeItemFormato=date_format($TiempoDeItem, 'H:i:s');

             $TiempoDeItemFormatoVista=date_format($TiempoDeItem, 'i:s');

             $horaNula= date("00:00:00");/*HORA NULA PARA SACAR LA DIFERENCIA ENTRE EL TIEMPO DEL ITEM*/
             $DtTimeHoraNula =new DateTime($horaNula);/*CREACION DEL OBJETO DateTime*/
             $DtTiempoDeItemFormato =new DateTime($TiempoDeItemFormato);/*CREACION DEL OBJETO DateTime*/
             
             $Intervalo= $DtTimeHoraNula->diff($DtTiempoDeItemFormato);

             $HorasEnteros=intval($Intervalo->format('%H'));
             $minutosEnteros=intval($Intervalo->format('%i'));
             $segundosEnteros=intval($Intervalo->format('%s'));

             // echo "<br>";
             // echo "Horas: ".$HorasEnteros;
             // echo "<br>";
             // echo "Minutos: ".$minutosEnteros;
             // echo "<br>";
             // echo "Segundos: ".$segundosEnteros;
             $min_A_segundos=$minutosEnteros*60;

             $SumadosLosSegundosDelItem=$min_A_segundos+$segundosEnteros;
             
            ?>

<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

<!-- content-wrapper -->
<div class="content-wrapper">

   <!-- SECTION content -->
    <section class="content"> 
    <!-- DIV box   -->
   	<div class="box">
    	
       <!-- div box-body -->
    		<div class="box-body">


<!-- TITULOS DEL ITEM Y TIEMPO DEL ITEM (SI NO ES LINK DE YOUTUBE) -->
           <small>
            <?php echo $filItem->nombre_item; ?> | TIEMPO ITEM:<?php echo $filItem->tiempo_item; 
              ?>
              | Tiempo restanta <small style="font-size: 20px;" id="time"><?php echo $TiempoDeItemFormatoVista; ?></small>
              <i style="color: blue; font-size: 15px;" class="fa fa-check-square"></i> 
         </small>
<!--FIN TITULOS DEL ITEM Y TIEMPO DEL ITEM (SI NO ES LINK DE YOUTUBE) -->



  <!-- CUERPO Y CONTENIDO PRINCIPAL DEPENDERA MUCHO DEL TIPO DE ITEM ACTUAL -->
    		     <div class="content">
             <iframe style="width: 100%; height: 430px;" src="<?php echo $recursos; ?>"></iframe>
             </div>
  <!--FIN  CUERPO Y CONTENIDO PRINCIPAL DEPENDERA MUCHO DEL TIPO DE ITEM ACTUAL -->


  <!-- VALORES QUE SE NECESITA PARA ACTUALIZAR EL AVANCE E INFORMACION DEL ITEM ACTUAL-->
      <input type="text" name="text_tipoItem" id="text_tipoItem" value="<?php echo $tipoItemPorSuperar; ?>">
      <input type="text" name="textid_procesoavance" id="textid_procesoavance" placeholder="idProceso" value="<?php echo $idproceso; ?>">
      <input type="text" name="textitemPorSuperar" id="textitemPorSuperar" placeholder="Item Por Superar" value="<?php echo $numeroItemPorsuperar; ?>">

      <input type="text" name="textTotalItem" id="textTotalItem" placeholder="Total de item" value="<?php echo $totalitemDeCap; ?>">

  <!--FIN VALORES QUE SE NECESITA PARA ACTUALIZAR EL AVANCE E INFORMACION DEL ITEM ACTUAL-->


   <!-- SECIION DE ATRAS Y SIGUIENTE           -->
				<div class="div_next_atras">
          <button type="button" class="btn btn-primary pull-left"><i class="fa fa-hand-o-left"> Anterior </i></button>

          <?php
          if ($numeroItemPorsuperar==$totalitemDeCap) 
          {?>

            <button type="button" class="btn btn-primary pull-right" id="btnsiguiente" name="btnsiguiente">Finalizar <i class="fa  fa-check-square-o"></i>
             </button>

          <?php
          }/*FIN DEL IF QUE PREGUNTA SI ESTA EN EL ULTIMO ITEM*/

          else/*POR FALSO LE MOSTRARA EL BOTON SIGUIENTE*/
          {?>
            <button type="button" class="btn btn-primary pull-right" id="btnsiguiente" name="btnsiguiente">Siguiente <i class="fa fa-hand-o-right"></i>
            </button> 
          <?php
          }
          ?>

          
        </div>
  <!--FIN  SECIION DE ATRAS Y SIGUIENTE           -->


    		</div>
       <!--end div box-body -->



   <!-- SECCION DE PIE DE PAGINA  -->
       <center> 
        <small>Diapositiva Nº:<b> <?php echo $filItem->numero_item; ?></b> de <b><?php echo $totalitemDeCap; ?> </b> </small>
       </center>
  <!--FIN  SECCION DE PIE DE PAGINA  -->
 		
    	</div>
      <!--end  DIV box   -->
    </section>
    <!--END SECTION content -->
</div>
<!--END content-wrapper -->



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


<!-- The Modal MODAL DE ALERTA CUANDO SE EXPIRA EL TIEMPO DEL ITEM -->
<div id="myModalformacep" class="modal" >
  <!-- Modal content -->
  <center>
  <div class="modal-content" style="width: 300px; margin-top: 30px;">
    <div class="modal-header" style="background: red;">
      <br> 
    </div>
     <div><br>
      <center> <p style="font-size: 20px;font-family: fantasy;" >El tiempo estimado para superar esta diapositiva se a vencido</p></center>
     </div>
    <form >
        <div class="modal-body">
          
        </div>
          <div class="modal-footer" style="background: red;">
          
         <center> <button class=" btn btn-danger " id="btnokalerta" type="button">OK</button></center>
        </div>
      </form>
    </div></center>

  </div>
  <!--FIN  --- The Modal MODAL DE ALERTA CUANDO SE EXPIRA EL TIEMPO DEL ITEM -->


 

<!--SCRIP QUE LLAMA AL MODAL (FORMULARIO) PARA ACEPTAR LA DESCARGA -->
<script>
// Get the modal
$(document).ready(function() { 
   $("#btnokalerta").on('click', function() {
         location.href='capacitaciones.php';
         }); 
  });
// var modalformacep = document.getElementById("myModalformacep");

// // Get the button that opens the modal
// var btnacep = document.getElementById("myBtnformacep");
// var btncloseformac = document.getElementById("btncloseformacep");

// // Get the <span> element that closes the modal
// var spancloseacp = document.getElementById("spancloseacep");

// // When the user clicks the button, open the modal 
// btnacep.onclick = function() {
//   modalformacep.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// spancloseacp.onclick = function() {
//   modalformacep.style.display = "none";
// }
// btncloseformac.onclick=function() {
//   modalformacep.style.display = "none";
// }

/* When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}*/
</script>




 <script type="text/javascript">
  //---------------------- CRONOMETRO DE CUENTA REGRESIVA/
  var tipodeItem=$('#text_tipoItem').val();
  if (tipodeItem=="PDF" || tipodeItem=="EXAMEN") 
  {
    empezarCronometro()
  }
    function startTimer(duration, display) 
    { 
       var timer = duration, minutes, seconds; 
       setInterval(function () 
        { 
          minutes = parseInt(timer / 60, 10); 
          seconds = parseInt(timer % 60, 10); 
          minutes = minutes < 10 ? "0" + minutes : minutes; 
          seconds = seconds < 10 ? "0" + seconds : seconds; 
          display.textContent = minutes + ":" + seconds; 
          if (--timer < 0) 
            { 
              timer = 0;
              // SE ACABA EL TIEMPO Y MUESTRA EL MODAL DE EXPIRACION DE TIEMPO DE ITEM
              var modalformacep = document.getElementById("myModalformacep"); 
               modalformacep.style.display = "block";
             // location.href='capacitaciones.php';
            } 
          }, 1000); 
     } 
       function  empezarCronometro() 
      { 
        
      var totalsegundosdelItem=<?php echo $SumadosLosSegundosDelItem ?>; 

        var cuentaRegresiva = totalsegundosdelItem, display = document.querySelector('#time'); 
        startTimer(cuentaRegresiva, display); 
      }

//----------------------FIN CRONOMETRO DE CUENTA REGRESIVA------------------/






//----------------------AL HACER CLICK EN SIGUIENTE (LLAMA AL CONTROLADOR PARA ACTUALIZAR EL AVANCE)------------------/
 $(document).ready(function() { 
   $("#btnsiguiente").on('click', function() {

   /*cargamos los inputs a nuevas variables*/ 
   var formDataUp = new FormData(); 
   
   var idproceso=$('#textid_procesoavance').val();
   var num_itemactual_avanzado=$('#textitemPorSuperar').val();
   var totalItemDelaCap=$('#textTotalItem').val();
   

   if ( (idproceso=='') || (num_itemactual_avanzado=='')  ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina e intente nuevamente','warning'); 
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataUp.append('idproceso',idproceso);
     formDataUp.append('num_itemactual_avanzado',num_itemactual_avanzado);
     
      $.ajax({ url: 'controlador/control-ActualizarProcesoCapacitacion.php', 
               type: 'post', 
               data: formDataUp, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                 if (response == 1) 
                 {
                    // ACTUALIZO EL AVANCE CON EXITO
                    if (num_itemactual_avanzado==totalItemDelaCap) 
                    {
                      setTimeout(function(){ location.href='mis_capacitaciones.php'; }, 1500); swal('Capacitacion vencida','','success');
                      
                    }
                    else
                    {
                       location.reload(); 
                    }
                   
                    // setTimeout(function(){ location.reload(); }, 500); swal('EXELENTE','Los datos se crearon con Exito','success'); 
                  } 
                  if (response==0) 
                   {
                   // QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON 
                    
                   //  setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                    //alert('Formato de imagen incorrecto.'); 
                    }
                  
                 
                } 
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
//-------------FIN--AL HACER CLICK EN SIGUIENTE (LLAMA AL CONTROLADOR PARA ACTUALIZAR EL AVANCE)------------------/

</script>