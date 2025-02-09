<?php
namespace Almhdy\Simy\Core\Database\Drivers;

use Almhdy\Simy\Core\Config;
use PDO;
use PDOException;
use Exception;

/**
 * This class provides an SQLite database driver implementation
 */
class SqliteDriver implements DatabaseDriverInterface
{
  /**
   * Holds the PDO connection instance
   * @var PDO|null
   */
  public $connection;

  /**
   * Connects to the SQLite database using the provided configuration
   *
   * @param array $config An associative array containing the database configuration.
   *                      In this case, it should contain the 'path' key specifying the path to the SQLite database file.
   * @throws Exception if the connection to the database fails
   */
  public function connect(array $config): bool
  {
    // Extract the configuration parameters
    $path = basename($config["path"]);
    $path = dirname(Config::BASE_DIR ). "/Writable/Database/" . $path;

    // Ensure the directory exists and is writable
    if (!file_exists($path)) {
      throw new Exception("SQLite database file does not exist: $path");
    }

    // Build the DSN for the SQLite connection
    $dsn = "sqlite:" . $path;

    try {
      // Attempt to establish the SQLite connection
      $this->connection = new PDO($dsn);
      $this->connection->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
      );
      return true;
    } catch (PDOException $e) {
      // Handle any connection errors
      throw new Exception("SQLite connection error: " . $e->getMessage());
    }
  }

  /**
   * Closes the connection to the SQLite database.
   */
  public function disconnect(): void
  {
    $this->connection = null;
  }
  public function prepare($query)
  {
    return $this->connection->prepare($query);
  }
}
