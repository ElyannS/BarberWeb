<?php 
namespace App\Model;

use App\Model\Model;

class Venda extends Model {
	
	private $table = "vendas";
	protected $fields = [
		"id",
		"dataVenda",
		"nomeCliente",
        "forma_pagamento"
	];

	function insertVenda($campos)
	{
		$this->insert($this->table, $campos);
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
		$sql = "SELECT * FROM ".$this->table." WHERE descricao LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}