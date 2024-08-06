<?php 
namespace App\Model;

use App\Model\Model;

class Venda extends Model {
	
	private $table = "vendas";
	protected $fields = [
		"id",
		"nome_cliente",
		"data",
		"id_produto",
		"quantidade",
		"dinheiro"
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
	function selectVendaPesquisa($pesquisa)
	{
		$pesquisa = $this->sanitize($pesquisa);
	
	
		$sql = "
			SELECT *
			FROM " . $this->table . " AS c
			INNER JOIN (
				SELECT MAX(id) AS max_id
				FROM " . $this->table . "
				WHERE data LIKE '%" . $pesquisa . "%' 
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
	function selectPorData($data): array
	{
		$sql = "SELECT vendas.*, produtos.descricao AS nome_produto
        FROM vendas
        INNER JOIN produtos ON vendas.id_produto = produtos.id
        WHERE vendas.data = :data";
		$stmt = $this->querySelect($sql, array(':data' => $data));
		return $stmt;

	}
}


// 			SELECT agendamento.*, servicos.titulo AS nome_servico,
//          usuarios.nome AS nome_barbeiro, usuarios.telefone AS telefone_barbeiro FROM agendamento 
//         INNER JOIN servicos ON agendamento.servico_id = servicos.id 
//         INNER JOIN usuarios ON agendamento.barbeiro_id = usuarios.id
//         WHERE agendamento.id_cliente = :id_cliente ";