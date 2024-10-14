<?php
include_once('../modelo/clsRespuesta.php');

$objp=new Respuesta();


$objp->set_respuesta($_POST['text_respuesta']);
$objp->set_valor($_POST['valor']);
$objp->set_idpregunta($_POST['textid_pregunta']);



if ($objp->guardarRespuesta()) 
{
	$objpre=new Respuesta();
	$resulitem=$objpre->mostrarIdDelItemExamenDeUnaPregunta($_POST['textid_pregunta']);
	$filiditem=mysqli_fetch_object($resulitem);
	$iditem=$filiditem->id_item;
	
    echo $iditem;

}
else
{
	echo 0;
}

?>