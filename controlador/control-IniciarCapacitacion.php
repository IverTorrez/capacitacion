<?php
include_once('../modelo/clsCapacitacion.php');

$objusu=new Capacitacion();

$objusu->setid_capacitacion($_POST['textid_capacitacion']);
$objusu->set_estado('activa');


if ($objusu->iniciarUnaCapacitacion()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>