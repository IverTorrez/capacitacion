<?php
session_start();
include_once('../modelo/clsCapacitador.php');
include_once('../modelo/clsProcurador.php');

$objusu=new Procurador();
$objusu->setid_procurador($_POST['textid_procurador']);
$objusu->set_nombre($_POST['text_nombre']);
$objusu->set_apellido($_POST['text_apellido']);
$objusu->set_usuario_procu($_POST['userName']);
$objusu->set_password_procu($_POST['passuser']);
$objusu->set_telefono($_POST['text_telefono']);
$objusu->set_email($_POST['text_email']);
$objusu->set_direccion($_POST['text_direccion']);
$objusu->set_casa_estudio($_POST['text_casaEstudio']);

$newObjC=new Capacitador();
// verificara que nadie mas tenga ese misma contraseñe aparte de el , en la tabla capacitador
$idcapacitadorActual=0;
$resulverCap=$newObjC->verificadorDePassEnTablaCapacitador($_POST['passuser'],$idcapacitadorActual);
$filveriCap=mysqli_fetch_object($resulverCap);
$totalCOnlamismaPassEnTablaCapacitador=$filveriCap->totalCOnLaMismaPassUserCapaci;

// verificara que nadie mas tenga ese misma contraseñe aparte de el , en la tabla procurador
$idProcuradorActual=$_POST['textid_procurador'];
$objProc=new Procurador();
$resultPra=$objProc->verificadorDePassword($_POST['passuser'],$idProcuradorActual);
$filpassProc=mysqli_fetch_object($resultPra);
$totalCOnlamismaPassEnTablaProcurador=$filpassProc->totalCOnLaMismaPass;

if ($totalCOnlamismaPassEnTablaCapacitador==0 AND $totalCOnlamismaPassEnTablaProcurador==0) 
{
    if ($objusu->ActualizarDatosDeProcurador()) 
        {       $datosUsuarioP=array();
        	    $datosUsuarioP["id_procurador"]=$_POST["textid_procurador"];
                $datosUsuarioP["nombre"]=$_POST["text_nombre"];
                $datosUsuarioP["apellido"]=$_POST["text_apellido"];
                $datosUsuarioP["usuario_procu"]=$_POST["userName"];
                $datosUsuarioP["password_procu"]=$_POST["passuser"];
                $datosUsuarioP["telefono"]=$_POST["text_telefono"];
                $datosUsuarioP["email"]=$_POST["text_email"];
                $datosUsuarioP["direccion"]=$_POST["text_direccion"];
                $datosUsuarioP["casa_estudio"]=$_POST["text_casaEstudio"];

                 $_SESSION["usuarioP"]=$datosUsuarioP;
				
		       
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