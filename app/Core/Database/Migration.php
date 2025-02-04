<?php

namespace Almhdy\Simy\Core\Database;

use Almhdy\Simy\Core\Config;

class Migration
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = Connection::getInstance()->getDriver()->connection;
  }

  public function createMigrationTable(): void
  {
    $sql = "CREATE TABLE IF NOT EXISTS migrations (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    migration TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
    $this->pdo->exec($sql);
  }

  public function getAppliedMigrations(): array
  {
    $this->createMigrationTable();
    $stmt = $this->pdo->query("SELECT migration FROM migrations");
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
  }

  public function applyMigration(string $migration): void
  {
    $path = dirname(Config::BASE_DIR) . "/Migrations/" . $migration;
    echo "Reading migration file: $path\n";
    $sql = file_get_contents($path);
    if ($sql === false) {
      echo "Failed to read migration file: $path\n";
      return;
    }
    echo "Executing migration SQL: \n$sql\n";
    $this->pdo->exec($sql);
    $stmt = $this->pdo->prepare(
      "INSERT INTO migrations (migration) VALUES (:migration)"
    );
    $stmt->bindParam(":migration", $migration);
    $stmt->execute();
    echo "Migration applied and recorded: $migration\n";
  }

  public function removeMigration(string $migration): void
  {
    $stmt = $this->pdo->prepare(
      "DELETE FROM migrations WHERE migration = :migration"
    );
    $stmt->bindParam(":migration", $migration);
    $stmt->execute();
  }
}
