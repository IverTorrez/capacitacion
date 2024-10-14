<?php
include_once('../modelo/clsProcesoCapacitacion.php');

$objusu=new Proceso_Capacitacion();
$objusu->set_numeroItemAvanzado(0);
$objusu->set_idProcurador($_POST['textid_procurador']);
$objusu->set_idCapacitacion($_POST['textid_capacitacion']);


if ($objusu->guardarProcesoCapacitacion()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>