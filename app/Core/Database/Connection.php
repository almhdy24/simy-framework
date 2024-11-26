<?php
namespace Almhdy\Simy\Core\Database;

use Almhdy\Simy\Core\Database\Drivers\MysqlDriver;
use Almhdy\Simy\Core\Database\Drivers\SqliteDriver;
use Almhdy\Simy\Core\Database\Drivers\PostgresDriver;

class Connection
{
	public function connect()
	{
		$driver = $_ENV["DB_CONNECTION"];

		switch ($driver) {
			case "mysql":
				return $this->connectMysql();
				break;
			case "sqlite":
				return $this->connectSqlite();
				break;
			case "postgres":
				return $this->connectPostgres();
				break;
			default:
				throw new \Exception("Unsupported database driver: " . $driver);
		}
	}

	private function connectMysql()
	{
		$dbHost = $_ENV["DB_HOST"];
		$dbPort = $_ENV["DB_PORT"];
		$dbName = $_ENV["DB_DATABASE"];
		$dbUser = $_ENV["DB_USERNAME"];
		$dbPass = $_ENV["DB_PASSWORD"];

		$dbConfig = [
			"host" => $dbHost,
			"port" => $dbPort,
			"database" => $dbName,
			"username" => $dbUser,
			"password" => $dbPass,
		];

		return $this->connectWithDriver(new MysqlDriver(), $dbConfig);
	}

	private function connectSqlite()
	{
		$dbPath = $_ENV["DB_DATABASE"]; // Assuming SQLite database file path is defined in the .env file

		$dbConfig = [
			"path" => $dbPath,
		];

		return $this->connectWithDriver(new SqliteDriver(), $dbConfig);
	}

	private function connectPostgres()
	{
		$dbHost = $_ENV["DB_HOST"];
		$dbName = $_ENV["DB_DATABASE"];
		$dbUser = $_ENV["DB_USERNAME"];
		$dbPass = $_ENV["DB_PASSWORD"];

		$dbConfig = [
			"host" => $dbHost,
			"dbname" => $dbName,
			"username" => $dbUser,
			"password" => $dbPass,
		];

		return $this->connectWithDriver(new PostgresDriver(), $dbConfig);
	}
	private function connectWithDriver($driver, $dbConfig)
	{
		try {
			// Attempt to connect using the driver
			$isConnected = $driver->connect($dbConfig);

			if ($isConnected) {
				return $driver; // Return the connected driver for use
			} else {
				throw new \Exception("Failed to connect to the database");
			}
		} catch (\PDOException $e) {
			// Handle connection error
			// Log the error or throw an exception as per your application's error handling strategy
			// For example: logError($e->getMessage()); or throw new \Exception($e->getMessage());
			throw new \Exception($e->getMessage());
		}
	}
}
