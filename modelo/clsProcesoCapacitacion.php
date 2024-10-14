<?php
include_once('clsconexion.php');
class Proceso_Capacitacion extends Conexion{
	private $id_proceso;
	private $nomero_item_avanzado;
	private $id_procurador;
	private $id_capacitacion;
	
	public function Proceso_Capacitacion()
	{
		parent::Conexion();
		$this->id_proceso=0;
		$this->nomero_item_avanzado="";
		$this->id_procurador=0;
		$this->id_capacitacion=0;
	}

	public function setid_proceso($valor)
	{
		$this->id_proceso=$valor;
	}
	public function getid_proceso()
	{
		return $this->id_proceso;
	}
	public function set_numeroItemAvanzado($valor)
	{
		$this->nomero_item_avanzado=$valor;
	}
	public function get_numeroItemAvanzado()
	{
		return $this->nomero_item_avanzado;
	}
	public function set_idProcurador($valor)
	{
		$this->id_procurador=$valor;
	}
	public function get_idProcurador()
	{
		return $this->id_procurador;
	}
	public function set_idCapacitacion($valor)
	{
		$this->id_capacitacion=$valor;
	}
	public function get_idCapacitacion()
	{
		return $this->id_capacitacion;
	}
	
	

	public function guardarProcesoCapacitacion()
	{
		$sql="INSERT INTO proceso_capacitacion(nomero_item_avanzado,id_procurador,id_capacitacion) VALUES('$this->nomero_item_avanzado','$this->id_procurador','$this->id_capacitacion')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;
	}

	public function mostrarItemAvanzadoDeUnaCapacitacionDeProcurador($idcap,$idproc)
	{
		$sql="SELECT id_proceso,nomero_item_avanzado FROM proceso_capacitacion WHERE proceso_capacitacion.id_capacitacion=$idcap AND proceso_capacitacion.id_procurador=$idproc";
		return parent::ejecutar($sql);
	}

	public function actualizarProcesoCapacitacion()
	{
		$sql="UPDATE proceso_capacitacion SET nomero_item_avanzado=$this->nomero_item_avanzado WHERE id_proceso=$this->id_proceso";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function mostrarUnProcesoDeAvance($idproceso)
	{
		$sql="SELECT id_proceso,nomero_item_avanzado,id_procurador,id_capacitacion FROM proceso_capacitacion WHERE id_proceso=$idproceso";
		return parent::ejecutar($sql);
	}

	public function restablecerProcesoCapacitacion()
	{
		$sql="UPDATE proceso_capacitacion SET nomero_item_avanzado=$this->nomero_item_avanzado WHERE id_proceso=$this->id_proceso";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}


	
}
?>