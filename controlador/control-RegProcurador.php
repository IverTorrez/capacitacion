<?php
session_start();
include_once('../modelo/clsProcurador.php');
include_once('../modelo/clsCapacitador.php');

$objusu=new Procurador();
$objusu->set_nombre($_POST['text_nombre']);
$objusu->set_apellido($_POST['text_apellido']);
$objusu->set_usuario_procu($_POST['userName']);
$objusu->set_password_procu($_POST['passuser']);
$objusu->set_telefono($_POST['text_telefono']);
$objusu->set_email($_POST['text_email']);
$objusu->set_direccion($_POST['text_direccion']);
$objusu->set_casa_estudio($_POST['text_casaEstudio']);
$objusu->set_estado('activo');

$idProcuradorActual=0;
$objpro=new Procurador();
$resulVeri=$objpro->verificadorDePassword($_POST['passuser'],$idProcuradorActual);
$filveri=mysqli_fetch_object($resulVeri);
$totalConLaMismaPass=$filveri->totalCOnLaMismaPass;

$idcapacitadorActual=0;
$objCap=new Capacitador();
$resulCap=$objCap->verificadorDePassEnTablaCapacitador($_POST['passuser'],$idcapacitadorActual);
$filpassCap=mysqli_fetch_object($resulCap);
$totalConLaMismaPassCapacitador=$filpassCap->totalCOnLaMismaPassUserCapaci;


/*por verdadero, hay contraseñas iguales, no se registra*/
if ($totalConLaMismaPass>0 || $totalConLaMismaPassCapacitador>0) 
{
  echo 2;	
}
/*por falso, se sigue con el registro*/
else
{
	if ($objusu->guardarProcurador()) 
	{
		$resul1=$objusu->loginAlregistrarse($_POST['userName'],$_POST['passuser']);
        $datosUsuarioP=array();
        $data=mysqli_fetch_array($resul1);

		$datosUsuarioP["id_procurador"]=$data["id_procurador"];
		$datosUsuarioP["nombre"]=$data["nombre"];
		$datosUsuarioP["apellido"]=$data["apellido"];
		$datosUsuarioP["usuario_procu"]=$data["usuario_procu"];
		$datosUsuarioP["password_procu"]=$data["password_procu"];
		$datosUsuarioP["telefono"]=$data["telefono"];
		$datosUsuarioP["email"]=$data["email"];
		$datosUsuarioP["direccion"]=$data["direccion"];
		$datosUsuarioP["casa_estudio"]=$data["casa_estudio"];

		$_SESSION["usuarioP"]=$datosUsuarioP;
		echo 1;
	}
	else
	{
		echo 0;
	}
}





?>