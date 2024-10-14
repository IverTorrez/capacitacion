<?php
include_once('clsconexion.php');
class Capacitacion extends Conexion{
	private $id_capacitacion;
	private $nombre_capacitacion;
	private $tipo_capacitacion;
	private $id_capacitador;
	private $estado;
	

	public function Capacitacion()
	{
		parent::Conexion();
		$this->id_capacitacion=0;
		$this->nombre_capacitacion="";
		$this->tipo_capacitacion="";
		$this->id_capacitador=0;
		$this->estado="";
	
	}

	public function setid_capacitacion($valor)
	{
		$this->id_capacitacion=$valor;
	}
	public function getid_capacitacion()
	{
		return $this->id_capacitacion;
	}
	public function set_nombre_capacitacion($valor)
	{
		$this->nombre_capacitacion=$valor;
	}
	public function get_nombre_capacitacion()
	{
		return $this->nombre_capacitacion;
	}
	public function set_tipoCapacitacion($valor)
	{
		$this->tipo_capacitacion=$valor;
	}
	public function get_tipoCapacitacion()
	{
		return $this->tipo_capacitacion;
	}
	public function set_idCapacitador($valor)
	{
		$this->id_capacitador=$valor;
	}
	public function get_idCapacitador()
	{
		return $this->id_capacitador;
	}

