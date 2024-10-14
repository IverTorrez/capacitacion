<?php
session_start();
include_once('../modelo/clsProcurador.php');
include_once('../modelo/clsCapacitador.php');

$objusu=new Procurador();
$objusu->set_usuario_procu($_POST['usulogin']);
$objusu->set_password_procu($_POST['textpasslogin']);

$resul1=$objusu->loginProcurador();
$datosUsuarioP=array();


$objusuC=new Capacitador();
$objusuC->set_usuario_cap($_POST['usulogin']);
$objusuC->set_password_cap($_POST['textpasslogin']);

$resul2=$objusuC->loginCapacitador();
$datosUsuarioC=array();



if($data=mysqli_fetch_array($resul1))
{
	$datosUsuarioP["id_procurador"]=$data["id_procurador"];
	$datosUsuarioP["nombre"]=$data["nombre"];
	$datosUsuarioP["apellido"]=$data["apellido"];
	$datosUsuarioP["apellido"]=$data["apellido"];
	$datosUsuarioP["usuario_procu"]=$data["usuario_procu"];
	$datosUsuarioP["password_procu"]=$data["password_procu"];
	$datosUsuarioP["telefono"]=$data["telefono"];
	$datosUsuarioP["email"]=$data["email"];
	$datosUsuarioP["direccion"]=$data["direccion"];
	$datosUsuarioP["casa_estudio"]=$data["casa_estudio"];

	$_SESSION["usuarioP"]=$datosUsuarioP;

    echo 1;/*SE DIRECCIONA A LA VISTA PRINCIPAL DEL PROCURADOR*/
		
}
  else
   {
   	  if($dataC=mysqli_fetch_array($resul2))
        {
			
				$datosUsuarioC["id_capacitador"]=$dataC["id_capacitador"];
				$datosUsuarioC["nombre"]=$dataC["nombre"];
				$datosUsuarioC["apellido"]=$dataC["apellido"];
				$datosUsuarioC["usuario_cap"]=$dataC["usuario_cap"];
				$datosUsuarioC["password_cap"]=$dataC["password_cap"];
				$datosUsuarioC["telefono"]=$dataC["telefono"];
				
		        $_SESSION["usuarioC"]=$datosUsuarioC;

		        echo 2;/*SE DIRECCIONA A LA VISTA PRINCIPAL DEL CAPACITADOR*/
	
        }
        else
        {
        	 echo 3;/*NO EXISTE EL USUARIO*/
        }

     
   }

?>