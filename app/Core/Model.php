<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Database\Query;
use Almhdy\Simy\Core\Database\Connection;
use PDOException;

class Model
{
  protected $query;
  protected $table;
  protected $data = [];

  public function __construct()
    {
        $connection = Connection::getInstance();
        $this->query = new Query($connection);
    }

  public function __set($name, $value)
  {
    $this->data[$name] = $value;
  }

  public function __get($name)
  {
    return $this->data[$name] ?? null;
  }

  public function all()
  {
    return $this->query->table($this->table)->get();
  }

  public function find($id)
  {
    return $this->query
      ->table($this->table)
      ->where("id", "=", $id)
      ->get();
  }

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

  public function delete($id)
  {
    return $this->query->delete($this->table, $id);
  }

  public function where($conditions)
  {
    foreach ($conditions as $column => $value) {
      $this->query->where($column, "=", $value);
    }
    return $this->query->table($this->table)->get();
  }

  public function customQuery($sqlQuery)
  {
    return $this->query->customQuery($sqlQuery);
  }

  // Advanced Methods

  /**
   * Paginate results
   * @param int $perPage Number of results per page
   * @param int $page Current page number
   * @return array Paginated results
   */
  public function paginate($perPage, $page)
  {
    $offset = ($page - 1) * $perPage;
    return $this->query
      ->table($this->table)
      ->limit($perPage)
      ->offset($offset)
      ->get();
  }

  /**
   * Count records
   * @return int Number of records
   */
  public function count()
  {
    $result = $this->query->customQuery(
      "SELECT COUNT(*) as count FROM {$this->table}"
    );
    return $result[0]["count"];
  }

  /**
   * Sum a column
   * @param string $column The column to sum
   * @return int Sum of the column
   */
  public function sum($column)
  {
    $result = $this->query->customQuery(
      "SELECT SUM($column) as sum FROM {$this->table}"
    );
    return $result[0]["sum"];
  }

  /**
   * Average a column
   * @param string $column The column to average
   * @return float Average of the column
   */
  public function avg($column)
  {
    $result = $this->query->customQuery(
      "SELECT AVG($column) as avg FROM {$this->table}"
    );
    return $result[0]["avg"];
  }

  /**
   * Define a one-to-many relationship
   * @param string $relatedModel The related model class
   * @param string $foreignKey The foreign key in the related model
   * @param string $localKey The local key in the current model
   * @return array Related models
   */
  public function hasMany($relatedModel, $foreignKey, $localKey)
  {
    $related = new $relatedModel();
    return $related->where([$foreignKey => $this->$localKey]);
  }

  /**
   * Define a belongs-to relationship
   * @param string $relatedModel The related model class
   * @param string $foreignKey The foreign key in the current model
   * @param string $ownerKey The key in the related model
   * @return array Related model
   */
  public function belongsTo($relatedModel, $foreignKey, $ownerKey)
  {
    $related = new $relatedModel();
    return $related->where([$ownerKey => $this->$foreignKey]);
  }
}
