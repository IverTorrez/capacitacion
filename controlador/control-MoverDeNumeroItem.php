<?php
include_once('../modelo/clsItemCapacitacion.php');
include_once('../modelo/clsPregunta.php');
include_once('../modelo/clsRespuesta.php');

$objitem=new Item_Capacitacion();

/*OBTENEMOS LOS DATOS DESDE LA VISTA DE MOVER DE NUMERO ITEM*/
$id_Capacitacion=$_POST['textid_capacitacion'];
$idItemAMover=$_POST['textid_itemMover'];
$numeroActualItem=$_POST['text_numeroItemActual'];
$nuevoNumeroSeleccionado=$_POST['select_numeroItemNuevo'];

/*PREGUNTAMOS SI EL NUMERO A DONDE SE MOVERA EL ITEM ES MAYOR AL NUMERO ACTUAL QUE TIENE*/
if ($nuevoNumeroSeleccionado>$numeroActualItem) 
{   /*RECORREMOS LOS ITEM HACIA ADELANTE, HASTA EL $nuevoNumeroSeleccionado*/
	$parametro1=$numeroActualItem+1;
	$resultItemsEntre2ParametrosASC=$objitem->listarItemDeUnaCapacitacionEntreDosParametrosAscendente($id_Capacitacion,$parametro1,$nuevoNumeroSeleccionado);

		$numeroActualizado=$numeroActualItem;
		while ($filitementre2param=mysqli_fetch_object($resultItemsEntre2ParametrosASC)) 
		{
			/*ACTUALIZAMOS LOS NUMEROS DE LOS ITEM SIGUIENTES entre los dos parametros*/
			   $objitem->setid_item($filitementre2param->idItem);
			   $objitem->set_numeroItem($numeroActualizado);
			   $objitem->modificarELnumeroDeUnItem();
		  $numeroActualizado++;
		}/*FIN DEL WHILE QUE RECORRE LOS ITEM QUE ESTAN ENTRE EL PARAMETRO 1(ADELANTE DEL ITEM ACTUAL) Y EL NUEVO NUEMERO DE ITEM SELECCIONADO*/
		/*UNA VEZ TERMINA DE ACTUALIZAR LOS NUMEROS DE LOS OTROS ITEM, RECIEN CAMBIAMOS EL NUMERO DEL QUE SE QUIRE CAMBIAR*/
		$objitem->setid_item($idItemAMover);
		$objitem->set_numeroItem($nuevoNumeroSeleccionado);
	    if ($objitem->modificarELnumeroDeUnItem()) 
	     {
	     	echo 1;
	     } 
	     else
	     {
	     	echo 0;
	     }

}/*FIN DEL IF, PREGUNTAMOS SI EL NUMERO A DONDE SE MOVERA EL ITEM ES MAYOR AL NUMERO ACTUAL QUE TIENE*/

/*POR ESLE OSEA EL NUEVO NUMERO QUE SE LE ASIGNARA ES MENOR AL NUMERO ACTUAL DEL ITEM*/
else
{   
	/*RECORREMOS LOS ITEM DE MAYOR A MENOR OSEA DESCENTENTE*/
	$parametro2=$numeroActualItem-1;

	$numeroActualizado2=$numeroActualItem;

	$resulItemENtrParm1YParm2=$objitem->listarItemDeUnaCapacitacionEntreDosParametrosDescendente($id_Capacitacion,$nuevoNumeroSeleccionado,$parametro2);
	while ($filitemDescentente=mysqli_fetch_object($resulItemENtrParm1YParm2)) 
	{
		/*ACTUALIZAMOS LOS NUMEROS DE LOS ITEM QUE ESTAN POR DEBAJO DEL ITEM ACTUAL(NUMEROS MENORES) entre los dos parametros*/
			   $objitem->setid_item($filitemDescentente->idItem);
			   $objitem->set_numeroItem($numeroActualizado2);
			   $objitem->modificarELnumeroDeUnItem();
		  $numeroActualizado2--;
	}/*FIN DEL WHILE QUE RRECORRES LOS ITEM DE FORMA DESCENTENTE ENTRE DOS NUMEROS, PARA ACUTALIZAR EL NUMERO*/
	/*UNA VEZ TERMINA DE ACTUALIZAR LOS NUMEROS DE LOS OTROS ITEM, RECIEN CAMBIAMOS EL NUMERO DEL QUE SE QUIRE CAMBIAR*/
	$objitem->setid_item($idItemAMover);
	$objitem->set_numeroItem($nuevoNumeroSeleccionado);
	if ($objitem->modificarELnumeroDeUnItem()) 
	{
		echo 1;/*EXITO*/
	}
	else{
		echo 0;/*ERROR*/
	}
	


}/*FIN DEL ESLE OSEA EL NUEVO NUMERO QUE SE LE ASIGNARA ES MENOR AL NUMERO ACTUAL DEL ITEM*/





?>