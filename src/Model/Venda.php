<?php 
namespace App\Model;

use App\Model\Model;

class Venda extends Model {
	
	private $table = "produtos";
	protected $fields = [
		"id",
		"descricao",
		"barras",
		"estoque",
        "vlrCusto",
        "vlrVenda"
	];

	function insertProduto($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateProduto($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteProduto($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectProduto($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectProdutosPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectProdutosPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE descricao LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}