<?php
namespace Almhdy\Simy\Core\Database\Drivers;

use PDO;
use PDOException;

class MysqlDriver implements DatabaseDriverInterface
{
    public $connection;

    public function connect(array $config): bool
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $config['host'],
            $config['port'],
            $config['database']
        );

        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function disconnect(): void
    {
        $this->connection = null;
    }
}