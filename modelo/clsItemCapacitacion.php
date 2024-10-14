<?php
include_once('clsconexion.php');
class Item_Capacitacion extends Conexion{
	private $id_item;
	private $nombre_item;
	private $nombre_item_interno;
	private $numero_item;
	private $tipo_item;
	private $tiempo_item;
	private $id_capacitacion;
	

	public function Item_Capacitacion()
	{
		parent::Conexion();
		$this->id_item=0;
		$this->nombre_item="";
		$this->numero_item="";
		$this->tipo_item="";
		$this->tiempo_item="";
		$this->id_capacitacion=0;
	
	}

	public function setid_item($valor)
	{
		$this->id_item=$valor;
	}
	public function getid_item()
	{
		return $this->id_item;
	}
	public function set_nombreItem($valor)
	{
		$this->nombre_item=$valor;
	}
	public function get_nombreItem()
	{
		return $this->nombre_item;
	}

	public function set_nombreItemInterno($valor)
	{
		$this->nombre_item_interno=$valor;
	}
	public function get_nombreItemInterno()
	{
		return $this->nombre_item_interno;
	}

	public function set_numeroItem($valor)
	{
		$this->numero_item=$valor;
	}
	public function get_numeroItem()
	{
		return $this->numero_item;
	}
	public function set_tipoItem($valor)
	{
		$this->tipo_item=$valor;
	}
	public function get_tipoItem()
	{
		return $this->tipo_item;
	}

	public function set_tiempoItem($valor)
	{
		$this->tiempo_item=$valor;
	}
	public function get_tiempoItem()
	{
		return $this->tiempo_item;
	}

	public function set_idCapacitacion($valor)
	{
		$this->id_capacitacion=$valor;
	}
	public function get_idCapacitacion()
	{
		return $this->id_capacitacion;
	}
	
	

	public function guardarItemCapacitacion()
	{
		$sql="INSERT INTO item_capacitacion(nombre_item,nombre_item_interno,numero_item,tipo_item,tiempo_item,id_capacitacion) VALUES('$this->nombre_item','$this->nombre_item_interno','$this->numero_item','$this->tipo_item','$this->tiempo_item','$this->id_capacitacion')";
		if (parent::ejecutar($sql))
			return true;
		else
			return false;

	}

	public function contarItemDeUnaCapacitacion($idCap)
	{
		$sql="SELECT COUNT(id_item)AS totalItem FROM item_capacitacion WHERE id_capacitacion=$idCap";
		return parent::ejecutar($sql);
	}

	public function mostrarUnItem($iditem)
	{
		$sql="SELECT *FROM item_capacitacion WHERE id_item=$iditem";
		return parent::ejecutar($sql);
	}

	public function mostrarUnItemDeCapacitacion($idCap,$Num)
    {
      $sql="SELECT id_item, nombre_item,nombre_item_interno,numero_item,tipo_item,tiempo_item,id_capacitacion FROM item_capacitacion WHERE item_capacitacion.id_capacitacion=$idCap AND item_capacitacion.numero_item=$Num";
      return parent::ejecutar($sql);
    }

    public function eliminarDeLaBD_Un_ItemDeCapacitacion()
    {
    	$sql="DELETE FROM item_capacitacion WHERE id_item='$this->id_item'";
    	if (parent::ejecutar($sql))
			return true;
		else
			return false;

    }

    public function listarItemDespuesDeUnTem_DeUnaCapacitacion_ASC($idCap,$numeroItem)
    {
    	$sql="SELECT id_item,nombre_item,numero_item,id_capacitacion FROM item_capacitacion WHERE item_capacitacion.id_capacitacion=$idCap AND item_capacitacion.numero_item>$numeroItem ORDER BY numero_item ASC";
    	return parent::ejecutar($sql);
    }

    public function modificarELnumeroDeUnItem()
    {
    	$sql="UPDATE item_capacitacion SET numero_item='$this->numero_item' WHERE id_item='$this->id_item'";
    	if (parent::ejecutar($sql))
			return true;
		else
			return false;

    }

    public function editarUnItemPDFSinArchivo()
    {
    	$sql="UPDATE item_capacitacion SET nombre_item='$this->nombre_item', tiempo_item='$this->tiempo_item' WHERE id_item='$this->id_item'";
    	if (parent::ejecutar($sql))
			return true;
		else
			return false;

    }

    public function editarUnItemPDF_Con_Archivo()
    {
    	$sql="UPDATE item_capacitacion SET nombre_item='$this->nombre_item', tiempo_item='$this->tiempo_item', nombre_item_interno='$this->nombre_item_interno' WHERE id_item='$this->id_item'";
    	if (parent::ejecutar($sql))
			return true;
		else
			return false;
    }

    public function editarUnItemLink()
    {
    	$sql="UPDATE item_capacitacion SET nombre_item='$this->nombre_item',nombre_item_interno='$this->nombre_item_interno' WHERE id_item='$this->id_item'";
    	if (parent::ejecutar($sql))
			return true;
		else
			return false;

    }

    public function editarUnItemExamen()
    {
    	$sql="UPDATE item_capacitacion SET nombre_item='$this->nombre_item', tiempo_item='$this->tiempo_item',nombre_item_interno='$this->nombre_item_interno' WHERE id_item='$this->id_item'";
    	if (parent::ejecutar($sql))
			return true;
		else
			return false;

    }

    public function mostrarElUltimoItemDeCapacitacion($idCap)
    {
    	$sql="SELECT MAX(id_item)AS ultimoItemInsertado FROM item_capacitacion WHERE id_capacitacion=$idCap";
    	return parent::ejecutar($sql);
    }
    
    /*NUEVAS FUNCIONES PARA MOVER UN ITEM A CUALQUIER NUMERO*/
    public function listarItemDeUnaCapacitacionEntreDosParametrosAscendente($idCap,$numeroItem_1,$numeroItem_2)
    {
    	$sql="SELECT (item_capacitacion.id_item)AS idItem,(item_capacitacion.nombre_item)AS nombreItem,(item_capacitacion.numero_item)AS numeroItem FROM item_capacitacion WHERE item_capacitacion.id_capacitacion=$idCap AND numero_item BETWEEN $numeroItem_1 AND $numeroItem_2 ORDER BY numero_item ASC";
    	return parent::ejecutar($sql);
    }

    public function listarItemDeUnaCapacitacionEntreDosParametrosDescendente($idCap,$numeroItem_1,$numeroItem_2)
    {
    	$sql="SELECT (item_capacitacion.id_item)AS idItem,(item_capacitacion.nombre_item)AS nombreItem,(item_capacitacion.numero_item)AS numeroItem FROM item_capacitacion WHERE item_capacitacion.id_capacitacion=$idCap AND numero_item BETWEEN $numeroItem_1 AND $numeroItem_2 ORDER BY numero_item DESC";
    	return parent::ejecutar($sql);
    }
    /*fin de NUEVAS FUNCIONES PARA MOVER UN ITEM A CUALQUIER NUMERO*/

}
?>