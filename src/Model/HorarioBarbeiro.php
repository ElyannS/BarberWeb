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

	function insertHorario($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateHorariosBarbeiro($valores, $where, $idBarbeiro)
	{	
		$where['id_barbeiro'] = $idBarbeiro;

        $this->updates($this->table, $valores, $where);
        
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
	
	function selectHorarioSemana($coluna)
	{
		$sql = "SELECT turno1, turno2 FROM horarios_trabalho WHERE dia_semana = '".$coluna."'";

		return $this->querySelect($sql);
	}
	
}