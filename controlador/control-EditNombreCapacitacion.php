<?php
include_once('../modelo/clsCapacitacion.php');

$objusu=new Capacitacion();
$objusu->setid_capacitacion($_POST['textid_capacitacion']);
$objusu->set_nombre_capacitacion($_POST['text_editNameCap']);



if ($objusu->editarNombreCapacitacion()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>