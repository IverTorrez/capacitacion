<?php
include_once('../modelo/clsCapacitacion.php');
include_once('../modelo/clsItemCapacitacion.php');
include_once('../modelo/clsPregunta.php');
include_once('../modelo/clsRespuesta.php');

$idCapacitacionAClonar=$_POST['textid_capacitacion_aclonar'];



$objusu=new Capacitacion();
$objusu->set_nombre_capacitacion($_POST['text_nombreCapClonacion']);
$objusu->set_tipoCapacitacion($_POST['selecttipo_clonacion']);
$objusu->set_idCapacitador($_POST['textid_capacitador']);
$objusu->set_estado('inactiva');


if ($objusu->guardarCapacitacion()) 
{
	/*una vez insertada la capacitacion, le asignamos los items de la capacitacion a clonar */
	/*recuperamos el ultimo id_capacitacion*/
	$objUltimaCap=new Capacitacion();
	$resultultimaCap=$objUltimaCap->mostrarLaUltimaCapacitacionInsertada();
	$filultimaCap=mysqli_fetch_object($resultultimaCap);
	$idUltimaCapacitacion=$filultimaCap->ultimaCapacitacion;

	/*recorremos todos los item de la capacitacion a clonar, para copiarlas a la nueva capacitacion*/
    $objCap=new Capacitacion();
	$resultadosItemsAclonar=$objCap->listarTodosLosItemDeUnaCapacitacion($idCapacitacionAClonar);
	while ($filitemAclonar=mysqli_fetch_object($resultadosItemsAclonar)) 
	{   /*INSERTAMOS LOS ITEMS CLONADOS*/
		$objItemCap=new Item_Capacitacion();
		$objItemCap->set_nombreItem($filitemAclonar->nombre_item);
		$objItemCap->set_nombreItemInterno($filitemAclonar->nombre_item_interno);
		$objItemCap->set_numeroItem($filitemAclonar->numero_item);
		$objItemCap->set_tipoItem($filitemAclonar->tipo_item);
		$objItemCap->set_tiempoItem($filitemAclonar->tiempo_item);
		$objItemCap->set_idCapacitacion($idUltimaCapacitacion);
        /* IF QUE PREGUNTA SI EL ITEM SE INSERTO CORRECTAMENTE*/
		if ($objItemCap->guardarItemCapacitacion()) 
		{
			/*PREGUNTAMOS SI EL ITEM QUE SE CLONO ES DE TIPO EXAMEN*/
			if ($filitemAclonar->tipo_item=='EXAMEN') 
			{  /*RECUPERAMOS EL ULTIMO ID ITEM INSERTADO DE LA CAPACITACION*/
			    $resulUltimoItemInsertado=$objItemCap->mostrarElUltimoItemDeCapacitacion($idUltimaCapacitacion);
				$filUltimoItemInsertado=mysqli_fetch_object($resulUltimoItemInsertado);
				$idUltimoItem=$filUltimoItemInsertado->ultimoItemInsertado;
				/*enlistamos las preguntas del examen*/
				/* WHILE QUE RRECORRE TODAS LAS PREGUNTAS DEL ITEM EXAMEN(PARA CLONARLAS)*/
				$objPreguntas=new Preguntas();
				$resulpreguntas=$objPreguntas->listarTodasLaPreguntasDeItemExamen($filitemAclonar->id_item);
				while ($filPreguntasClonar=mysqli_fetch_object($resulpreguntas)) 
				{
					$objPregunaNew=new Preguntas();
					$objPregunaNew->set_pregunta($filPreguntasClonar->pregunta);
					$objPregunaNew->set_cantidad_respuestas($filPreguntasClonar->cantidad_respuestas);
					$objPregunaNew->set_idItem($idUltimoItem);
					/* if que pregunta si se guardo la pregunta,(ahora se registraran las respuestas)*/
					if ($objPregunaNew->guardarPregunta()) 
					{  /*obtenemos el id de la ultima pregunta del item examen*/
						$resulUltimaPreguntadeItem=$objPregunaNew->mostrarLaUltimaPreguntaDeItem($idUltimoItem);
						$filUltimaPregunta=mysqli_fetch_object($resulUltimaPreguntadeItem);
						$idUltimPregunta=$filUltimaPregunta->ultimaPreguntaDeItem;
                        
                        /*WHILE QUE RRECORRE TODAS LAS RESPUESTAS DE UNA PREGUNTA PARA CLONAR*/
                        $objRespuestasClonar=new Respuesta();
                        $resulRespuestasClonar=$objRespuestasClonar->listarRespuestasDeUnaPregunta($filPreguntasClonar->id_pregunta);
                        while ($filresPuestasClonar=mysqli_fetch_object($resulRespuestasClonar)) 
                        {
                        	$objResp=new Respuesta();
                        	$objResp->set_respuesta($filresPuestasClonar->respuesta);
                        	$objResp->set_valor($filresPuestasClonar->valor);
                        	$objResp->set_idpregunta($idUltimPregunta);
                        	$objResp->guardarRespuesta();
                        	
                        }/*FIN DEL WHILE QUE RRECORRE TODAS LAS RESPUESTAS DE UNA PREGUNTA PARA CLONAR*/


						
					}/*fin del if que pregunta si se guardo la pregunta*/
					
				}/*FIN DEL WHILE QUE RRECORRE TODAS LAS PREGUNTAS DEL ITEM EXAMEN(PARA CLONARLAS)*/
				
			}/*FIN DEL IF DONDE PREGUNTAMOS SI EL ITEM QUE SE CLONO ES DE TIPO EXAMEN*/
			
		}/*FIN DEL IF QUE PREGUNTA SI EL ITEM SE INSERTO CORRECTAMENTE*/



		
	}/*FIN DEL WHILE QUE RRECORRE TODOS LOS ITEMS DEL LA CAPACITACION A CLONAR*/
	echo 1;
	
	
}
else
{
	echo 0;
}

?>