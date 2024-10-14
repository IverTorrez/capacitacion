<?php
include_once('../modelo/clsItemCapacitacion.php');

$objitem=new Item_Capacitacion();


$objitem->setid_item($_POST['textid_itemLINK_edit']);
$objitem->set_nombreItem($_POST['textituloLink_edit']);
$objitem->set_nombreItemInterno($_POST['textLink_Edit']);


if ($objitem->editarUnItemLink()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>