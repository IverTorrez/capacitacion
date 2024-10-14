<?php
include_once('../modelo/clsItemCapacitacion.php');
include_once('../modelo/clsPregunta.php');
include_once('../modelo/clsRespuesta.php');

$objitem=new Item_Capacitacion();

/*OBTENEMOS LOS DATOS DESDE LA VISTA DE ELIMINAR*/
$tipoItemAELim=$_POST['text_tipoItem'];
$id_Item=$_POST['textid_item'];
$id_Capacitacion=$_POST['textid_capacitacion'];
$numeroItem=$_POST['text_numeroItem'];


// PREGUNTA SI EL ITEM A ELIMINAR ES UN PDF O LINK DE youtube POR VERDADERO ELIMINA NORMALMENTE, POR FALSO HAY OTROS REGISTROS DE OTRAS TABLAS QUE ELIMINAR 
if ($tipoItemAELim=='PDF' || $tipoItemAELim=='LINK') 
{
	   $objitem->setid_item($id_Item);
	// PREGUNTAMOS SI SE ELIMINO CORRECTAMENTE, PARA REORDENAR LOS NUMEROS DEL ITEM
	if ($objitem->eliminarDeLaBD_Un_ItemDeCapacitacion()) 
	{
		// EMPEZAMOS A LISTAR TODOS LOS ITEM DESPUES DEL ITEM ELIMINADO, PARA REORDENAR
		$resulTItemAscedente=$objitem->listarItemDespuesDeUnTem_DeUnaCapacitacion_ASC($id_Capacitacion,$numeroItem);
		$nuevoNumeroItem=$numeroItem;
		while ($filItems=mysqli_fetch_object($resulTItemAscedente)) 
		{
			/*ACTUALIZAMOS LOS NUMEROS DE LOS ITEM SIGUIENTES*/
		   $objitem->setid_item($filItems->id_item);
		   $objitem->set_numeroItem($nuevoNumeroItem);
		   $objitem->modificarELnumeroDeUnItem();
		   $nuevoNumeroItem++;	
		}

		echo 1;
	}/*FIN DEL IF QUE PREGUNTA SI SE ELIMINO CORRECTAMENTE*/

	/*POR FALSO,ERROR NO SE ELIMINO EL ITEM*/
	else
	{
		echo 0;
	}
	
}/*FIN DEL IF QUE PREGUNTA SI EL ITEM A ELIMINAR ES UN PDF O LINK*/

// POR FALSO ELIMINARA UN EXAMEN, DEBE ELIMINARA DE OTRAS TABLAS OTROS DATOS
else
{
	$objpregunta=new Preguntas();
	$resultPreg=$objpregunta->listarTodasLaPreguntasDeItemExamen($id_Item);
	/*while recore todas las preguntas del item tipo examen*/
    while ($filpreg=mysqli_fetch_object($resultPreg)) 
    {
    	$idpregunta=$filpreg->id_pregunta;

       /*eliminamos todas las resuestas de la pregunta*/
    	$objResp=new Respuesta();
        $objResp->eliminarRespuestasDePregunta($idpregunta);
		
	}	/*fin while recore todas las preguntas del item tipo examen*/

    /*preguntamos si elimino todas las pregunta del item examen, se pasara a eliminar el item*/
	if ($objpregunta->eliminarPreguntasDeUnItemExamen($id_Item)) 
	{
                   $objitem=new Item_Capacitacion();
		           $objitem->setid_item($id_Item);
					// PREGUNTAMOS SI SE ELIMINO CORRECTAMENTE, PARA REORDENAR LOS NUMEROS DEL ITEM
					if ($objitem->eliminarDeLaBD_Un_ItemDeCapacitacion()) 
					{
						// EMPEZAMOS A LISTAR TODOS LOS ITEM DESPUES DEL ITEM ELIMINADO, PARA REORDENAR
						$resulTItemAscedente=$objitem->listarItemDespuesDeUnTem_DeUnaCapacitacion_ASC($id_Capacitacion,$numeroItem);
						$nuevoNumeroItem=$numeroItem;
						while ($filItems=mysqli_fetch_object($resulTItemAscedente)) 
						{
							/*ACTUALIZAMOS LOS NUMEROS DE LOS ITEM SIGUIENTES*/
						   $objitem->setid_item($filItems->id_item);
						   $objitem->set_numeroItem($nuevoNumeroItem);
						   $objitem->modificarELnumeroDeUnItem();
						   $nuevoNumeroItem++;	
						}

						echo 1;
					}/*FIN DEL IF QUE PREGUNTA SI SE ELIMINO CORRECTAMENTE*/

					/*POR FALSO,ERROR NO SE ELIMINO EL ITEM*/
					else
					{
						echo 0;
					}


		
	}/*fin del if que empieza a eliminar el item*/
	else
	{
		echo 0;
	}

	


}/*FIN DEL ELSE QUE ELIMINA UN EXAMEN*/


?>