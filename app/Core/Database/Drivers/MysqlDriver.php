<?php
namespace Almhdy\Simy\Core\Database\Drivers;

use PDO;
use PDOException;
use Exception;

class MysqlDriver implements DatabaseDriverInterface
{
  public $connection;

  /**
   * Establishes a connection to the MySQL database.
   *
   * @param array $config An array containing database connection details (host, port, database, username, password).
   * @return bool True if the connection is successful, false otherwise.
   */
  public function connect(array $config): bool
  {
    $host = $config["host"];
    $port = $config["port"];
    $database = $config["database"];
    $username = $config["username"];
    $password = $config["password"];

    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

    try {
      $this->connection = new \PDO($dsn, $username, $password);
      $this->connection->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
      );
      return true;
    } catch (PDOException $e) {
      // Handle connection error, e.g., log error, throw custom exception, etc.
      return false;
    }
  }

  /**
   * Closes the database connection.
   */
  public function disconnect(): void
  {
    $this->connection = null;
  }
}
