<?php
include_once('../modelo/clsItemCapacitacion.php');

$objitem=new Item_Capacitacion();



$tiempo_delItemExamen=$_POST['select_minExamenEdit'].$_POST['select_segExamenEdit'];

$objitem->setid_item($_POST['textid_itemEXAMEN_edit']);
$objitem->set_nombreItem($_POST['textituloexamen_edit']);
$objitem->set_nombreItemInterno($_POST['textituloexamen_edit']);
$objitem->set_tiempoItem($tiempo_delItemExamen);



if ($objitem->editarUnItemExamen()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>