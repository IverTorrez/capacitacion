<?php
session_start();
include_once('../modelo/clsCapacitador.php');
include_once('../modelo/clsProcurador.php');

$objusu=new Capacitador();
$objusu->setid_capacitador($_POST['idcapacitador']);
$objusu->set_nombre($_POST['text_nombre']);
$objusu->set_apellido($_POST['text_apellido']);
$objusu->set_usuario_cap($_POST['userName']);
$objusu->set_password_cap($_POST['passuser']);

$objusu->set_telefono_cap($_POST['text_telefono']);

$newObjC=new Capacitador();
// verificara que nadie mas tenga ese misma contraseñe aparte de el , en la tabla capacitador
$resulverCap=$newObjC->verificadorDePassEnTablaCapacitador($_POST['passuser'],$_POST['idcapacitador']);
$filveriCap=mysqli_fetch_object($resulverCap);
$totalCOnlamismaPassEnTablaCapacitador=$filveriCap->totalCOnLaMismaPassUserCapaci;

$idProcuradorActual=0;
$objProc=new Procurador();
$resultPra=$objProc->verificadorDePassword($_POST['passuser'],$idProcuradorActual);
$filpassProc=mysqli_fetch_object($resultPra);
$totalCOnlamismaPassEnTablaProcurador=$filpassProc->totalCOnLaMismaPass;

if ($totalCOnlamismaPassEnTablaCapacitador==0 AND $totalCOnlamismaPassEnTablaProcurador==0) 
{
    if ($objusu->ActualizarUnCapacitador()) 
        {       
        	    $datosUsuarioC=array();
        	    $datosUsuarioC["id_capacitador"]=$_POST['idcapacitador'];
				$datosUsuarioC["nombre"]=$_POST['text_nombre'];
				$datosUsuarioC["apellido"]=$_POST['text_apellido'];
				$datosUsuarioC["usuario_cap"]=$_POST['userName'];
				$datosUsuarioC["password_cap"]=$_POST['passuser'];
				$datosUsuarioC["telefono"]=$_POST['text_telefono'];
				
		        $_SESSION["usuarioC"]=$datosUsuarioC;
    		echo 1;
    	}
    	else
    	{
    		echo 0;
    	}	
}
else/*debe cambiar contraseña*/
{
	echo 2;
}


?>