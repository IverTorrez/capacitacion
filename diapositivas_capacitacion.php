<?php 
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioP"]))
{
  header("location:index.php");
}

//require_once("cabezoteProc.php");


//require_once("menuProc.php");
include_once('modelo/clsCapacitacion.php');
include_once('modelo/clsProcesoCapacitacion.php');
include_once('modelo/clsItemCapacitacion.php');

include_once('modelo/clsPregunta.php');
include_once('modelo/clsRespuesta.php');

$datosp=$_SESSION["usuarioP"];
/*******************************decodificamos los codigo*************************/
$idCapCodificadoGet=$_GET['cod_cap'];
$numerItemCodificadoGET=$_GET['num_d'];
/*id capacitacion*/
$decodificadoidCap=base64_decode($idCapCodificadoGet);
$codigonuevoidCap=$decodificadoidCap/12345;
/*numero item*/
$decodificadoNumItem=base64_decode($numerItemCodificadoGET);
$codigonuevoNumItem=$decodificadoNumItem/123456;

/************************datos validos para usar en el codigo***************/
$idcapacitacionGET=$codigonuevoidCap;
$numeroItemGET=$codigonuevoNumItem;

$numeroItemSiguiente=$numeroItemGET+1;
$numeroItemAnterior=$numeroItemGET-1;

/***********************CODIFICAMOS NUMERO ITEM SIGUIENTE Y  ANTERIOR************/
// siguiente
$mascaraSig=$numeroItemSiguiente*123456;
$encriptadoItemSiguiente=base64_encode($mascaraSig);

