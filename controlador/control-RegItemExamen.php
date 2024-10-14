<?php
include_once('../modelo/clsItemCapacitacion.php');

$objitem=new Item_Capacitacion();

/*OBTENEMOS EL TOTAL DE ITEMS DE UNA CAPACITACION PARA SIGNAR EL NUMERO SIGUIENTE8*/
$resultitem=$objitem->contarItemDeUnaCapacitacion($_POST['textid_capacitacion']);
$filtotal=mysqli_fetch_object($resultitem);
$numerodeItem=$filtotal->totalItem+1;

$tiempo_delItemExamen=$_POST['select_minExamen'].$_POST['select_segExamen'];

$objitem->set_nombreItem($_POST['textituloexamen']);
$objitem->set_tiempoItem($tiempo_delItemExamen);
$objitem->set_tipoItem('EXAMEN');
$objitem->set_numeroItem($numerodeItem);
$objitem->set_nombreItemInterno($_POST['textituloexamen']);
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