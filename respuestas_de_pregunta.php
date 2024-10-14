<?php 
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioC"]))
{
  header("location:index.php");
}
include_once("cabezote.php"); 
include_once("menu.php"); 
include_once("modelo/clsPregunta.php");
$idpregunta=$_GET['cod'];

$objpreg=new Preguntas();
$resulpregunta=$objpreg->mostrarUnaPregunta($idpregunta);
$filpreg=mysqli_fetch_object($resulpregunta);

$preguta=$filpreg->pregunta;
$cantidadRespuestas=$filpreg->cantidad_respuestas;
$idItem=$filpreg->id_item;

?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
<!-- jQuery 3 -->
<script src="recursos/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Plugin de alert sweet -->
<script src="recursos/alertsweet/sweet-alert.min.js"></script>  
<link rel="stylesheet" href="recursos/alertsweet/sweet-alert.css">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Pregunta:
        <small><?php echo $preguta; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
       
        <div class="box-body">

          <?php
        $contadorDecantidadRes=1;
        $posisionIncisos=0;
        $arrayIncisos=array('A','B','C','D','E','F');
        while ($contadorDecantidadRes<=$cantidadRespuestas) 
        {
        ?>
        <div class="col-md-3 col-sm-6 col-xs-12" style="width: 100%;">
          
              <!-- Apply any bg-* class to to the icon to color it -->

             
              
                <span class="info-box-text"><b> Opcion <?php echo $arrayIncisos[$posisionIncisos]; ?>)</b></span>
                 <input type="text" name="<?php echo $contadorDecantidadRes; ?>" id="<?php echo $contadorDecantidadRes; ?>" class="form-control" placeholder="Escriba una opcion de respuesta">
               <br>
              <!-- /.info-box-content -->
          
          </div>
         
        <?php
        $contadorDecantidadRes++;
        $posisionIncisos++;
        }
        ?>

         <div class="col-md-3 col-sm-6 col-xs-12" style="width: 100%;">
            <div class="info-box">
              <!-- Apply any bg-* class to to the icon to color it -->              
                <span class="info-box-number"> Elija el numero de la opcion correcta</span>
                  <select class="form-control" name="select_resp_correcta" id="select_resp_correcta">
                    <?php
                    $posisionIncisos2=0;
                    $contadoselec=1;
                    while ($contadoselec<=$cantidadRespuestas) 
                    {
                      
                    echo "<option value='$contadoselec'>$arrayIncisos[$posisionIncisos2]</option>";
                    $contadoselec++;
                    $posisionIncisos2++;
                    }
                    ?>
                   
                  </select>
             
              <!-- /.info-box-content -->

            </div>
            <button type="button" class="btn btn-primary" id="btnregRespuestas" name="btnregRespuestas">Registrar<img style="width: 20px;display: none;" id="img_cargando_respuesta" src="recursos/gif/cargando.gif"></button>
          </div>


          
        </div>
        <!-- /.box-body -->
       
         
        
        
      
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->




<!--CODIGO JAVAESCRIPT QUE LLAMA AL CONTROLADOR CREAR UN PROCURADOR-->
<script> 

   $(document).ready(function() { 
   $("#btnregRespuestas").on('click', function() {
      $('#img_cargando_respuesta').show();
   /*cargamos los inputs a nuevas variables*/
      var codnewpagina=''; 
      var idpregunta=<?php echo $idpregunta ?>;
      var totalRespuestas=<?php echo $cantidadRespuestas ?>;
      var contadorInputvacios=0;
      var punteroDecontarRespues=1;
      var valorInputResp='';
      var NumRespCorrecta=$('#select_resp_correcta').val();
      while (punteroDecontarRespues<=totalRespuestas)
      {
        valorInputResp=$('#'+punteroDecontarRespues).val();
        if (valorInputResp=='') 
        {
          contadorInputvacios++;
        }

        punteroDecontarRespues++;
      }/*FIN FEL WHILE QUE RECORRE TODOS LOS INPUTS DE RESPUESTAS, PARA VER SI HAY CAMPOS VACIOS*/

     /*CONTADOR PARA EL SEGUNDO WHILE, el que registra la respuesta*/
      var otroContadorRespuestas=1;

/*PREGUNTAMOS SI ENCONTRO CAMPOS VACIOS, POR VERDADERO, MOSTRAMOS ALERTA, POR FALSO, SEGUIMOS CON EL REGISTRO*/
      if (contadorInputvacios>=1) 
      {
       setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
       $('#img_cargando_respuesta').hide();
      }
/*POR FALSO TODOS LOS CAMPOS ESTAM COMPLETOS, REGISTRAMOS*/
      else
      {
        
        var numeroCOrrecto=0;
        var valorDerespCorrectaes='';
      //  var otroContadorRespuestas=1;
         while (otroContadorRespuestas<=totalRespuestas)
          {
              
              valorInputResp=$('#'+otroContadorRespuestas).val();
             /*verificamos si la actual respuesta es la elegida como correcta*/
              if (NumRespCorrecta==otroContadorRespuestas) 
              {
                 numeroCOrrecto=1;
                 //valorDerespCorrectaes=valorInputResp;
              }
              else
              {
                 numeroCOrrecto=0; 
              }

                var formDataRespuesta = new FormData();
                 formDataRespuesta.append('textid_pregunta',idpregunta);
                 formDataRespuesta.append('text_respuesta',valorInputResp);
                 formDataRespuesta.append('valor',numeroCOrrecto);
                 
                  $.ajax({ url: 'controlador/control-RegRespuesta.php', 
                           type: 'post', 
                           data: formDataRespuesta, 
                           contentType: false, 
                           processData: false, 
                           success: function(response) { 
                            codnewpagina=response;
                            
                               // if (response==1) 
                               // {
                                
                               //   setTimeout(function(){  }, 2000); swal('','Redireccionando a las respuestas....',''); 
                                 
                               // }
                               // else
                               // {
                               //   setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');                   
                               // } 
                            }
                        });



            otroContadorRespuestas++;
          }/*FIN FEL WHILE QUE RECORRE TODOS LOS INPUTS DE RESPUESTAS, PARA registra al a bd*/
          //alert('dio vueltas. '+otroContadorRespuestas);
           setTimeout(function(){ location.href='item_capacitacion.php?cod='+codnewpagina; }, 2000); swal('EXELENTE','Espere.... Redireccionando a la diapositiva examen','success'); 
         // setTimeout(function(){ location.href='item_capacitacion.php?cod='+codnewpagina; }, 2000); swal('','Redireccionando a las respuestas....','');
            //setTimeout(function(){  }, 2000); swal('BIEN','campos completos','success');
          //  alert('la respuesta correcta es: '+numeroCOrrecto+' el valor es: '+valorDerespCorrectaes); 
      }/*fin del else al estar los campos completos*/


        return false;


    }); 
  });
   </script>



<?php include_once("footer.php"); ?>