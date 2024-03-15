<?php
namespace Drivers;

use Core\Database\Drivers\DatabaseDriverInterface;

class PostgresDriver implements DatabaseDriverInterface
{
	/**
	 * @var \PDO|null The PDO object representing the Postgres database connection.
	 */
	private $connection;

	/**
	 * Establishes a connection to the Postgres database.
	 *
	 * @param array $config An array containing connection parameters such as host, dbname, user, and password.
	 * @return bool True if the connection is successful, false otherwise.
	 * @throws \Exception If the connection to the Postgres database cannot be established.
	 */
	public function connect(array $config): bool
	{
		// Extract the configuration parameters
		$host = $config["host"];
		$dbname = $config["dbname"];
		$user = $config["user"];
		$password = $config["password"];

		// Build the DSN for the Postgres connection
		$dsn = "pgsql:host=$host;dbname=$dbname;user=$user;password=$password";

		try {
			// Attempt to establish the Postgres connection
			$pdo = new \PDO($dsn);
			$this->connection = $pdo;
			return true;
		} catch (\PDOException $e) {
			// Handle any connection errors
			throw new \Exception("Postgres connection error: " . $e->getMessage());
		}
	}

	/**
	 * Closes the connection to the Postgres database.
	 */
	public function disconnect(): void
	{
		$this->connection = null;
	}
}
