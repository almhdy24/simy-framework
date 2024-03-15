<?php
namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Database\Query;
use Almhdy\Simy\Core\Database\Connection;

class Model
{
	protected $query;
	protected $table;

	public function __construct()
	{
		$this->query = new Query(new Connection);
	}

	public function all()
	{
		return $this->query->selectAll($this->table);
	}

	public function find($id)
	{
		return $this->query->selectOne($this->table, $id);
	}

	public function save($data)
	{
		if (isset($data["id"])) {
			$id = $data["id"];
			unset($data["id"]);
			return $this->query->update($this->table, $data, $id);
		} else {
			return $this->query->insert($this->table, $data);
		}
	}

	public function delete($id)
	{
		return $this->query->delete($this->table, $id);
	}
}
