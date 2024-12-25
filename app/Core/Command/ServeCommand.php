<?php

namespace Almhdy\Simy\Core\Command;

class ServeCommand
{
    public function __invoke(array $arguments): void
    {
        $host = '127.0.0.1';
        $port = '8000';

        // Check if host and port are provided as arguments
        if (isset($arguments[0])) {
            $host = $arguments[0];
        }
        if (isset($arguments[1])) {
            $port = $arguments[1];
        }

        $publicPath = __DIR__ . '/../../../public';

        echo "Starting server at http://$host:$port\n";
        echo "Press Ctrl+C to stop the server\n";

        // Start the PHP built-in server
        $command = sprintf('php -S %s:%s -t %s', $host, $port, $publicPath);
        passthru($command);
    }
}