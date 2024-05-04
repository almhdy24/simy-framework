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
  public function where($table, $params)
  {
    // Initializing an array to store conditions for the WHERE clause
    $conditions = [];

    // Constructing conditions based on the key-value pairs in $params
    foreach ($params as $key => $value) {
      $conditions[] = "$key = :$key";
    }

    // Combining conditions using 'AND' as the separator
    $conditions = implode(" AND ", $conditions);

    // Preparing a SELECT query with placeholders for conditions
    $query = $this->connection->prepare(
      "SELECT * FROM $table WHERE $conditions"
    );

    // Executing the prepared query with parameter values
    $query->execute($params);

    // Returning all rows fetched by the executed query
    return $query->fetchAll();
  }

  public function customQuery($table, $query)
  {
    // Preparing a custom query provided as input
    $q = $this->connection->prepare($query);

    // Executing the prepared custom query
    $q->execute();

    // Returning all rows fetched by the executed custom query
    return $q->fetchAll();
  }
}
