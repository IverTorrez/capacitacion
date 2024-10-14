<?php 
//error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["usuarioC"]))
{
  header("location:index.php");
}

require_once("cabezote.php");
require_once("menu.php");
include_once("modelo/clsCapacitacion.php");
?>

<div class="content-wrapper">
	<section class="content-header">
      <h1>
      Tablero
        <small>Puede ver el avance de los procuradores en las capacitaciones, presione el boton inscritos para mas detalles.</small>
      </h1>
     <!--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>

        <li class="active">Tablero 2</li>

      </ol> -->
    </section>
    <section class="content">

    <div class="row">
   
   <?php
    $objCapacit=new Capacitacion();
    $resultcap=$objCapacit->listarCapacitacionesActivas();
    while ($filCap=mysqli_fetch_object($resultcap)) 
    {
    	$idCapacitacion=$filCap->id_capacitacion;


    	$resulTOtalItem=$objCapacit->contadorDeItemsDeUnaCapacitacion($idCapacitacion);
    	$filTotalItem=mysqli_fetch_object($resulTOtalItem);
    	$totalItemDeCap=$filTotalItem->totalitem;


    	$resultCantProceso=$objCapacit->contarProcesosDeAvanceDeUnaCapacitacion($idCapacitacion,$totalItemDeCap);
    	$filTotalProcesosActual=mysqli_fetch_object($resultCantProceso);
    	$totalProcesosEnCurso=$filTotalProcesosActual->totalProcesosEnCurso;
    ?>	
    <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-mortar-board"></i></span>

            <div class="info-box-content">
              <div style="min-height: 70px;">
              <label ><?php echo $filCap->nombre_capacitacion; ?></label>
              
             
              </div>
              <p><i class="fa fa-users"></i> En curso:<b> <?php echo $totalProcesosEnCurso; ?></b> </p>
              <div>
            
            	<button class="btn btn-primary btn-xs" onclick="location.href='progresos_capacitacion.php?cod_cap=<?php echo $idCapacitacion ?>'">Inscritos</button>
            

            </div>
            </div>
            
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

    <?php	
    }
   ?>

        

      </div>
      <!-- /.row -->

<!--========================LISTADO DE CAPACITACIONES CANCELADAS============ -->
      <h3>
      Listado de capacitaciones desactivadas
      </h3>
<?php
    $objCapacit=new Capacitacion();
    $resultcap=$objCapacit->listarCapacitacionesCanceladas();
    while ($filCap=mysqli_fetch_object($resultcap)) 
    {
      $idCapacitacion=$filCap->id_capacitacion;


      $resulTOtalItem=$objCapacit->contadorDeItemsDeUnaCapacitacion($idCapacitacion);
      $filTotalItem=mysqli_fetch_object($resulTOtalItem);
      $totalItemDeCap=$filTotalItem->totalitem;


      $resultCantProceso=$objCapacit->contarProcesosDeAvanceDeUnaCapacitacion($idCapacitacion,$totalItemDeCap);
      $filTotalProcesosActual=mysqli_fetch_object($resultCantProceso);
      $totalProcesosEnCurso=$filTotalProcesosActual->totalProcesosEnCurso;
    ?>  
    <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-mortar-board"></i></span>

            <div class="info-box-content">
              <div style="min-height: 70px;">
              <label ><?php echo $filCap->nombre_capacitacion; ?></label>
              
             
              </div>
              <p><i class="fa fa-users"></i> En curso:<b> <?php echo $totalProcesosEnCurso; ?></b> </p>
              <div>
            
              <button class="btn btn-primary btn-xs" onclick="location.href='progresos_capacitacion.php?cod_cap=<?php echo $idCapacitacion ?>'">Inscritos</button>
            

            </div>
            </div>
            
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

    <?php 
    }
   ?>    




    </section>
</div>

<?php require_once("footer.php");?>