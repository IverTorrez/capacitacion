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
$idcapacitacionGET=$_GET['cod_cap'];
$objCap1=new Capacitacion();
$resulnombre=$objCap1->MostrarUnaCapacitacion($idcapacitacionGET);
$filnombr=mysqli_fetch_object($resulnombre);
$nombreDeCapacitacion=$filnombr->nombre_capacitacion;
?>

<div class="content-wrapper">
	<section class="content-header">
      <h1 >
      <?php echo $nombreDeCapacitacion; ?>
        
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    
        <li class="active">Tablero</li>
      </ol> -->
    </section>
    <section class="content">

    
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Avance de capacitantes en curso</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered" style="background:#e4e5e6;">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Procurador</th>
                  <th >Progreso</th>
                  <th style="width: 40px">%</th>
                </tr>
                </thead>

                <tbody>

                  <?php
                  $numeroCont=0;
                 $objCap=new Capacitacion();

                 $resulTotalItem=$objCap->contadorDeItemsDeUnaCapacitacion($idcapacitacionGET);
                 $filtotalitem=mysqli_fetch_object($resulTotalItem);
                 $totaldeItemDeCap=$filtotalitem->totalitem;

                 $resultcap=$objCap->listarLosProcuradoresEnCursoDeUnaCapacitacion($idcapacitacionGET);
                 while ($filprocCap=mysqli_fetch_object($resultcap)) 
                 {


                  $numeroCont++;
                  $numeroItemAvanzado=$filprocCap->itemavanzado;

                  $porcentaje_avanzado=($numeroItemAvanzado*100)/$totaldeItemDeCap;

                 $porcentaje_avanzadoFormato=number_format($porcentaje_avanzado, 0, '.', ' ');
                  ?>
                  <tr>
                  <td ><?php echo $numeroCont; ?></td>
                  <td><?php echo $filprocCap->NombreProc; ?></td>
                  <td>
                    <div class="progress progress-xs progress-striped active" style="background: white;">
                      <div class="progress-bar progress-bar-primary" style="width: <?php echo $porcentaje_avanzado; ?>%;"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-blue" ><?php echo $porcentaje_avanzadoFormato; ?>%</span><b><?php echo $numeroItemAvanzado.'/'.$totaldeItemDeCap; ?></b></td>
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