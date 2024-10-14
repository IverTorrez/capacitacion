<?php
include_once('../modelo/clsCapacitacion.php');

$objusu=new Capacitacion();
$objusu->set_nombre_capacitacion($_POST['textnombre']);
$objusu->set_tipoCapacitacion($_POST['selecttipocap']);
$objusu->set_idCapacitador($_POST['textid_capacitador']);
$objusu->set_estado('inactiva');


if ($objusu->guardarCapacitacion()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>