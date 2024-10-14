<?php
include_once('../modelo/clsProcesoCapacitacion.php');


$NumItemPorSuperarAhoraMismo=$_POST['num_itemactual_avanzado'];
$objusu=new Proceso_Capacitacion();
$objusu->setid_proceso($_POST['idproceso']);
$objusu->set_numeroItemAvanzado($NumItemPorSuperarAhoraMismo);

$resulstProceso=$objusu->mostrarUnProcesoDeAvance($_POST['idproceso']);
$filproceso=mysqli_fetch_object($resulstProceso);
$numeroItemSuperadoActual=$filproceso->nomero_item_avanzado;

if ( ($numeroItemSuperadoActual)==($NumItemPorSuperarAhoraMismo-1)) 
	{
		if ($objusu->actualizarProcesoCapacitacion()) 
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
	}
	else
	{
		echo 2;
	}



?>