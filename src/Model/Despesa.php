<?php 
namespace App\Model;

use App\Model\Model;

class Despesa extends Model {
	
	private $table = "despesas";
	protected $fields = [
		"id",
		"nome_despesa",
		"data",
		"pix",
		"cartao",
		"dinheiro"
	];

	function insertDespesa($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateDespesa($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteDespesa($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectDespesa($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectDespesasPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectDespesaPesquisa($pesquisa, $barbeiroId)
	{
		$pesquisa = $this->sanitize($pesquisa);
		$barbeiroId = intval($barbeiroId);
	
	
		$sql = "
			SELECT *
			FROM " . $this->table . " AS c
			INNER JOIN (
				SELECT MAX(id) AS max_id
				FROM " . $this->table . "
				WHERE data LIKE '%" . $pesquisa . "%' AND id_barbeiro = " . $barbeiroId . "
				GROUP BY data
			) AS sub ON c.id = sub.max_id
			ORDER BY c.id DESC
		";
		return $this->querySelect($sql);
	}
	private function sanitize($input)
	{
		return htmlspecialchars(strip_tags($input));
	}
	function selectPorData($data, $barbeiroId): array
	{
		$sql = "SELECT * FROM despesas WHERE data = :data AND despesas.id_barbeiro = :barbeiroId";
		$stmt = $this->querySelect($sql, array(':data' => $data, ':barbeiroId' => $barbeiroId));
		return $stmt;	
	}
}