<?php

namespace Almhdy\Simy\Core\Log;

class Log
{
    protected $logFile;
    protected $maxFileSize = 1048576; // 1 MB

    public function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

public static function log(string $message, string $logFile, string $level = 'INFO'): void
{
    $timestamp = date('[Y-m-d H:i:s]');
    $logMessage = "$timestamp [$level]: $message\n";

    self::rotateLogFile($logFile);

    file_put_contents($logFile, $logMessage, FILE_APPEND );
}

private static function rotateLogFile(string $logFile): void
{
    // Set maximum file size and log file path here or as parameters in the method
    $maxFileSize = 1024; // Example maximum file size in bytes

    clearstatcache(true, $logFile);
    if (file_exists($logFile) && filesize($logFile) > $maxFileSize) {
        rename($logFile, $logFile . '.' . date('Y-m-d_H-i-s'));
        touch($logFile);
    }
}
    public function setMaxFileSize(int $maxFileSize)
    {
        $this->maxFileSize = $maxFileSize;
    }

    public function logToDatabase(string $message, string $level = 'INFO')
    {
        // Logic to log the message to a database
    }

    public function logToExternalService(string $message, string $level = 'INFO')
    {
        // Logic to log the message to an external service
    }

    // Additional methods for customizing log formats, handling log levels, etc.
}