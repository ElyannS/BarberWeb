<?php 
namespace App\Model;

use App\Model\Model;

class Barbeiro extends Model {
	
	private $table = "barbeiros";
	protected $fields = [
		"id",
		"nome",
		"id_servico",
		"cargo",
        "imagem_principal",
        "status"
	];

	function insertBarbeiro($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateBarbeiro($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteBarbeiro($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectBarbeiro($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectBarbeirosPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectBarbeirosPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}