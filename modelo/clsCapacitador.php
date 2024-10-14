<?php
include_once('clsconexion.php');
class Capacitador extends Conexion{
	private $id_capacitador;
	private $nombre;
	private $apellido;
	private $usuario_cap;
	private $password_cap;
	private $telefono;

	public function Capacitador()
	{
		parent::Conexion();
		$this->id_capacitador=0;
		$this->nombre="";
		$this->apellido="";
		$this->usuario_cap="";
		$this->password_cap="";
		$this->telefono="";
	}

	public function setid_capacitador($valor)
	{
		$this->id_capacitador=$valor;
	}
	public function getid_capacitador()
	{
		return $this->id_capacitador;
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
	public function set_usuario_cap($valor)
	{
		$this->usuario_cap=$valor;
	}
	public function get_usuario_cap()
	{
		return $this->usuario_cap;
	}
	public function set_password_cap($valor)
	{
		$this->password_cap=$valor;
	}
	public function get_password_cap()
	{
		return $this->password_cap;
	}
	
	public function set_telefono_cap($valor)
	{
		$this->telefono=$valor;
	}
	public function get_telefono_cap()
	{
		return $this->telefono;
	}
	

	public function guardarCapacitador()
	{
		$sql="INSERT INTO capacitador(nombre,apellido,usuario_cap,password_cap,telefono) VALUES('$this->nombre','$this->apellido','$this->usuario_cap','$this->password_cap','$this->telefono')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function loginCapacitador()
	{
		$sql="SELECT * from capacitador where usuario_cap='$this->usuario_cap' and password_cap='$this->password_cap' ";
	return parent::ejecutar($sql);
	}

	public function verificadorDePassEnTablaCapacitador($passw,$idcapActual)
	{
		$sql="SELECT COUNT(id_capacitador)AS totalCOnLaMismaPassUserCapaci FROM capacitador WHERE password_cap='$passw' AND capacitador.id_capacitador<>'$idcapActual'";
		return parent::ejecutar($sql);
	}

	public function ActualizarUnCapacitador()
	{
		$sql="UPDATE capacitador SET nombre='$this->nombre',apellido='$this->apellido',usuario_cap='$this->usuario_cap',password_cap='$this->password_cap',telefono='$this->telefono' WHERE id_capacitador='$this->id_capacitador'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}
	public function mostrarElTelefonoDeUnCapacitadorCualquiera()
	{
		$sql="SELECT telefono FROM capacitador LIMIT 1";
		return parent::ejecutar($sql);
	}

}
?>