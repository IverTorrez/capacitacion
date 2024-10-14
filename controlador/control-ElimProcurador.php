<?php
session_start();
include_once('../modelo/clsProcurador.php');
include_once('../modelo/clsCapacitador.php');

$objusu=new Procurador();
$objusu->setid_procurador($_POST['textid_procurador']);
$objusu->set_estado('inactivo');
if ($objusu->elimProcurador()) 
{
	echo 1;
}
else
{
	echo 0;
}






?>