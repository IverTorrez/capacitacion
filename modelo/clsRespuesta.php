<?php
include_once('clsconexion.php');
class Respuesta extends Conexion{
	private $id_respuesta;
	private $respuesta;
	private $valor;
	private $id_pregunta;
	
	public function Respuesta()
	{
		parent::Conexion();
		$this->id_respuesta=0;
		$this->respuesta="";
		$this->valor=0;
		$this->id_pregunta=0;
	}

	public function setid_respuesta($valor)
	{
		$this->id_respuesta=$valor;
	}
	public function getid_respuesta()
	{
		return $this->id_respuesta;
	}
	public function set_respuesta($valor)
	{
		$this->respuesta=$valor;
	}
	public function get_respuesta()
	{
		return $this->respuesta;
	}
	public function set_valor($valor)
	{
		$this->valor=$valor;
	}
	public function get_valor()
	{
		return $this->valor;
	}
	public function set_idpregunta($valor)
	{
		$this->id_pregunta=$valor;
	}
	public function get_idpregunta()
	{
		return $this->id_pregunta;
	}
	
	

	public function guardarRespuesta()
	{
		$sql="INSERT INTO respuesta(respuesta,valor,id_pregunta) VALUES('$this->respuesta','$this->valor','$this->id_pregunta')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function mostrarIdDelItemExamenDeUnaPregunta($idpreg)
	{
		$sql="SELECT id_item FROM preguntas WHERE id_pregunta=$idpreg";
		return parent::ejecutar($sql);
	}

	public function listarRespuestasDeUnaPregunta($idpregunta)
	{
		$sql="SELECT id_respuesta,respuesta,valor,id_pregunta FROM respuesta WHERE id_pregunta=$idpregunta ORDER BY id_respuesta ASC";
		return parent::ejecutar($sql);
	}

	public function eliminarRespuestasDePregunta($idpregunta)
	{
		$sql="DELETE FROM respuesta WHERE id_pregunta=$idpregunta";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;
	}

	

}
?>