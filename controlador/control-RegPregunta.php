<?php
include_once('../modelo/clsPregunta.php');

$objp=new Preguntas();


$objp->set_pregunta($_POST['textpregunta']);
$objp->set_cantidad_respuestas($_POST['select_cant_respuesta']);
$objp->set_idItem($_POST['textid_itemexamen']);



if ($objp->guardarPregunta()) 
{
	$objPre=new Preguntas();
	$resulultimap=$objPre->mostrarUltimaPreguntaDeItem($_POST['textid_itemexamen']);
	$filultima=mysqli_fetch_object($resulultimap);

	$idUltimoItem=$filultima->ultimapregunta;

	// $arraynuevo=array(1,$idUltimoItem);
	// echo json_encode($arraynuevo);
    echo 	$idUltimoItem;

}
else
{
	echo 0;
}

?>