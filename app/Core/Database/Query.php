<?php

namespace Almhdy\Simy\Core\Database;

use Almhdy\Simy\Core\Database\Connection;
use \PDO;

class Query
{
  protected $connection;

  /**
   * Constructor to initialize the database connection
   * @param object $connection An object containing the database connection
   */
  public function __construct($connection)
  {
    // Initialize the class property with the database connection
    $this->connection = $connection->connect()->connection;
    
  }

  /**
   * Selects all rows from the specified table
   * @param string $table The name of the table to select from
   * @return array An array containing all rows from the table
   */
  public function selectAll($table)
  {
    // Prepare and execute a query to select all rows
    $query = $this->connection->prepare("SELECT * FROM $table");
    $query->execute();

    // Return all fetched rows
    return $query->fetchAll();
  }

  /**
   * Selects a single row based on the ID from the specified table
   * @param string $table The name of the table to select from
   * @param int $id The ID of the row to retrieve
   * @return array An array containing the selected row data
   */
  public function selectOne($table, $id)
  {
    // Prepare and execute a query to select a single row based on ID
    $query = $this->connection->prepare("SELECT * FROM $table WHERE id = ?");
    $parameters = [$id];
    $query->execute($parameters);

    // Return the fetched row (or null if not found)
    return $query->fetch();
  }

  /**
   * Executes a custom query with parameters
   * @param string $query The custom query to execute
   * @param array $params An array of parameters to bind to the query
   * @return mixed The result of the executed query
   */
  public function execute($query, $params)
  {
    // Execute the custom query with the provided parameters
    return $this->connection->execute($query, $params);
  }
  /**
   * Inserts a new row into the specified table with the provided data
   * @param string $table The name of the table to insert into
   * @param array $data An associative array containing column-value pairs for insertion
   * @return array The inserted data
   */
  public function insert($table, $data)
  {
    // Extract columns and values from the provided data
    $columns = implode(", ", array_keys($data));
    $values = ":" . implode(", :", array_keys($data));

    // Construct the INSERT query with placeholders for values
    $query = $this->connection->prepare(
      "INSERT INTO $table ($columns) VALUES ($values)"
    );

    // Bind values to the prepared statement
    foreach ($data as $key => $value) {
      $query->bindValue(":$key", $value);
    }

    // Execute the query to insert the data
    $query->execute();

    // Return the inserted data
    return $data;
  }

  /**
   * Updates the row in the specified table with the provided data based on the ID
   * @param string $table The name of the table to update
   * @param array $data An associative array containing column-value pairs for update
   * @param int $id The ID of the row to be updated
   * @return array The updated data
   */
  public function update($table, $data, $id)
  {
    // Construct the SET clauses for the update query based on the provided data
    $setClauses = [];
    foreach ($data as $column => $value) {
      $setClauses[] = "$column = :$column";
    }
    $setClauses = implode(", ", $setClauses);

    // Append the ID to the data array to update a specific row
    $data["id"] = $id;

    // Prepare the UPDATE query with SET clauses and WHERE condition
    $query = $this->connection->prepare(
      "UPDATE $table SET $setClauses WHERE id = :id"
    );

    // Execute the update query with the data values
    $query->execute($data);

    // Return the updated data
    return $data;
  }
  /**
   * Deletes a row from the specified table based on the provided ID
   * @param string $table The name of the table to delete from
   * @param int $id The ID of the row to be deleted
   * @return bool True if the delete operation was successful, false otherwise
   */
  public function delete($table, $id)
  {
    // Construct the DELETE query with the WHERE clause based on the ID
    $query = "DELETE FROM " . $table . " WHERE id = :id";

    // Define the parameters to bind, in this case, only the ID
    $params = [":id" => $id];

    // Prepare and execute the delete query with the specified ID
    $result = $this->connection->prepare($query);
    $result->execute($params);

    // Check if rows were affected by the delete operation and return true if any row was deleted
    return $result->rowCount() > 0;
  }
  /**
   * Retrieves data from a table based on the specified conditions using a WHERE clause
   * @param string $table The name of the table to query
   * @param array $where An associative array of conditions for the WHERE clause
   * @return array The result set matching the WHERE conditions
   */
  public function where($table, $where)
  {
    // Initialize an empty array to store WHERE conditions
    $wheres = [];

    // Construct the WHERE clause based on the key-value pairs in the $where array
    foreach ($where as $key => $value) {
      $wheres[] = "$key = :$key";
    }

    // Join the individual WHERE conditions with 'AND' to form the complete WHERE clause
    $whereClause = implode(" AND ", $wheres);

    // Prepare the SELECT query with the WHERE clause
    $query = $this->connection->prepare(
      "SELECT * FROM $table WHERE $whereClause"
    );

    // Bind values to the prepared statement for each condition in the $where array
    foreach ($where as $key => $value) {
      $query->bindValue(":$key", $value);
    }

    // Execute the SELECT query
    $query->execute();

    // Fetch all rows as an associative array
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Return the result set matching the WHERE conditions
    return $result;
  }
  // Method to perform INNER JOIN between two tables
  public function innerJoinTables($mainTable, $secondaryTable, $joinCondition)
  {
    // Construct the SQL query with the INNER JOIN operation
    $query = $this->connection->prepare(
      "SELECT * FROM $mainTable INNER JOIN $secondaryTable ON $joinCondition"
    );

    // Execute the query
    $query->execute();

    // Return the result of the INNER JOIN operation
    return $query->fetchAll();
  }
  // Method to perform LEFT JOIN between two tables
  public function leftJoinTables($mainTable, $secondaryTable, $joinCondition)
  {
    // Construct the SQL query with the LEFT JOIN operation
    $query = $this->connection->prepare(
      "SELECT * FROM $mainTable LEFT JOIN $secondaryTable ON $joinCondition"
    );

    // Execute the query
    $query->execute();

    // Return the result of the LEFT JOIN operation
    return $query->fetchAll();
  }

  // Method to perform RIGHT JOIN between two tables
  public function rightJoinTables($mainTable, $secondaryTable, $joinCondition)
  {
    // Construct the SQL query with the RIGHT JOIN operation
    $query = $this->connection->prepare(
      "SELECT * FROM $mainTable RIGHT JOIN $secondaryTable ON $joinCondition"
    );

    // Execute the query
    $query->execute();

    // Return the result of the RIGHT JOIN operation
    return $query->fetchAll();
  }
  // Method to perform OUTER JOIN between two tables
  public function outerJoinTables($mainTable, $secondaryTable, $joinCondition)
  {
    // Construct the SQL query with the FULL OUTER JOIN operation (Note: FULL OUTER JOIN is not directly supported in MySQL)
    $query = $this->connection->prepare(
      "SELECT * FROM $mainTable LEFT JOIN $secondaryTable ON $joinCondition UNION SELECT * FROM $mainTable RIGHT JOIN $secondaryTable ON $joinCondition"
    );

    // Execute the query
    $query->execute();

    // Return the result of the OUTER JOIN operation
    return $query->fetchAll();
  }
  // Method to execute a user-provided custom SQL query
  public function customQuery($sqlQuery)
  {
    try {
      // Prepare the user-provided custom SQL query
      $query = $this->connection->prepare($sqlQuery);

      // Execute the query
      $query->execute();

      // Return the result of the custom SQL query
      return $query->fetchAll();
    } catch (PDOException $e) {
      // Handle any exceptions that occur during query execution
      echo "Error executing custom query: " . $e->getMessage();
      return false;
    }
  }
}
