<?php 
namespace App\Model;

use App\Model\Model;

class Cliente extends Model {
	
	private $table = "clientes";
	protected $fields = [
		"id",
		"nome",
		"telefone",
		"email"
	];

	function insertCliente($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateCliente($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteCliente($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectCliente($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	
	function getUltimoCliente() 
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT 1";

		return $this->querySelect($sql)[0];
	}
	function selectClientesPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectClientesPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}