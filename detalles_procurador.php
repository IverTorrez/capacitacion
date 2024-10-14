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
include_once("modelo/clsProcurador.php");
$idprocuradorGET=$_GET['cod'];
$objCap1=new Procurador();
$resulnombre=$objCap1->mostrarUnProcurador($idprocuradorGET);
$filnombr=mysqli_fetch_object($resulnombre);
$nombreProcurador=$filnombr->nombre.' '.$filnombr->apellido;
?>

<div class="content-wrapper">
	<section class="content-header">
      <h4 >Procurador:
      <?php echo $nombreProcurador; ?>
        
      </h4>
     <!--  <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>
      </ol> -->
    </section>
    <section class="content">

    
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Avance en las capacitaciones del procurador</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered" style="background:#e4e5e6;">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Capacitación</th>
                  <th >Progreso</th>
                  <th style="width: 40px">%</th>
                </tr>
                </thead>

                <tbody>

                  <?php
                  $numeroCont=0;
                 $objCap=new Capacitacion();

                 

                 $resultcap=$objCap->listarCapacitacionesDeUnProcurador($idprocuradorGET);
                 while ($filprocCap=mysqli_fetch_object($resultcap)) 
                 {
                    $idcapacitacion=$filprocCap->idcapacitacion;

                    $resulTotalItem=$objCap->contadorDeItemsDeUnaCapacitacion($idcapacitacion);
                     $filtotalitem=mysqli_fetch_object($resulTotalItem);
                     $totaldeItemDeCap=$filtotalitem->totalitem;

                  $numeroCont++;
                  $numeroItemAvanzado=$filprocCap->itemavanzado;

                  $porcentaje_avanzado=($numeroItemAvanzado*100)/$totaldeItemDeCap;

                 $porcentaje_avanzadoFormato=number_format($porcentaje_avanzado, 0, '.', ' ');
                  ?>
                  <tr>
                  <td ><?php echo $numeroCont; ?></td>
                  <td><?php echo $filprocCap->nombrCapacitacion; ?></td>
                  <td>
                    <div class="progress progress-xs progress-striped active" style="background: white;">
                      <div class="progress-bar progress-bar-primary" style="width: <?php echo $porcentaje_avanzado; ?>%;"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-blue" ><?php echo $porcentaje_avanzadoFormato; ?>%</span><b><?php echo $numeroItemAvanzado.'/'.$totaldeItemDeCap;  ?></b></td>
                </tr>


                  <?php
                 }
                
                  ?>

                
              </tbody>
              </table>
            </div>
            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->


    </section>
    <!-- /.content -->

</div>
 <!-- /.content-wrapper -->

<?php require_once("footer.php");?>