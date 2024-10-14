<?php
include_once('clsconexion.php');
class Procurador extends Conexion{
	private $id_procurador;
	private $nombre;
	private $apellido;
	private $usuario_procu;
	private $password_procu;
	private $telefono;
	private $email;
	private $direccion;
	private $casa_estudio;
	private $estado;

	public function Procurador()
	{
		parent::Conexion();
		$this->id_procurador=0;
		$this->nombre="";
		$this->apellido="";
		$this->usuario_procu="";
		$this->password_procu="";
		$this->telefono="";
		$this->email="";
		$this->direccion="";
		$this->casa_estudio="";
		$this->estado="";
	}

	public function setid_procurador($valor)
	{
		$this->id_procurador=$valor;
	}
	public function getid_procurador()
	{
		return $this->id_procurador;
	}
	public function set_nombre($valor)
	{
		$this->nombre=$valor;
	}
	public function get_nombre()
	{
		return $this->nombre;
	}
	public function set_apellido($valor)
	{
		$this->apellido=$valor;
	}
	public function get_apellido()
	{
		return $this->apellido;
	}
	public function set_usuario_procu($valor)
	{
		$this->usuario_procu=$valor;
	}
	public function get_usuario_procu()
	{
		return $this->usuario_procu;
	}
	public function set_password_procu($valor)
	{
		$this->password_procu=$valor;
	}
	public function get_password_procu()
	{
		return $this->password_procu;
	}

	public function set_telefono($valor)
	{
		$this->telefono=$valor;
	}
	public function get_telefono()
	{
		return $this->telefono;
	}

	public function set_email($valor)
	{
		$this->email=$valor;
	}
	public function get_email()
	{
		return $this->email;
	}

	public function set_direccion($valor)
	{
		$this->direccion=$valor;
	}
	public function get_direccion()
	{
		return $this->direccion;
	}

	public function set_casa_estudio($valor)
	{
		$this->casa_estudio=$valor;
	}
	public function get_casa_estudio()
	{
		return $this->casa_estudio;
	}
	
	public function set_estado($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado()
	{
		return $this->estado;
	}
	

	public function guardarProcurador()
	{
		$sql="INSERT INTO procurador(nombre,apellido,usuario_procu,password_procu,telefono,email,direccion,casa_estudio,estado) VALUES('$this->nombre','$this->apellido','$this->usuario_procu','$this->password_procu','$this->telefono','$this->email','$this->direccion','$this->casa_estudio','$this->estado')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

    public function listarProcuradores()
	{
		$sql="SELECT *FROM procurador WHERE estado='activo'";
		return parent::ejecutar($sql);
	}

	public function loginProcurador()
	{
		$sql="SELECT * from procurador where usuario_procu='$this->usuario_procu' and password_procu='$this->password_procu' and estado='activo'";
	return parent::ejecutar($sql);
	}

	public function mostrarUnProcurador($idpro)
	{
		$sql="SELECT *FROM procurador WHERE id_procurador=$idpro";
		return parent::ejecutar($sql);
	}

	public function verificadorDePassword($passw,$idprocactual)
	{
		$sql="SELECT COUNT(id_procurador)AS totalCOnLaMismaPass FROM procurador WHERE password_procu='$passw' and id_procurador<>$idprocactual";
		return parent::ejecutar($sql);
	}

	public function loginAlregistrarse($user,$pass)
	{
	  $sql="SELECT * from procurador where usuario_procu='$user' and password_procu='$pass' ";
	   return parent::ejecutar($sql);	
	}

	public function ActualizarDatosDeProcurador()
	{
		$sql="UPDATE procurador SET nombre='$this->nombre',apellido='$this->apellido',usuario_procu='$this->usuario_procu',password_procu='$this->password_procu',telefono='$this->telefono',email='$this->email',direccion='$this->direccion',casa_estudio='$this->casa_estudio' WHERE id_procurador=$this->id_procurador";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;
	}
	
	/*NUEVA FUNCION PARAELIMINAR A LOS PROCURADOR*/
	public function elimProcurador()
	{
		$sql="UPDATE procurador SET estado='$this->estado' WHERE id_procurador='$this->id_procurador'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;
	}
	/*fin de NUEVA FUNCION PARAELIMINAR A LOS PROCURADOR*/

}
?>