// anterior
$mascaraAnterior=$numeroItemAnterior*123456;
$encriptadoItemAnterior=base64_encode($mascaraAnterior);
             
             /*OBTENEMOS EL NUMERO DEL ITEM AVANZADO EN SU PROCESO DE CAPACITACION*/
             $objprecesoAvance=new Proceso_Capacitacion();
             $resultproceso=$objprecesoAvance->mostrarItemAvanzadoDeUnaCapacitacionDeProcurador($idcapacitacionGET,$datosp['id_procurador']);
             $filavance=mysqli_fetch_object($resultproceso);

             $numeroIteSuperado=$filavance->nomero_item_avanzado;
             $idproceso=$filavance->id_proceso;
               
             // PREGUNTA SI EL NUMERO DE ITEM OBTENIDO POR EL GET NO SEA MAYOR AL ULTIMO ITEM SUPERADO O SI ES CERO, por verdadero lo redirecciona al ultimo item superado
             if ($numeroItemGET<=0) 
             {
              echo "<script>location.href='mis_capacitaciones.php';</script>";
             }
             else
             {
               
               if ( ($numeroItemGET-1>$numeroIteSuperado) ) 
               {
                 echo "<script>location.href='diapositivas_capacitacion.php?cod_cap=$idCapCodificadoGet&num_d=$numeroIteSuperado';</script>";
               }
             }
             

             /*CARGAMOS EL ITEM QUE OBTENEMOS POR GET(ITEM ACTUAL (NO ES EL MISMO ITEM POR SUPERAR, PUEDE SER CUALQUIER ITEM)) */
               $numeroItemActualVista=$numeroItemGET;
              
            // POR VERDADERO SIGNIFICA QUE EL ITEM ACTUAL ES UN ITEM YA SUPERADO  Y NO NECESITAMOS REGISTRAR AVANCE
              if ($numeroItemGET<=$numeroIteSuperado) 
              {
                 $colorCheck='blue';
                 $estadoItemActual='superado';
                 $avisoChecK='Superado';
              }
              //POR FALSO SIGNIFICA QUE ES UN ITEM SIN SUPERAR (DEBE SER REGISTRADO EL AVANCE SOLO SI ES EL SIGUIENTE POR SUPERAR)
              else 
              {
                $colorCheck='none';
                $estadoItemActual='nosuperado';
                $avisoChecK='No superado';
              }
            
             
             /*OBTENEMOS EL ITEM ACTUAL*/
             $objpItem=new Item_Capacitacion();
             $resultItem=$objpItem->mostrarUnItemDeCapacitacion($idcapacitacionGET,$numeroItemActualVista);
             $filItem=mysqli_fetch_object($resultItem);
             $tipoItemPorSuperar=$filItem->tipo_item;
             $iditem=$filItem->id_item;
        // PREGUNTAMOS QUE TIPO DE ITEM ES EL ITEM POR SUPERAR
             if ($tipoItemPorSuperar=='PDF') 
             {
                $recursos='../../archivos_pdf_capacitacion/'.$filItem->nombre_item_interno;
                 $nombreFilePDF=$filItem->nombre_item_interno;
               // $recursos=$filItem->nombre_item_interno;
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
<!DOCTYPE html>

<html>
<head>
  <link rel="icon" href="recursos/img/plantilla/logoserrate3.jfif">
</head>
<body>

<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">

<div class="nav_bar1">


  <?php
  require_once("cabezoteProcDiapositiva.php");
  ?>
  
</div>

 
<!-- TITULOS DEL ITEM Y TIEMPO DEL ITEM (SI NO ES LINK DE YOUTUBE) -->
<div class="div_titulos2">
  

           <small style="margin-left: 6px;">  
            <?php echo $filItem->nombre_item; ?>  

           
            <?php
              if ($estadoItemActual=='nosuperado' AND $tipoItemPorSuperar!='LINK') 
              {
              ?>

              <!--   Tiempo Total para superar esta diapositiva:<?php echo $filItem->tiempo_item; 
              ?> -->
             <b>| </b>Tiempo restante 
              <small style="font-size: 20px;" id="time"><?php echo $TiempoDeItemFormatoVista; ?></small>
              <?php
              }
            ?>
            



              <i style="color: <?php echo $colorCheck ?>; font-size: 15px;" class="fa fa-check-square"> <?php echo $avisoChecK ?></i>

               <button type="button" class='btn btn-success btn-xs pull-right' style="margin-right: 15px;margin-top: 2px;" onclick="location.href='mis_capacitaciones.php'">Continuar despues</button> 
         </small>

      
         <?php
         if ($estadoItemActual=='nosuperado') 
         {
           if ($tipoItemPorSuperar=='EXAMEN') 
           {
            ?>

           <!--  |<small class=""> Seleccione las respuestas correctas</small> -->
           <?php
           }
         ?>
          <!-- <small class="pull-right">Pulse el boton "Siguiente" para superar esta diapositiva</small> -->
         <?php    
         }  
         ?>
        
</div>
<!-- <./FIN DE DIV TITULOS2> -->

<!--FIN TITULOS DEL ITEM Y TIEMPO DEL ITEM (SI NO ES LINK DE YOUTUBE) -->
      


  <!-- CUERPO Y CONTENIDO PRINCIPAL DEPENDERA MUCHO DEL TIPO DE ITEM ACTUAL -->
    <div class="cuerpo_diapositiva" style="  background: #e8e9ea;width: 100%; overflow: scroll;">
            <?php
            if ($tipoItemPorSuperar=='PDF' || $tipoItemPorSuperar=='LINK') 
            {
                if ($tipoItemPorSuperar=='PDF') 
                {
                   $NamePDF=$recursos;
                    $_SESSION["sessionPDF"]=$nombreFilePDF;
                 ?>
                 <!-- <iframe style="width: 100%; height: 430px;" src="<?php echo $recursos; ?>"></iframe> -->
                 <iframe class="iframe_pdf" style="width: 100%; " src="pdfjs_lector/web/viewer.php?nameDoc=<?php echo $nombreFilePDF; ?>"></iframe>
                 <?php
                }
              else
              {
              ?>
                <div id="embed-youtube">
              <?php
                echo $recursos;
              ?>
               </div>
              <?php
              }
            ?>
             
            <?php
            $contadordePreguntas=0;
            }
            else
            {
              /*SI ES ITEM EXAMEN, MOSTRAREMOS EL EXAMEN*/
              if ($tipoItemPorSuperar=='EXAMEN') 
              {
                    $contadordePreguntas=1;
                    $nombreDelRadioGroup=1;
                    $objPregunta=new Preguntas();
                    $resulTpreg=$objPregunta->listarTodasLaPreguntasDeItemExamen($iditem);
                    while ($filpregunta=mysqli_fetch_object($resulTpreg)) 
                    {

                          echo "<label style='margin-left:8px;margin-top:7px;'>$contadordePreguntas) $filpregunta->pregunta</label>";
                          echo '<br>'; 

                          $posisionIncisos=0;
                          $arrayIncisos=array('A','B','C','D','E','F');
                          $objresP=new Respuesta();
                          $resulResp=$objresP->listarRespuestasDeUnaPregunta($filpregunta->id_pregunta);
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
                           <div class="" style=" margin-left: 20px; width: 90%;">
                                <div class="input-group">
                                <span class="input-group-addon">
                                  <?php
                                   echo "<label>$arrayIncisos[$posisionIncisos] )</label>"
                                   ?>
                                <input type="radio" id="<?php echo $nombreDelRadioGroup; ?>" value="<?php echo $filrespu->valor; ?>" name="<?php echo $nombreDelRadioGroup; ?>">
                                       
                                </span>
                                    <label class="form-control" style="height: 100%;"><?php echo $filrespu->respuesta; ?> </label>
                                </div>
                            <!-- /input-group -->
                            
                            </div>

                          <?php
                          $posisionIncisos++;
                          }/*FIN DEL WHILE QUE RRECORRE TODAS LAS RESPUESTAS*/
                      echo '<br>';
                      $contadordePreguntas++;
                      $nombreDelRadioGroup++;

                    }/*FIN DEL WHILE QUE RECORRE TODAS LAS PREGUNTAS*/
                  echo "<br>";
   
              }/*FIN DEL IF QUE MUESTRA EL EXAMEN*/

            }/*FIN DEL ELSE QUE SUCEDE A NO SER ITEM PDF O LINK*/

            ?>
    		     
            
      </div>
  <!--FIN  CUERPO Y CONTENIDO PRINCIPAL(cuerpo_diapositiva) DEPENDERA MUCHO DEL TIPO DE ITEM ACTUAL -->




  <!-- VALORES QUE SE NECESITA PARA ACTUALIZAR EL AVANCE E INFORMACION DEL ITEM ACTUAL-->
  <div class="div4_footer_pagina">
    
  
      <input type="hidden" name="text_estadoItemActual" id="text_estadoItemActual" value="<?php echo $estadoItemActual; ?>">
      <input type="hidden" name="text_tipoItem" id="text_tipoItem" value="<?php echo $tipoItemPorSuperar; ?>">
      <input type="hidden" name="textid_procesoavance" id="textid_procesoavance" placeholder="idProceso" value="<?php echo $idproceso; ?>">
      <input type="hidden" name="textitem_actual" id="textitem_actual" placeholder="Item actual" value="<?php echo $numeroItemActualVista; ?>">
       <input type="hidden" name="text_ultimoItemSuperado" id="text_ultimoItemSuperado" placeholder="ultimo Item superado" value="<?php echo $numeroIteSuperado; ?>">
      <input type="hidden" name="textTotalItem" id="textTotalItem" placeholder="Total de item de la capacitacion" value="<?php echo $totalitemDeCap; ?>">
    <!-- en este input se carga el numero de item al que tiene que irse despues que se leacacbe el tiempo -->
      <input type="hidden" name="text_numItem_A_Ir" id="text_numItem_A_Ir" value="">

  <!--FIN VALORES QUE SE NECESITA PARA ACTUALIZAR EL AVANCE E INFORMACION DEL ITEM ACTUAL-->


   <!-- SECCION DE ATRAS Y SIGUIENTE           -->
       <div class="div_next_atras">
       <?php
       if ($numeroItemAnterior>0) 
       {?>
        <button type="button" class="btn btn-primary pull-left" id="btnanterior" onclick="location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d=<?php echo $encriptadoItemAnterior ?>'"><i class="fa fa-hand-o-left"> Anterior <img style="width: 20px;display: none;" id="img_cargando_anterior" src="recursos/gif/cargando.gif"></i></button>
        <?php
       }
       ?>
				
          


