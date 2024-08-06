<?php 
namespace App\Model;

use App\Model\Model;

class Comanda extends Model {
	
	private $table = "comanda";
	protected $fields = [
		"id",
		"id_venda",
		"id_produto",
		"dinheiro",
		"pix",
		"cartao",
		"quantidade",
	];

	function insertComanda($campos)
	{
		$this->insertChat($this->table, $campos);
	}

	function updateComanda($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteComanda($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectComanda($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectComandasPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectComandasPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE descricao LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}