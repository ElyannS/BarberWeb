<?php 
namespace App\Model;

use App\Model\Model;

class Recomendacao extends Model {
	
	private $table = "recomendacoes";
	protected $fields = [
		"id",
		"nome",
		"profissao",
        'avaliacao',
		"descricao",
		"foto_cliente",
        "data_cadastro", 
        "status"
	];

	function insertRecomendacao($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateRecomendacao($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteRecomendacao($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectRecomendacao($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}

	function selectRecomendacoesPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
    
	function selectRecomendacoesPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE nome LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}