<?php
   // PREGUNTA SI ES EL ULTIMO ITEM Y ESTA SUPERADO, ENTONCES NO MOSTRARA NADA, POR FALSO HABRA OTRA CONDICION
  if ($numeroItemActualVista==$totalitemDeCap and $estadoItemActual=='superado')
    {
           
    }
    else
    {
          // PREGUNTAMOS SI ESTE ES EL ULTIMO ITEM POR SUPERAR, POR VERDADERO SE MOSTRARA EL BOTON FINALIZAR,POR FALSO SE MOSTRARA EL BOTON SIGUIENTE
          if ($numeroItemActualVista==$totalitemDeCap) 
          {?>

            <button type="button" class="btn btn-primary pull-right" id="btnsiguiente" name="btnsiguiente">Finalizar <i class="fa  fa-check-square-o"></i><img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif">
             </button>

          <?php
          }/*FIN DEL IF QUE PREGUNTA SI ESTA EN EL ULTIMO ITEM*/

          else/*POR FALSO LE MOSTRARA EL BOTON SIGUIENTE*/
          {?>
            <button type="button" class="btn btn-primary pull-right" id="btnsiguiente" name="btnsiguiente">Siguiente <i class="fa fa-hand-o-right"></i><img style="width: 20px;display: none;" id="img_cargando" src="recursos/gif/cargando.gif">
            </button> 
          <?php
          }
    }/*FIN DEL ELSE DE DOBLE CONDICION, ITEM==TOTALITEM AND ESTADO DEL ITEM==superado*/
          ?>

          
        </div>
  <!--FIN  SECCION DE ATRAS Y SIGUIENTE           -->



  <center>
  <div class="form-control">
    <input type="text" style="width: 100px;"  name="text_cajabusqueda" id="text_cajabusqueda" placeholder="Nº Diapositiva">
    <button type="button" class="btn btn-primary btn-xs" id="btnBuscarItem" name="btnBuscarItem">Ir <i class="fa fa-search"></i><img style="width: 20px;display: none;" id="img_cargando_buscar" src="recursos/gif/cargando.gif"></button>
  </div>
  </center>

   <!-- SECCION DE PIE DE PAGINA  -->
       
       <center>
       <div>
        
        <tr>
          <td>
            <small>Diapositiva Nº:<b> <?php echo $filItem->numero_item; ?></b> de <b><?php echo $totalitemDeCap; ?> </b> 

        </small>
          </td>
        </tr>
        
         </div> 
       </center>

