<?php

namespace Almhdy\Simy\Core\Command;

use Almhdy\Simy\Core\Database\Migration;

class MigrateFreshCommand
{
    public function __invoke(array $arguments): void
    {
        $migration = new Migration();
        $appliedMigrations = $migration->getAppliedMigrations();

        foreach ($appliedMigrations as $migrationFile) {
            echo "Removing migration: $migrationFile\n";
            $migration->removeMigration($migrationFile);
            echo "Removed migration: $migrationFile\n";
        }

$migrationsDir = __DIR__ . "/../../../migrations";
        $migrations = array_diff(scandir($migrationsDir), ['.', '..']);

        foreach ($migrations as $migrationFile) {
            echo "Applying migration: $migrationFile\n";
            $migration->applyMigration($migrationFile);
            echo "Applied migration: $migrationFile\n";
        }
    }
}