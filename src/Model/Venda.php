<?php 
namespace App\Model;

use App\Model\Model;

class Venda extends Model {
	
	private $table = "vendas";
	protected $fields = [
		"id",
		"dataVenda",
		"nomeCliente",
	];

	public function insertVenda($campos)
	{
		$this->insertChat($this->table, $campos);
		return $this->lastInsertId(); // Retorna o ID da venda recém-criada
	}

	function updateVenda($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteVenda($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectVenda($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectVendasPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectVendasPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE nomeCliente LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}