</div>
<!-- <.fin de div4_footer/> -->
  <!--FIN  SECCION DE PIE DE PAGINA  -->
 		

</body>
</html>

<style type="text/css">
  html,body{ 
     
      height:100%; width:100%; margin: 0px;
      /*background: red; */
      }
      .nav_bar1{
        /*height: 5%; */
        width: 100% ;
         /*background: orange;*/
      } 
      .div_titulos2{
        /*height: 25px; */
        /*margin-top: 17px;*/
        width: 100% ;
        /*background: blue;*/

      }
  .cuerpo_diapositiva{
     -moz-background-size: cover; 
            -o-background-size: cover; 
            background-size: cover; 
            height: 87%; 
            width: 100% ; 
           
  }
  .iframe_pdf{
    height: 99%; 
    width: 100% ;
  }
  .div4_footer_pagina{
    height: 7%; 
   width: 100% ;

  }

</style>

<?php //require_once("footer.php");?>
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
  <div class="modal-content" style="width: 70%; height: 60%; margin-top: 30px; margin-bottom: 30px;">
    <div class="modal-header" style="background: red;">
      <br> 
    </div>
     <div><br>
      <center> <p style="font-size: 30px;" >El tiempo estimado para superar esta diapositiva se a vencido</p></center>
     </div>
    <form >
        <div class="modal-body">
          
        </div>
          <div class="modal-footer" style="background: red;">
          
         <center> <button style="width: 20%;" class=" btn btn-danger " id="btn_ok_finis_time" type="button">OK</button></center>
        </div>
      </form>
    </div></center>

  </div>
  <!--FIN  --- The Modal MODAL DE ALERTA CUANDO SE EXPIRA EL TIEMPO DEL ITEM -->


 

