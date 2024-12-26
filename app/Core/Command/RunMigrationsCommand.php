<?php

namespace Almhdy\Simy\Core\Command;

use Almhdy\Simy\Core\Config;
use Almhdy\Simy\Core\Database\Migration;

class RunMigrationsCommand
{
  public function __invoke(array $arguments): void
  {
    $migration = new Migration();
    $appliedMigrations = $migration->getAppliedMigrations();

    // Define the migrations directory using the Config class
    $migrationsDir = Config::BASE_DIR . "/Migrations";

    // Ensure the migrations directory path is correct
    $migrationsDir = realpath($migrationsDir) ?: $migrationsDir;

    if (!is_dir($migrationsDir)) {
      mkdir($migrationsDir, 0777, true);
      echo "Created migrations directory: $migrationsDir\n";
    }

    // Scan the migrations directory
    $migrations = scandir($migrationsDir);

    // Debugging: Output the contents of the migrations directory
    if ($migrations === false) {
      echo "Failed to open migrations directory: $migrationsDir\n";
      return;
    }

   

    // Filter out the current and parent directory entries
    $migrations = array_diff($migrations, [".", ".."]);

    foreach ($migrations as $migrationFile) {
      // Debugging: Output the migration file being processed
      echo "Processing migration file: $migrationFile\n";

      if (!in_array($migrationFile, $appliedMigrations)) {
        echo "Applying migration: $migrationFile\n";
        $migration->applyMigration($migrationFile);
        echo "Applied migration: $migrationFile\n";
      } else {
        echo "Migration already applied: $migrationFile\n";
      }
    }
  }
}
