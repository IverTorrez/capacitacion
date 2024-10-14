<?php
include_once('../modelo/clsItemCapacitacion.php');

$objitem=new Item_Capacitacion();

/*OBTENEMOS EL TOTAL DE ITEMS DE UNA CAPACITACION PARA SIGNAR EL NUMERO SIGUIENTE8*/
$resultitem=$objitem->contarItemDeUnaCapacitacion($_POST['textid_capacitacion']);
$filtotal=mysqli_fetch_object($resultitem);
$numerodeItem=$filtotal->totalItem+1;



$objitem->set_nombreItem($_POST['textituloLink']);
$objitem->set_tiempoItem(0);/*como es un video de youtube, no se le asigna un tiempo*/
$objitem->set_tipoItem('LINK');
$objitem->set_numeroItem($numerodeItem);
$objitem->set_nombreItemInterno($_POST['textLink']);
$objitem->set_idCapacitacion($_POST['textid_capacitacion']);

if ($objitem->guardarItemCapacitacion()) 
{
	echo 1;
}
else
{
	echo 0;
}

?>