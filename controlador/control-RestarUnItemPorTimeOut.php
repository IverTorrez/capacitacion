<?php
include_once('../modelo/clsProcesoCapacitacion.php');
include_once('../modelo/clsCapacitacion.php');

$idCapacitacion=$_POST['idCapacitacion'];

$objCapacitacion=new Capacitacion();
$resulNumItem=$objCapacitacion->mostrarNumeroDelUltimoExamenDeCap($idCapacitacion,$_POST['numeroItemActual']);
$filNumeroItem=mysqli_fetch_object($resulNumItem);

$NumeroNuevoDeavance=0;
$numeroItemParaActualizar=$filNumeroItem->numeroItemPorSuperar-1;
if ($numeroItemParaActualizar<0) 
{
  $NumeroNuevoDeavance=0; 	
}
else
{
  $NumeroNuevoDeavance=$numeroItemParaActualizar;
}

$objusu=new Proceso_Capacitacion();
$objusu->setid_proceso($_POST['idproceso']);
$objusu->set_numeroItemAvanzado($NumeroNuevoDeavance);

if ($objusu->actualizarProcesoCapacitacion()) 
{
	if ($NumeroNuevoDeavance==0) 
	{
		echo 1;
	}
	else
	{
		echo $NumeroNuevoDeavance+1;
	}
	
}
else
{
	echo 0;
}

?>