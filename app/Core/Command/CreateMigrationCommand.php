<?php

namespace Almhdy\Simy\Core\Command;

use Almhdy\Simy\Core\Config;

class CreateMigrationCommand
{
    public function __invoke(array $arguments): void
    {
        $name = $arguments[0] ?? null;

        if (!$name) {
            echo "Migration name is required.\n";
            return;
        }

        $timestamp = date('Y_m_d_His');
        $filename = Config::BASE_DIR . '/app/migrations/' . "{$timestamp}_{$name}.sql";

        $template = "-- Migration: $name\n-- Created at: $timestamp\n\n-- Write your migration SQL here\n";

        file_put_contents($filename, $template);
        echo "Created migration: $filename\n";
    }
}