	public function set_estado($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado()
	{
		return $this->estado;
	}
	
	

	public function guardarCapacitacion()
	{
		$sql="INSERT INTO capacitacion(nombre_capacitacion,tipo_capacitacion,id_capacitador,estado) VALUES('$this->nombre_capacitacion','$this->tipo_capacitacion','$this->id_capacitador','$this->estado')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function listarCapacitaciones()
	{
		$sql="SELECT *FROM capacitacion ORDER BY  nombre_capacitacion ASC";
		return parent::ejecutar($sql);
	}

	public function listarCapacitacionesActivas()
	{
		$sql="SELECT *FROM capacitacion WHERE estado='activa'";
		return parent::ejecutar($sql);
	}
	public function listarCapacitacionesCanceladas()
	{
		$sql="SELECT *FROM capacitacion WHERE estado='cancelada'";
		return parent::ejecutar($sql);
	}
	/*CUENTA LOS PROCESOS QUE AUN NO SE TERMINARON*/
	public function contarProcesosDeAvanceDeUnaCapacitacion($idCap,$totalItemDeCap)
	{
		$sql="SELECT COUNT(id_proceso)AS totalProcesosEnCurso FROM proceso_capacitacion WHERE proceso_capacitacion.id_capacitacion=$idCap AND nomero_item_avanzado<$totalItemDeCap";
		return parent::ejecutar($sql);
	}

	public function MostrarUnaCapacitacion($idCap)
	{
		$sql="SELECT *FROM capacitacion WHERE id_capacitacion=$idCap";
		return parent::ejecutar($sql);
	}

	public function listarTodosLosItemDeUnaCapacitacion($idCap)
	{
		$sql="SELECT id_item,nombre_item,nombre_item_interno,numero_item,tipo_item,tiempo_item FROM item_capacitacion WHERE id_capacitacion=$idCap ORDER BY numero_item ASC";
		return parent::ejecutar($sql);
	}

	public function listarCapacitacionesQuePuedeTomarUnProcurador($idproc)
	{
		$sql="SELECT (capacitacion.id_capacitacion)as idcapacitacion,(capacitacion.nombre_capacitacion)as nombrecapacitacion,(capacitacion.tipo_capacitacion)as tipocapacitacion FROM capacitacion WHERE capacitacion.id_capacitacion NOT IN( SELECT capacitacion.id_capacitacion FROM proceso_capacitacion,capacitacion WHERE capacitacion.id_capacitacion=proceso_capacitacion.id_capacitacion AND proceso_capacitacion.id_procurador=$idproc) AND capacitacion.estado='activa'";
		return parent::ejecutar($sql);

	}

	public function mostrarLasCapacitacionesEnCursoDeProc($idproc)
	{
		/*$sql="SELECT COUNT(item_capacitacion.id_item)as totalitem,(capacitacion.id_capacitacion)idcapacitacion,(capacitacion.nombre_capacitacion)as nombrecapacitacion,(capacitacion.tipo_capacitacion)tipocapacitacion,(proceso_capacitacion.nomero_item_avanzado)itemavanzado FROM capacitacion,proceso_capacitacion,item_capacitacion WHERE capacitacion.id_capacitacion=item_capacitacion.id_capacitacion AND capacitacion.id_capacitacion=proceso_capacitacion.id_capacitacion AND proceso_capacitacion.id_procurador=$idproc";*/
		$sql="SELECT (capacitacion.id_capacitacion)idcapacitacion,(capacitacion.nombre_capacitacion)as nombrecapacitacion,(capacitacion.tipo_capacitacion)tipocapacitacion,(proceso_capacitacion.nomero_item_avanzado)itemavanzado,(proceso_capacitacion.id_proceso)AS idproceso FROM capacitacion,proceso_capacitacion WHERE capacitacion.id_capacitacion=proceso_capacitacion.id_capacitacion AND proceso_capacitacion.id_procurador=$idproc";
		return parent::ejecutar($sql);
	}

	public function contadorDeItemsDeUnaCapacitacion($idcap)
	{
		$sql="SELECT COUNT(item_capacitacion.id_item)as totalitem FROM item_capacitacion WHERE item_capacitacion.id_capacitacion=$idcap";

		return parent::ejecutar($sql);
	}

	public function listarLosProcuradoresEnCursoDeUnaCapacitacion($idCap)
	{
		$sql="SELECT concat(procurador.nombre,' ',procurador.apellido)AS NombreProc,(proceso_capacitacion.nomero_item_avanzado)itemavanzado FROM capacitacion,procurador,proceso_capacitacion WHERE capacitacion.id_capacitacion=proceso_capacitacion.id_capacitacion AND proceso_capacitacion.id_procurador=procurador.id_procurador AND capacitacion.id_capacitacion=$idCap";
		return parent::ejecutar($sql);

	}

	public function listarCapacitacionesDeUnProcurador($idproc)
	{
		$sql="SELECT (capacitacion.nombre_capacitacion)nombrCapacitacion, (proceso_capacitacion.nomero_item_avanzado)as itemavanzado,(capacitacion.id_capacitacion)idcapacitacion FROM procurador,capacitacion,proceso_capacitacion WHERE procurador.id_procurador=proceso_capacitacion.id_procurador AND proceso_capacitacion.id_capacitacion=capacitacion.id_capacitacion AND procurador.id_procurador=$idproc";
		return parent::ejecutar($sql);
	}

	public function iniciarUnaCapacitacion()
	{
		$sql="UPDATE capacitacion SET estado='$this->estado' WHERE id_capacitacion='$this->id_capacitacion'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function mostrarNumeroDelUltimoExamenDeCap($idCap,$numeroItem)
	{
		$sql="SELECT (item_capacitacion.numero_item)numeroItemPorSuperar,item_capacitacion.nombre_item FROM capacitacion,item_capacitacion WHERE capacitacion.id_capacitacion=item_capacitacion.id_capacitacion AND item_capacitacion.tipo_item='EXAMEN' AND item_capacitacion.numero_item<$numeroItem AND capacitacion.id_capacitacion=$idCap ORDER BY item_capacitacion.numero_item DESC LIMIT 1";
		return parent::ejecutar($sql);

	}

	public function mostrarLaUltimaCapacitacionInsertada()
	{
		$sql="SELECT MAX(id_capacitacion)AS ultimaCapacitacion FROM capacitacion";
		return parent::ejecutar($sql);
	}

	public function mostrarCantidadProcesosDeUnaCapacitacion($idCap)
	{
		$sql="SELECT COUNT(id_proceso)totalProcesos FROM proceso_capacitacion WHERE proceso_capacitacion.id_capacitacion=$idCap";
		return parent::ejecutar($sql);
	}

	public function eliminarUnaCapacitacion()
	{
		$sql="DELETE FROM capacitacion WHERE id_capacitacion='$this->id_capacitacion'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;
	}

/*NUEVAS FUNCIONES PARA EDITAR NOMBRE DE LA CAPACITACION*/
	public function editarNombreCapacitacion()
	{
		$sql="UPDATE capacitacion SET nombre_capacitacion='$this->nombre_capacitacion' WHERE id_capacitacion='$this->id_capacitacion'";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}
/*FIN DE NUEVAS FUNCIONES PARA EDITAR NOMBRE DE LA CAPACITACION*/


}
?>