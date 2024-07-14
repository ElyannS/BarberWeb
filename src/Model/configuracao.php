<?php 
namespace App\Model;

use App\Model\Model;

class Configuracao extends Model {
	
	private $table = "configuracoes";
	protected $fields = [
		"id",
		"nome",
		"valor",
		"dataLibera",
		"data_cadastro"
	];

	function insertConfiguracao($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateConfiguracao($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteConfiguracao($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectConfiguracao($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function getConfig($campos)
	{
		return $this->select($this->table, ['valor'], array('nome' => $campos))[0]['valor'];
	}
}