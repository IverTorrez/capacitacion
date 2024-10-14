<?php
include_once('../modelo/clsCapacitacion.php');
include_once('../modelo/clsItemCapacitacion.php');
include_once('../modelo/clsPregunta.php');
include_once('../modelo/clsRespuesta.php');

$idCapacitacion=$_POST['textid_capacitacion'];
$objCap=new Capacitacion();

$resultCantidadProce=$objCap->mostrarCantidadProcesosDeUnaCapacitacion($idCapacitacion);
$filcantidadProce=mysqli_fetch_object($resultCantidadProce);
$cantidadDeProcesosActivos=$filcantidadProce->totalProcesos;

/*contamos todas los item de la capacitacion*/
$resultCantidadDeItemDeCap=$objCap->contadorDeItemsDeUnaCapacitacion($idCapacitacion);
$filtotalitem=mysqli_fetch_object($resultCantidadDeItemDeCap);
$totalItemdeLaCap=$filtotalitem->totalitem;

$totalItemEliminados=0;
/*por verdadero no se puede eliminar*/
if ($cantidadDeProcesosActivos>0) 
{
	echo 2;
}
/*por falso , se puede eliminar, se eliminara*/
else
{
  $resultItemCap=$objCap->listarTodosLosItemDeUnaCapacitacion($idCapacitacion);
  while ($filItemCap=mysqli_fetch_object($resultItemCap)) 
  {
	  	/*PREGUNTAMOS SI ES DE TIPO EXAMEN PARA ELIMINAR SUS PREGUNTAS Y RESPUESTAS*/
	  	if ($filItemCap->tipo_item=='EXAMEN') 
	  	{
	  		$objPregunta=new Preguntas();
	  		$resultaPreguntas=$objPregunta->listarTodasLaPreguntasDeItemExamen($filItemCap->id_item);
	  		while ($filPreguntas=mysqli_fetch_object($resultaPreguntas)) 
	  		{
	  			$objresp=new Respuesta();
	  			$objresp->eliminarRespuestasDePregunta($filPreguntas->id_pregunta);
	  			
	  		}/*fin del while que rrecore todas las preguntas de un item examen*/

	  		$objPregunta->eliminarPreguntasDeUnItemExamen($filItemCap->id_item);
	  		
	  	}/*FIN DEL IF QUE PREGUNTA SI EL ITEM ES DE TIPO EXAMEN*/
	  	
		     $objItem=new Item_Capacitacion();
		     $objItem->setid_item($filItemCap->id_item);
	     if ($objItem->eliminarDeLaBD_Un_ItemDeCapacitacion()) 
	       {
	       	$totalItemEliminados++;
	       }  
  	


  }/*FIN DEL WHILE QUE RRECORRE TODOS LOS ITEM DE LA CAPACITACION*/

     /*preguntamos si todos los item fueron eliminados, por verdadero, eliminamos la capacitacion*/
	  if ($totalItemEliminados==$totalItemdeLaCap) 
	  {
	  	 $objCap->setid_capacitacion($idCapacitacion);
	  	 if ($objCap->eliminarUnaCapacitacion()) 
	  	 {
	  	 	echo 1;
	  	 }
	  	 
	  }
	  /*por falso mostramos alerta*/
	  else
	  {
	  	echo 0;
	  }
  
}/*fin del else que elimina la capacitacion*/


?>