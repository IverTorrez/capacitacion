<?php
include_once('../modelo/clsItemCapacitacion.php');

$objitem=new Item_Capacitacion();

/*OBTENEMOS LOS DATOS DESDE LA VISTA DE ELIMINAR*/
$idItem=$_POST['textid_itemPDF_edit'];
$tituloItem=$_POST['textituloPDF_EDIT'];
$tiempo_delItempdf=$_POST['select_minPdf_EDIT'].$_POST['select_segPdf_EDIT'];


$objitem->setid_item($idItem);
$objitem->set_nombreItem($tituloItem);
$objitem->set_tiempoItem($tiempo_delItempdf);
// PREGUNTA SI file_pdf_EDIT es igual a vacio (NO SELECCIONO UN ARCHIVO PARA MODIFICAR), se modificara solo los datos 
if ($_FILES['file_pdf_EDIT']['name']=='') 
{
	if ($objitem->editarUnItemPDFSinArchivo())
	{
		echo 1;
	}
	else
	{
      echo 0;
	}
	
}/*FIN PREGUNTA SI file_pdf_EDIT es igual a vacio (NO SELECCIONO UN ARCHIVO PARA MODIFICAR)*/

// POR FALSO SE TENDRA QUE EDITAR TAMBIEN EL ARCHIVO PDF
	else
	{
		// OPTENEMOS EL archivo PDF
		$archivo=$_FILES['file_pdf_EDIT']['name'];
		$newNombre=eliminar_tildes($archivo);
		$newNombre = $newNombre;
		// reemplazamos caracteres ESPECIALES que nos esten dentro de los admitidos
		$newNombre = preg_replace('([^A-Za-z0-9-.])', '_', $newNombre);
		$destino="../archivos_pdf_capacitacion/".$newNombre;
		$ruta=$_FILES['file_pdf_EDIT']['tmp_name'];

        /*CARGAMOS EL SET QUE NOS FALTA PARA EDITAR EL ARCHIVO*/
		$objitem->set_nombreItemInterno($newNombre);

		/*VERIFICAMOS SI EXISTE EL ARCHIVO EN EL DIRECTORIO*/
		if (!file_exists($destino)) 
			 {
			   copy($ruta,$destino);

				if ($objitem->editarUnItemPDF_Con_Archivo()) 
					{
						echo 2;
					}
				else
					{
						echo 0;
					}
					   
			 }//POR FALSO, OSEA YA EXISTE UN ARCHIVO CON ESE NOMBRE
			 else
			 {
			     echo 3;
			 }


	}









// FUNCION QUE ELIMINA TILDES Y CARACTERES ESPECIALES
function eliminar_tildes($cadena){
    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = utf8_encode($cadena);
    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}
?>