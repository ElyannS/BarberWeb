<?php 
namespace App\Model;

use App\Model\Model;

class Horario extends Model {
	
	private $table = "horarios";
	protected $fields = [
		"id",
		"domingo",
		"segunda",
        'terca',
		"quarta",
		"quinta",
        "sexta", 
        "sabado",
		"domingo2",
		"segunda2",
        'terca2',
		"quarta2",
		"quinta2",
        "sexta2", 
        "sabado2"
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

	
}