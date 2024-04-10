<?php 
namespace App\Model;

use App\Model\Model;

class Horario extends Model {
	
	private $table = "horarios";
	protected $fields = [
		"id",
		"dia_semana",
		"turno1",
		"turno2",
		"horas"
	];

	function insertHorario($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateHorario($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteHorario($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectHorario($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}

	function selectHorariosPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectHorarioSemana($coluna)
	{
		$sql = "SELECT turno1, turno2 FROM horarios WHERE dia_semana = '".$coluna."'";

		return $this->querySelect($sql);
	}
	
}