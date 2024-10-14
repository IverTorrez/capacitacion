<?php
include_once('../modelo/clsItemCapacitacion.php');

$objitem=new Item_Capacitacion();

/*OBTENEMOS EL TOTAL DE ITEMS DE UNA CAPACITACION PARA SIGNAR EL NUMERO SIGUIENTE8*/
$resultitem=$objitem->contarItemDeUnaCapacitacion($_POST['textid_capacitacion']);
$filtotal=mysqli_fetch_object($resultitem);
$numerodeItem=$filtotal->totalItem+1;

// CONCATENAMOS EL TIEMPO DEL ITEM
$tiempo_delItempdf=$_POST['select_minPdf'].$_POST['select_segPdf'];


// OPTENEMOS EL archivo PDF
$archivo=$_FILES['files_PDF']['name'];
$newNombre=eliminar_tildes($archivo);
$newNombre = $newNombre;
// reemplazamos caracteres ESPECIALES que nos esten dentro de los admitidos
$newNombre = preg_replace('([^A-Za-z0-9-.])', '_', $newNombre);
$destino="../archivos_pdf_capacitacion/".$newNombre;
$ruta=$_FILES['files_PDF']['tmp_name'];
/*VERIFICAMOS SI EXISTE EL ARCHIVO EN EL DIRECTORIO*/

$objitem->set_nombreItem($_POST['textituloPDF']);
$objitem->set_tiempoItem($tiempo_delItempdf);
$objitem->set_tipoItem('PDF');
$objitem->set_numeroItem($numerodeItem);
$objitem->set_nombreItemInterno($newNombre);
$objitem->set_idCapacitacion($_POST['textid_capacitacion']);

if (!file_exists($destino)) 
 {
   copy($ruta,$destino);

	if ($objitem->guardarItemCapacitacion()) 
		{
			echo 1;
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

/*FIN DE VERIFICAMOS SI EXISTE EL ARCHIVO EN EL DIRECTORIO*/




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