<!--SCRIP -->
<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnanterior").on('click', function() {
          $('#img_cargando_anterior').show();
        }); /*FIN DE LA FUNCION CLICK DEL BOTON SIGUIENTE*/
  });



// FUNCION QUE SE EJECUTA AL PRESIONAR EL BOTON OK DE LA ALERTA DE FINALIZACION DEL TIEMPO ESTIMADO DEL ITEM
$(document).ready(function() { 
   $("#btn_ok_finis_time").on('click', function() {
              var numeroItemDondeIr_encriptado=$('#text_numItem_A_Ir').val();
             location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d='+numeroItemDondeIr_encriptado;
        
         });/*FIN DEL AFUNCION CLICK DE BOTON OK*/ 



  });
//FIN DE FUNCION QUE SE EJECUTA AL PRESIONAR EL BOTON OK DE LA ALERTA DE FINALIZACION DEL TIEMPO ESTIMADO DEL ITEM



//-------------- BOTON IR A (BUSQUEDA DE UN ITEM CUALQUIERE)------------------------
$(document).ready(function() { 
   $("#btnBuscarItem").on('click', function() {
          $('#img_cargando_buscar').show();
          var itemAbuscar=$("#text_cajabusqueda").val();
          var ultimoItemSuperado=$("#text_ultimoItemSuperado").val();
          
          var newItemAbuscar=parseInt(itemAbuscar);
          var newUltimoItemSuperado=parseInt(ultimoItemSuperado);
          
          if (newItemAbuscar>0) 
          {
            if (newItemAbuscar<=newUltimoItemSuperado) 
            {
  // encriptamos el numero de diapositiva en base64(igual que en php) para enviarlo por la url
              var mascarItemaBusacar=newItemAbuscar*123456;
             var  itemAbuscarEncriptado=btoa(mascarItemaBusacar);
              location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d='+itemAbuscarEncriptado;

            }
            else
            {
             setTimeout(function(){  }, 2000); swal('ATENCION','Solo puede ir a diapositivas ya superadas','warning');  
             $('#img_cargando_buscar').hide();
            }
            
          }
          else
          {
           setTimeout(function(){  }, 2000); swal('ATENCION','Deve colocar un numero de Diapositiva valido','warning');  
           $('#img_cargando_buscar').hide();
          }
    
        // location.href='capacitaciones.php';
      }); 
  });

//------------ FIN BOTON IR A (BUSQUEDA DE UN ITEM CUALQUIERE)---------------------



  //---------------------- CRONOMETRO DE CUENTA REGRESIVA/
  var estadoItemActual_Js=$('#text_estadoItemActual').val();
