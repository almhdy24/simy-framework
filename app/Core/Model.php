<?php
namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Database\Query;
use Almhdy\Simy\Core\Database\Connection;

class Model
{
  protected $query; // Instance of Query class for database operations
  protected $table; // Name of the database table
  protected $data = []; // Data array to store object properties
  /**
   * Constructor to initialize the Model with a Query instance
   */
  public function __construct()
  {
    // Instantiate a Query object with a new Connection
    $this->query = new Query(new Connection());
  }
  /**
   * Magic method to set object properties directly
   */
  public function __set($name, $value)
  {
    $this->data[$name] = $value;
  }

  /**
   * Magic method to get object properties directly
   */
  public function __get($name)
  {
    return $this->data[$name] ?? null;
  }

  /**
   * Retrieve all records from the specified table
   * @return array All records from the table
   */
  public function all()
  {
    return $this->query->selectAll($this->table);
  }

  /**
   * Find a record by ID from the specified table
   * @param int $id The ID of the record to find
   * @return array The record found by ID
   */
  public function find($id)
  {
    return $this->query->selectOne($this->table, $id);
  }

 /**
     * Save a record - update if ID exists, insert if not
     * @return mixed Result of the save operation
     */
    public function save()
    {
        if (isset($this->data["id"])) {
            $id = $this->data["id"];
            unset($this->data["id"]);
            return $this->query->update($this->table, $this->data, $id);
        } else {
            return $this->query->insert($this->table, $this->data);
        }
    }

  /**
   * Delete a record by ID from the specified table
   * @param int $id The ID of the record to delete
   * @return mixed Result of the delete operation
   */
  public function delete($id)
  {
    return $this->query->delete($this->table, $id);
  }

  /**
   * Filter records based on a WHERE condition
   * @param array $where The WHERE condition for filtering records
   * @return array Filtered records based on the WHERE condition
   */
  public function where($where)
  {
    return $this->query->where($this->table, $where);
  }
  // Method to execute a user-provided custom SQL query
  public function customQuery($sqlQuery)
  {
    return $this->query->customQuery($sqlQuery);
  }
}
