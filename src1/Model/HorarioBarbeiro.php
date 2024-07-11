<?php 
namespace App\Model;

use App\Model\Model;

class HorarioBarbeiro extends Model {
	
	private $table = "horarios_trabalho";
	protected $fields = [
		"id",
		"id_barbeiro",
		"dia_semana",
		"turno1",
		"turno2",
		"horas"
	];

	public function insertHorarioBarbeiro($campos) {
        $sql = "INSERT INTO $this->table (id_barbeiro, dia_semana, turno1, turno2) 
                VALUES (:id_barbeiro, :dia_semana, :turno1, :turno2)";
        
        $params = [
            ':id_barbeiro' => $campos['id_barbeiro'],
            ':dia_semana' => $campos['dia_semana'],
            ':turno1' => $campos['turno1'],
            ':turno2' => $campos['turno2']
        ];

        return $this->query($sql, $params);
    }

	function updateHorariosBarbeiro($valores, $where)
	{	

        $this->update($this->table, $valores, $where);
        
	}
	function selectHorarioBarbeiro($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function deleteHorario($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}
	function selectHorariosPageBarbeiro($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function updateHorarioTrabalho($turno1, $turno2, $idBarbeiro, $idHorario)
	{
		$sql = "UPDATE horarios_trabalho
            SET turno1 = :turno1, turno2 = :turno2
            WHERE id_barbeiro = :id_barbeiro AND id = :id";

		$params = [
			':turno1' => $turno1,
			':turno2' => $turno2,
			':id_barbeiro' => $idBarbeiro,
			':id' => $idHorario
		];

		return $this->query($sql, $params);
	}
	
	
function selectHorarioSemanaBarbeiro($coluna, $idBarbeiro)
	{
		$sql = "SELECT turno1, turno2 FROM horarios_trabalho WHERE dia_semana = '".$coluna."' AND id_barbeiro = '".$idBarbeiro."'";

		return $this->querySelect($sql);
	}
	
}