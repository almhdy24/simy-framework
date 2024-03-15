<?php

namespace Almhdy\Simy\Core\Database;

use Almhdy\Simy\Core\Database\Connection;

class Query
{
	protected $connection;
	public function __construct($connection)
	{
		$this->connection = $connection->connect()->connection;
	}

	public function selectAll($table)
	{
		$query = $this->connection->prepare("SELECT * FROM $table");
		$query->execute();
		return $query->fetchAll();
	}

	public function selectOne($table, $id)
	{
		$query = $this->connection->prepare("SELECT * FROM $table WHERE id = ?");
		$parameters = [$id];
		$query->execute($parameters);
		return $query->fetchAll();
	}

	public function execute($query, $params)
	{
		return $this->connection->execute($query, $params);
	}

	public function insert($table, $data)
	{
		$columns = implode(", ", array_keys($data));
		$values = ":" . implode(", :", array_keys($data));
		$query = $this->connection->prepare("INSERT INTO $table ($columns) VALUES
		($values)");
		$query->execute();
		return $data;
	}

	public function update($table, $data, $id)
	{
		$setClauses = [];
		foreach ($data as $column => $value) {
			$setClauses[] = "$column = :$column";
		}
		$setClauses = implode(", ", $setClauses);
		$query = $this->connection
			->prepare("UPDATE $table SET $setClauses WHERE id =
		:id");
		$data["id"] = $id;
		$query->execute($data);
		return $data;
	}
	public function delete($table, $id)
	{
		$query = "DELETE FROM " . $table . " WHERE id = :id";

		// Bind the ID value using parameterized query
		$params = [":id" => $id];

		// Execute the delete query with the provided ID
		$result = $this->connection->prepare($query);
		$result->execute($params);

		// Return true if the delete operation was successful, false otherwise
		return $result->rowCount() > 0;
	}
}
