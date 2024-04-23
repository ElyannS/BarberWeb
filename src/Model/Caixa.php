<?php 
namespace App\Model;

use App\Model\Model;

class Caixa extends Model {
	
	private $table = "caixa";
	protected $fields = [
		"id",
		"nome_cliente",
		"data",
		"pix",
		"cartao",
		"dinheiro"
	];

	function insertCaixa($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateCaixa($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteCaixa($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectCaixa($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectCaixasPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectCaixasPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
	function selectPorData($data) {
        $sql = "SELECT * FROM caixa WHERE data = '{$data}' ORDER BY id DESC";
        return $this->querySelect($sql);
    }

}