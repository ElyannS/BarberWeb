<?php 
namespace App\Model;

use App\Model\Model;

class Usuario extends Model {
	
	private $table = "usuarios";
	protected $fields = [
		"id",
		"nome",
		"email",
		"foto_usuario",
		"senha",
		"type"
	];

	function insertUsuario($campos)
	{
		$this->insert($this->table, $campos);
	}

	function updateUsuario($valores, $where)
	{	
		$this->update($this->table, $valores, $where);
	}

	function deleteUsuario($coluna, $valor)
	{
		$this->delete($this->table, $coluna, $valor);
	}

	function selectUsuario($campos, $where):array
	{
		return $this->select($this->table, $campos, $where);
	}
	function selectUsuariosPage($limit, $offset)
	{
		$sql = "SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}
	function selectUsuariosPesquisa($pesquisa)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE titulo LIKE '%".$pesquisa."%' ORDER BY id DESC";

		return $this->querySelect($sql);
	}
	
	public static function verificarLogin() 
	{
		if (!isset($_SESSION)) {
			session_start();
		}
		if (!isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === NULL) {
			header("Location: ".URL_BASE."admin-login");
			exit();
		}
	}
}