<?php
include_once('clsconexion.php');
class Preguntas extends Conexion{
	private $id_pregunta;
	private $pregunta;
	private $cantidad_respuestas;
	private $id_item;
	
	public function Preguntas()
	{
		parent::Conexion();
		$this->id_pregunta=0;
		$this->pregunta="";
		$this->cantidad_respuestas=0;
		$this->id_item=0;
	}

	public function setid_pregunta($valor)
	{
		$this->id_pregunta=$valor;
	}
	public function getid_pregunta()
	{
		return $this->id_pregunta;
	}
	public function set_pregunta($valor)
	{
		$this->pregunta=$valor;
	}
	public function get_pregunta()
	{
		return $this->pregunta;
	}
	public function set_cantidad_respuestas($valor)
	{
		$this->cantidad_respuestas=$valor;
	}
	public function get_cantidad_respuestas()
	{
		return $this->cantidad_respuestas;
	}
	public function set_idItem($valor)
	{
		$this->id_item=$valor;
	}
	public function get_idItem()
	{
		return $this->id_item;
	}
	
	

	public function guardarPregunta()
	{
		$sql="INSERT INTO preguntas(pregunta,cantidad_respuestas,id_item) VALUES('$this->pregunta','$this->cantidad_respuestas','$this->id_item')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}
	public function mostrarUltimaPreguntaDeItem($idItem)
	{
		$sql="SELECT MAX(id_pregunta)AS ultimapregunta FROM preguntas WHERE id_item=$idItem";
		return parent::ejecutar($sql);
	}

	public function mostrarUnaPregunta($idpre)
	{
		$sql="SELECT id_pregunta,pregunta,cantidad_respuestas,id_item FROM preguntas WHERE id_pregunta=$idpre";
		return parent::ejecutar($sql);
	}

	public function listarTodasLaPreguntasDeItemExamen($iditemex)
	{
		$sql="SELECT id_pregunta,pregunta,cantidad_respuestas,id_item  FROM preguntas WHERE id_item=$iditemex ORDER BY id_pregunta ASC";
		return parent::ejecutar($sql);
	}

	public function eliminarUnaPregunta()
	{
		$sql="DELETE FROM preguntas WHERE id_pregunta='$this->id_pregunta'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function eliminarPreguntasDeUnItemExamen($idItem)
	{
		$sql="DELETE FROM preguntas WHERE id_item='$idItem'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;
	}

	public function mostrarLaUltimaPreguntaDeItem($idItem)
	{
		$sql="SELECT MAX(id_pregunta)AS ultimaPreguntaDeItem FROM preguntas WHERE id_item=$idItem";
		return parent::ejecutar($sql);
	}


}
?>