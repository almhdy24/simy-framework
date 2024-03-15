<?php
namespace Almhdy\Simy\Core\Database\Drivers;

interface DatabaseDriverInterface
{
    /**
     * Establishes a connection to the database using the provided configuration.
     * 
     * @param array $config The configuration settings for establishing the database connection.
     * @return bool True if the connection is successful, false otherwise.
     */
    public function connect(array $config): bool;
    
    /**
     * Closes the connection to the database.
     */
    public function disconnect(): void;
    
}