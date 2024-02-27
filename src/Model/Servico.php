<?php 
namespace App\Model;

use App\Model\Model;


class Servico extends Model {
	
	private $table = "servicos";
	protected $fields = [
		"id",
		"titulo",
		"url_amigavel",
		"descricao",
		"imagem_principal",
        "data_cadastro",
		"tempo_servico"
	];

	function insertServico($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateServico($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteServico($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectServico($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}

	public function selectServicoId($id): array
{
    $fields = implode(", ", $this->fields); // Obter os nomes das colunas separados por vírgula
    $sql = "SELECT $fields FROM $this->table WHERE id = :id";
    $params = [":id" => $id];
    return $this->querySelect($sql, $params);
}

	function getUltimoServico() 
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT 1";

		return $this->querySelect($sql)[0];
	}
	function selectServicosPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectServicosPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}