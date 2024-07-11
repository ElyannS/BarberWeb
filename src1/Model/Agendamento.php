<?php
namespace App\Model;
use App\Model\Model;

class Agendamento extends Model {
    protected $table = "agendamento";
    public $timestamps = false;
    protected $fields = [
        "id",
        "barbeiro_id",
        "servico_id",
        "data_agendamento",
        "id_cliente",
        "descricao"
    ];

    public function insertAgendamento($campos)
    {
        $this->insert($this->table, $campos);
    }

    public function updateAgendamento(array $valores, $where)
    {
        $this->update($this->table, $valores, $where);
    }

    public function deleteAgendamento($coluna, $valor)
    {
        $this->delete($this->table, $coluna, $valor);
    }

    public function selectAgendamento($id): array
    {
        $sql = "SELECT agendamento.*, servicos.titulo AS nome_servico, clientes.nome AS nome_cliente,
        clientes.telefone AS telefone_cliente, usuarios.nome AS nome_barbeiro FROM agendamento 
        INNER JOIN clientes ON agendamento.id_cliente = clientes.id
        INNER JOIN servicos ON agendamento.servico_id = servicos.id 
        INNER JOIN usuarios ON agendamento.barbeiro_id = usuarios.id
        WHERE agendamento.id = :id ";
        $stmt = $this->querySelect($sql, array(':id' => $id));
        return $stmt;
    }
    public function selectAgendamentoCliente($id_cliente): array
    {
        $sql = "SELECT agendamento.*, servicos.titulo AS nome_servico,
         usuarios.nome AS nome_barbeiro FROM agendamento 
        INNER JOIN servicos ON agendamento.servico_id = servicos.id 
        INNER JOIN usuarios ON agendamento.barbeiro_id = usuarios.id
        WHERE agendamento.id_cliente = :id_cliente ";
        $stmt = $this->querySelect($sql, array(':id_cliente' => $id_cliente));
        return $stmt;
    }

    function selectAgendamentoData($data, $barbeiroId): array
    {
        $sql = "SELECT agendamento.*, servicos.titulo AS nome_servico, clientes.nome AS nome_cliente, clientes.telefone AS telefone_cliente FROM agendamento 
        INNER JOIN clientes ON agendamento.id_cliente = clientes.id
        INNER JOIN servicos ON agendamento.servico_id = servicos.id 
        WHERE DATE(agendamento.data_agendamento) = :data 
        AND agendamento.barbeiro_id = :barbeiroId";
        $stmt = $this->querySelect($sql, array(':data' => $data, ':barbeiroId'=> $barbeiroId));
        return $stmt;

    }
	function selectAgendamentos($campos, $where):array
		{
			return $this->select($this->table, $campos, $where);
		}
	function selectAgendamentoVerificar($data, $barbeiro_id): array
		{
			$sql = "SELECT * FROM agendamento WHERE data_agendamento = :data AND barbeiro_id = :barbeiro_id";
			$stmt = $this->querySelect($sql, array(':data' => $data, ':barbeiro_id' => $barbeiro_id));
			return $stmt;
		}
		
	function getAgendamentoById($id)
		{
		
			$sql = "SELECT * FROM ".$this->table." WHERE id = :id";
			$stmt = $this->querySelect($sql, array(':id' => $id));
			return $stmt;
		}

    function getAgendamentosByDataHora($dataHora)
		{
			$sql = "SELECT * FROM ".$this->table." WHERE data_agendamento IN (:data, :proxima_data)";
			$stmt = $this->querySelect($sql, array(':data' => $dataHora, ':proxima_data' => date('Y-m-d H:i', strtotime('+30 minutes', strtotime($dataHora)))));
			return $stmt;
		}


	
	
}