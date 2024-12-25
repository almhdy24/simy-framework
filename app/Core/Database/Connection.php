<?php
namespace Almhdy\Simy\Core\Database;

use Almhdy\Simy\Core\Database\Drivers\MysqlDriver;
use Almhdy\Simy\Core\Database\Drivers\SqliteDriver;
use Almhdy\Simy\Core\Database\Drivers\PostgresDriver;

class Connection
{
    private static $instance;
    private $driver;

    private function __construct()
    {
        $driver = $_ENV["DB_CONNECTION"] ?? null;

        if (!$driver) {
            throw new \Exception("Database driver not specified in environment variables.");
        }

        switch ($driver) {
            case "mysql":
                $this->driver = $this->connectMysql();
                break;
            case "sqlite":
                $this->driver = $this->connectSqlite();
                break;
            case "postgres":
                $this->driver = $this->connectPostgres();
                break;
            default:
                throw new \Exception("Unsupported database driver: " . $driver);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connectMysql()
    {
        $dbConfig = [
            "host" => $_ENV["DB_HOST"],
            "port" => $_ENV["DB_PORT"],
            "database" => $_ENV["DB_DATABASE"],
            "username" => $_ENV["DB_USERNAME"],
            "password" => $_ENV["DB_PASSWORD"],
        ];

        return $this->connectWithDriver(new MysqlDriver(), $dbConfig);
    }

    private function connectSqlite()
    {
        $dbConfig = [
            "path" => $_ENV["DB_DATABASE"],
        ];

        return $this->connectWithDriver(new SqliteDriver(), $dbConfig);
    }

    private function connectPostgres()
    {
        $dbConfig = [
            "host" => $_ENV["DB_HOST"],
            "dbname" => $_ENV["DB_DATABASE"],
            "username" => $_ENV["DB_USERNAME"],
            "password" => $_ENV["DB_PASSWORD"],
        ];

        return $this->connectWithDriver(new PostgresDriver(), $dbConfig);
    }

    private function connectWithDriver($driver, $dbConfig)
    {
        try {
            $driver->connect($dbConfig);
            return $driver;
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getDriver()
    {
        return $this->driver;
    }
}