<?php
include_once('../modelo/clsPregunta.php');
include_once('../modelo/clsRespuesta.php');

$objp=new Preguntas();
$objp->setid_pregunta($_POST['textid_pregunta']);


   $objresp=new Respuesta();
if ($objresp->eliminarRespuestasDePregunta($_POST['textid_pregunta'])) 
{
	if ($objp->eliminarUnaPregunta()) 
		{	
		    echo 1;
		}
		else
		{
			echo 0;
		}
}

else
{
	echo 0;
}

?>