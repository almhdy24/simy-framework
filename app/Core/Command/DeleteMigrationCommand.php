<?php

namespace Almhdy\Simy\Core\Command;

use Almhdy\Simy\Core\Config;
use Almhdy\Simy\Core\Database\Migration;

class DeleteMigrationCommand
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
    }
}