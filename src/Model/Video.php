<?php 
namespace App\Model;

use App\Model\Model;

class Video extends Model {
	
	private $table = "videos";
	protected $fields = [
		"id",
		"titulo",
		"link_video",
		"imagem_principal",
        "data_cadastro",
        "status"
	];

	function insertVideo($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateVideo($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteVideo($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectVideo($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectVideosPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectVideosPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}