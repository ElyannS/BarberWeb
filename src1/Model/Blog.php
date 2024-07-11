<?php 
namespace App\Model;

use App\Model\Model;

class Blog extends Model {
	
	private $table = "blogs";
	protected $fields = [
		"id",
		"titulo",
		"url_amigavel",
		"autor",
		"descricao",
		"imagem_principal",
        "data_cadastro",
        "status"
	];

	function insertBlog($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateBlog($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteBlog($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectBlog($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectBlogsPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	
	function selectBlogsPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
}