// IF QUE PREGUNTA SI EL ITEM ACTUAL YA ESTA SUPERADO O NO
 if (estadoItemActual_Js=='nosuperado') 
  {
    var tipodeItem=$('#text_tipoItem').val();
    // IF QUE PREGUNTA SI EL ITEM ACTUAL ES DE TIPO PDF O EXAMEN PARA EMPEZAR LA CUENTA REGRESIVA
    if (tipodeItem=="PDF" || tipodeItem=="EXAMEN") 
    {
      empezarCronometro()
    }

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
              // COMO SE ACABO EL TIEMPO AUTOMATICAMENTE SE PENALIZA LLEVANDOLO AL ULTIMO EXAMEN SUPERADO, SI NO HAY ULTIMO EXAMEN SUPERADO LO LLEVARA A LA Diapositiva 1
                      var formDataOutTime = new FormData();
                       var idCapacitacion=<?php echo $idcapacitacionGET ?>;
                       var idproceso=$('#textid_procesoavance').val();
                       var numeroItemActual=$('#textitem_actual').val(); 
                      // var totalItemDelaCap=$('#textTotalItem').val();
                       /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
                       formDataOutTime.append('idCapacitacion',idCapacitacion);
                       formDataOutTime.append('idproceso',idproceso);
                       formDataOutTime.append('numeroItemActual',numeroItemActual);
                       
                        $.ajax({ url: 'controlador/control-RestarUnItemPorTimeOut.php', 
                                 type: 'post', 
                                 data: formDataOutTime, 
                                 contentType: false, 
                                 processData: false, 
                                 success: function(response) { 
                                  /*pregunta si la respuesta es diferente a cero(osea se actualizo con exito)*/
                                   if (response !=0) 
                                   {
                                     
                                      
                                    
                                       /*encriptamos el num_ultima_itemsuperado en base64, para enviarlo por la url()*/
                                      var mascara_ultimoitrmSuperado=response*123456;
                                      var num_ultimi_item_superadoEncriptado=btoa(mascara_ultimoitrmSuperado);
                                      /*para desencritar en js de base64 es la funcion atob(variableParadesencriptar)*/
                                      /*cargamos el codigo encriptado del numero de diapositiva a la que se tiene que ir el procurador*/
                                      $('#text_numItem_A_Ir').val(num_ultimi_item_superadoEncriptado);
                                      /*mostramos el alerta de final de tiempo*/
                                      var modalformacep = document.getElementById("myModalformacep"); 
                                       modalformacep.style.display = "block";

                                     
                                          
                                   } 
                                      if (response==0) 
                                       {
                                       // QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON 
                                        
                                       //  setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                                        //alert('Formato de imagen incorrecto.'); 
                                        }
                                        
                                  } 
                              }); 
                        return false
                        

              // SE ACABA EL TIEMPO Y MUESTRA EL MODAL DE EXPIRACION DE TIEMPO DE ITEM

              
             // location.href='capacitaciones.php';


            }/*FIN DEL IF QUE PREGUNTA SI SE ACABO EL TIEMPO(SI ES MENOR QUE CERO)*/ 
          }, 1000); 
     } 
       function  empezarCronometro() 
      { 
        
      var totalsegundosdelItem=<?php echo $SumadosLosSegundosDelItem ?>; 

        var cuentaRegresiva = totalsegundosdelItem, display = document.querySelector('#time'); 
        startTimer(cuentaRegresiva, display); 
      }

//----------------------FIN CRONOMETRO DE CUENTA REGRESIVA------------------/






