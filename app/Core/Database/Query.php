<?php

namespace Almhdy\Simy\Core\Database;

use PDO;
use PDOException;

class Query
{
  protected $connection;
  protected $table;
  protected $select = "*";
  protected $where = [];
  protected $orderBy = "";
  protected $limit = "";
  protected $bindings = [];

  /**
   * Constructor to initialize the database connection
   * @param object $connection An object containing the database connection
   */
  public function __construct(Connection $connection)
  {
    $this->connection = $connection->getDriver(); // Get the driver from the connection
  }

  /**
   * Set the table for the query
   * @param string $table The name of the table
   * @return $this
   */
  public function table(string $table)
  {
    $this->table = $table;
    return $this;
  }

  /**
   * Set the columns to select
   * @param string|array $columns The columns to select
   * @return $this
   */
  public function select($columns = "*")
  {
    if (is_array($columns)) {
      $columns = implode(", ", $columns);
    }
    $this->select = $columns;
    return $this;
  }

  /**
   * Add a where clause to the query
   * @param string $column The column for the condition
   * @param string $operator The operator for the condition
   * @param mixed $value The value for the condition
   * @return $this
   */
  public function where(string $column, string $operator, $value)
  {
    $this->where[] = "$column $operator :$column";
    $this->bindings[":$column"] = $value;
    return $this;
  }

  /**
   * Add an order by clause to the query
   * @param string $column The column to order by
   * @param string $direction The direction of the order (ASC or DESC)
   * @return $this
   */
  public function orderBy(string $column, string $direction = "ASC")
  {
    $this->orderBy = "ORDER BY $column $direction";
    return $this;
  }

  /**
   * Add a limit clause to the query
   * @param int $limit The number of records to limit
   * @return $this
   */
  public function limit(int $limit)
  {
    $this->limit = "LIMIT $limit";
    return $this;
  }

  /**
   * Execute the select query
   * @return array The result set of the query
   */
  public function get()
  {
    $sql = "SELECT $this->select FROM $this->table";
    if (!empty($this->where)) {
      $sql .= " WHERE " . implode(" AND ", $this->where);
    }
    if (!empty($this->orderBy)) {
      $sql .= " $this->orderBy";
    }
    if (!empty($this->limit)) {
      $sql .= " $this->limit";
    }

    try {
      $query = $this->connection->prepare($sql);
      $query->execute($this->bindings);
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException("Error executing query: " . $e->getMessage());
    }
  }

  /**
   * Insert a new row into the specified table with the provided data
   * @param string $table The name of the table to insert into
   * @param array $data An associative array containing column-value pairs for insertion
   * @return array The inserted data
   */
  public function insert($table, $data)
  {
    $columns = implode(", ", array_keys($data));
    $values = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    try {
      $query = $this->connection->prepare($sql);
      foreach ($data as $key => $value) {
        $query->bindValue(":$key", $value);
      }
      $query->execute();
      return $data;
    } catch (PDOException $e) {
      throw new PDOException("Error inserting data: " . $e->getMessage());
    }
  }

  /**
   * Update the row in the specified table with the provided data based on the ID
   * @param string $table The name of the table to update
   * @param array $data An associative array containing column-value pairs for update
   * @param int $id The ID of the row to be updated
   * @return array The updated data
   */
  public function update($table, $data, $id)
  {
    $setClauses = [];
    foreach ($data as $column => $value) {
      $setClauses[] = "$column = :$column";
    }
    $setClauses = implode(", ", $setClauses);
    $data["id"] = $id;

    $sql = "UPDATE $table SET $setClauses WHERE id = :id";

    try {
      $query = $this->connection->prepare($sql);
      $query->execute($data);
      return $data;
    } catch (PDOException $e) {
      throw new PDOException("Error updating data: " . $e->getMessage());
    }
  }

  /**
   * Deletes a row from the specified table based on the provided ID
   * @param string $table The name of the table to delete from
   * @param int $id The ID of the row to be deleted
   * @return bool True if the delete operation was successful, false otherwise
   */
  public function delete($table, $id)
  {
    $sql = "DELETE FROM $table WHERE id = :id";
    $params = [":id" => $id];

    try {
      $query = $this->connection->prepare($sql);
      $query->execute($params);
      return $query->rowCount() > 0;
    } catch (PDOException $e) {
      throw new PDOException("Error deleting data: " . $e->getMessage());
    }
  }

  /**
   * Executes a custom query with parameters
   * @param string $query The custom query to execute
   * @param array $params An array of parameters to bind to the query
   * @return mixed The result of the executed query
   */
  public function execute($query, $params = [])
  {
    try {
      $stmt = $this->connection->prepare($query);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException(
        "Error executing custom query: " . $e->getMessage()
      );
    }
  }

  /**
   * Method to perform INNER JOIN between two tables
   * @param string $mainTable The primary table
   * @param string $secondaryTable The table to join
   * @param string $joinCondition The condition on which to join
   * @return array The result set of the join operation
   */
  public function innerJoin($mainTable, $secondaryTable, $joinCondition)
  {
    $sql = "SELECT * FROM $mainTable INNER JOIN $secondaryTable ON $joinCondition";

    try {
      $query = $this->connection->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException("Error executing inner join: " . $e->getMessage());
    }
  }

  /**
   * Method to perform LEFT JOIN between two tables
   * @param string $mainTable The primary table
   * @param string $secondaryTable The table to join
   * @param string $joinCondition The condition on which to join
   * @return array The result set of the join operation
   */
  public function leftJoin($mainTable, $secondaryTable, $joinCondition)
  {
    $sql = "SELECT * FROM $mainTable LEFT JOIN $secondaryTable ON $joinCondition";

    try {
      $query = $this->connection->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException("Error executing left join: " . $e->getMessage());
    }
  }

  /**
   * Method to perform RIGHT JOIN between two tables
   * @param string $mainTable The primary table
   * @param string $secondaryTable The table to join
   * @param string $joinCondition The condition on which to join
   * @return array The result set of the join operation
   */
  public function rightJoin($mainTable, $secondaryTable, $joinCondition)
  {
    $sql = "SELECT * FROM $mainTable RIGHT JOIN $secondaryTable ON $joinCondition";

    try {
      $query = $this->connection->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException("Error executing right join: " . $e->getMessage());
    }
  }

  /**
   * Method to perform OUTER JOIN between two tables
   * @param string $mainTable The primary table
   * @param string $secondaryTable The table to join
   * @param string $joinCondition The condition on which to join
   * @return array The result set of the join operation
   */
  public function outerJoin($mainTable, $secondaryTable, $joinCondition)
  {
    $sql = "SELECT * FROM $mainTable LEFT JOIN $secondaryTable ON $joinCondition UNION SELECT * FROM $mainTable RIGHT JOIN $secondaryTable ON $joinCondition";

    try {
      $query = $this->connection->prepare($sql);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException("Error executing outer join: " . $e->getMessage());
    }
  }

  /**
   * Method to execute a user-provided custom SQL query
   * @param string $sqlQuery The custom SQL query
   * @return mixed The result of the executed query
   */
  public function customQuery($sqlQuery)
  {
    try {
      $query = $this->connection->prepare($sqlQuery);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new PDOException(
        "Error executing custom query: " . $e->getMessage()
      );
    }
  }
}
