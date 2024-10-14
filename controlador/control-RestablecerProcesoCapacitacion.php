<?php
include_once('../modelo/clsProcesoCapacitacion.php');

$objusu=new Proceso_Capacitacion();

$objusu->setid_proceso($_POST['textid_proceso']);
$objusu->set_numeroItemAvanzado(0);

if ($objusu->restablecerProcesoCapacitacion()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>