//---AL HACER CLICK EN SIGUIENTE (LLAMA AL CONTROLADOR PARA ACTUALIZAR EL AVANCE,y vencer esta diapositiva)----------/
 $(document).ready(function() { 
   $("#btnsiguiente").on('click', function() {
     $('#img_cargando').show();
   if (estadoItemActual_Js=='nosuperado') 
   {
         /*POR VERDADERO cargamos los inputs a nuevas variables PARA LLAMAR AL CONTROLADOR*/ 
     /*verificamos si el item a superar es tipo examen, por verdadero tendra que,verificar que haga bien el examen*/
         var tipodeItem=$('#text_tipoItem').val();
         var totalPreguntasExamen=<?php echo $contadordePreguntas-1; ?>/*le restamos uno al total de preguntas porque el valor empieza en uno y por defecto su ultimo valor sera uno mas al total de preguntas*/

         if (tipodeItem=='EXAMEN') 
         {     
              var contadorPreguntasJS=1;
              
              var valoRadiElegido=0;
              
              var sumaTotalvalorResp=0;
               while(contadorPreguntasJS<=totalPreguntasExamen)
               {
                  valoRadiElegido=$('input:radio[name='+contadorPreguntasJS+']:checked').val();
                  
                 sumaTotalvalorResp=parseInt(valoRadiElegido)+parseInt(sumaTotalvalorResp);
              /*incrementa en uno*/
               contadorPreguntasJS++;
               }
 /*se verifica que el valor de la suma de todas las respuesta checheadas sea igual a la cantidad de preguntas*/
                   /*por verdadero, (osea respondio bien todas las preguntas,registramos el avance)*/
                   if (sumaTotalvalorResp==totalPreguntasExamen) 
                   {

                         var formDataUp = new FormData();   
                         var idproceso=$('#textid_procesoavance').val();
                         var num_itemactual_avanzado=$('#textitem_actual').val();
                         var totalItemDelaCap=$('#textTotalItem').val();
                         
                         if ( (idproceso=='') || (num_itemactual_avanzado=='')  ) 
                         {
                           setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina e intente nuevamente','warning'); 
                           $('#img_cargando').hide();
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
                                 /*  PREGUNTA SI EL ITEM ACTUAL ES IGUAL A LTOTAL DEL ITEM DE LA CAPACITACION(OSEA SE FINALIZARA LA CAPACITACION)*/
                                            if (num_itemactual_avanzado==totalItemDelaCap) 
                                            {
                                              setTimeout(function(){ location.href='mis_capacitaciones.php'; }, 1500); swal('Capacitacion vencida','','success');
                                              
                                            }
                                      /*POR FALSO SIGUE LA CAPACITACION NORMALMENTE Y LE DIRECCIONA AL SIGUIENTE ITEM*/
                                            else
                                            {
                                               //location.reload(); 
                                               location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d=<?php echo $encriptadoItemSiguiente ?>';
                                            }
                                       } 
                                          if (response==0) 
                                           {
                                           // QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON 
                                            
                                           //  setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                                            //alert('Formato de imagen incorrecto.'); 
                                            }
                                            if(response==2)
                                            {
                                              setTimeout(function(){  }, 2000); swal('ATENCION','Usted no puede superar esta diapositiva, porque aun no le toca','error');
                                              $('#img_cargando').hide();
                                            }
                                            
                                      } 
                                  }); 

                            }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
                              return false;
                      
                   }/*fin del if que verifica que respondio bien todo el examen, se registra el avance*/

                   /*por falso, se mostrara alerta de examen mal echo*/
                   else
                   {
                       var formDataExamenMal = new FormData();
                       var idCapacitacion=<?php echo $idcapacitacionGET ?>;
                       var idproceso=$('#textid_procesoavance').val();
                       var numeroItemActual=$('#textitem_actual').val(); 
                      // var totalItemDelaCap=$('#textTotalItem').val();
                       /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
                       formDataExamenMal.append('idCapacitacion',idCapacitacion);
                       formDataExamenMal.append('idproceso',idproceso);
                       formDataExamenMal.append('numeroItemActual',numeroItemActual);
                       
                        $.ajax({ url: 'controlador/control-RestarUnItemPorTimeOut.php', 
                                 type: 'post', 
                                 data: formDataExamenMal, 
                                 contentType: false, 
                                 processData: false, 
                                 success: function(response) { 
                                  /*pregunta si la respuesta es diferente a cero(osea se actualizo con exito)*/
                                   if (response !=0) 
                                   {       
                                       /*encriptamos el num_ultima_itemsuperado en base64, para enviarlo por la url()*/
                                      var mascara_ultimoitrmSuperado=response*123456;
                                      var num_ultimi_item_superadoEncriptado=btoa(mascara_ultimoitrmSuperado);
                                      /*para desencritar en js de base64 es la funcion atob(variableParadesencriptar)*/
                                      /*cargamos el codigo encriptado del numero de diapositiva a la que se tiene que ir el procurador*/
                                      
                                     setTimeout(function(){  location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d='+num_ultimi_item_superadoEncriptado; }, 2000); swal('PENALIZADO','No respondio correctamente las preguntas','error'); 
                                       $('#img_cargando').hide();
                                                                                                                   
                                   } 
                                      if (response==0) 
                                       {
                                       // QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON 
                                       //  setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                                        //alert('Formato de imagen incorrecto.'); 
                                        }
                                        
                                  } 
                              }); 
                        return false
                       
                   }/*FIN DEL ELSE QUE MUESTRA EL ALERTA DE EXAMEN MAS RESPONDIDO*/
             

         }/*fin de verificamos si el item a superar es tipo examen*/
         else
         {

         
             var formDataUp = new FormData();   
             var idproceso=$('#textid_procesoavance').val();
             var num_itemactual_avanzado=$('#textitem_actual').val();
             var totalItemDelaCap=$('#textTotalItem').val();
             
             if ( (idproceso=='') || (num_itemactual_avanzado=='')  ) 
             {
               setTimeout(function(){  }, 2000); swal('ATENCION','Algunos datos se perdieron, recargue la pagina e intente nuevamente','warning'); 
                $('#img_cargando').hide();
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
                     /*  PREGUNTA SI EL ITEM ACTUAL ES IGUAL A LTOTAL DEL ITEM DE LA CAPACITACION(OSEA SE FINALIZARA LA CAPACITACION)*/
                                if (num_itemactual_avanzado==totalItemDelaCap) 
                                {
                                  setTimeout(function(){ location.href='mis_capacitaciones.php'; }, 1500); swal('Capacitacion vencida','','success');
                                  
                                }
                          /*POR FALSO SIGUE LA CAPACITACION NORMALMENTE Y LE DIRECCIONA AL SIGUIENTE ITEM*/
                                else
                                {
                                   //location.reload(); 
                                   location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d=<?php echo $encriptadoItemSiguiente ?>';
                                }
                           } 
                           if (response==0) 
                            {
                               // QUITAMOS EL CARGANDO Y QUITAMOS EL DISABLED DEL BOTON 
                                
                               //  setTimeout(function(){  }, 2000); swal('ERROR','Algo salio mal intente nuevamente por favor','error');
                                //alert('Formato de imagen incorrecto.'); 
                            }
                            if(response==2)
                            {
                              setTimeout(function(){  }, 2000); swal('ATENCION','Usted no puede superar esta diapositiva porque, aun no le toca','error');
                              $('#img_cargando').hide();
                            }
                                
                          }/*fin del response*/ 
                      }); 

                }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
                  return false;

          }/*fin del else que no es examen*/
     }/*FIN DEL IF QUE PREGUNTA SI ESTADO DEL ITEM ACTUAL ES nosuperado*/

     /*POR FALSO, OSEA  EL ITEM ACTUAL YA ESTA SUPERADO, SOLO AVANZA A LA SIGUIENTE PAGINA(ITEM)*/
     else
     {
      location.href='diapositivas_capacitacion.php?cod_cap=<?php echo $idCapCodificadoGet ?>&num_d=<?php echo $encriptadoItemSiguiente ?>';
     }

    }); /*FIN DE LA FUNCION CLICK DEL BOTON SIGUIENTE*/
  });

//-------------FIN--AL HACER CLICK EN SIGUIENTE (LLAMA AL CONTROLADOR PARA ACTUALIZAR EL AVANCE)------------------/

</script>

