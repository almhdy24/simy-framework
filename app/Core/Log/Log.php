<?php

namespace Almhdy\Simy\Core\Log;

final class Log
{
    private static $maxFileSize = 1048576; // 1 MB
    private static $logLevels = ['DEBUG', 'INFO', 'WARNING', 'ERROR', 'CRITICAL'];
    private static $currentLogLevel = 'DEBUG'; // Default log level

    // Log the message to the specified log file
    public static function log(string $message, string $level, string $logPath): void
    {
        if (self::shouldLog($level)) {
            self::createLogFileDirectory($logPath);
            self::rotateLogFile($logPath);

            $timestamp = date("Y-m-d H:i:s");
            $logMessage = self::formatLogMessage($timestamp, $level, $message);

            file_put_contents($logPath, $logMessage, FILE_APPEND);
        }
    }

    // Create the log file directory if it doesn't exist
    private static function createLogFileDirectory(string $logPath): void
    {
        $logDir = dirname($logPath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }

    // Rotate the log file if it exceeds the maximum file size
    private static function rotateLogFile(string $logFile): void
    {
        clearstatcache(true, $logFile);
        if (file_exists($logFile) && filesize($logFile) > self::$maxFileSize) {
            rename($logFile, $logFile . "_" . date("Y-m-d_H-i-s"));
            touch($logFile);
        }
    }

    // Set the maximum file size for log rotation
    public static function setMaxFileSize(int $maxFileSize): void
    {
        self::$maxFileSize = $maxFileSize;
    }

    // Set the current log level
    public static function setLogLevel(string $level): void
    {
        if (in_array($level, self::$logLevels)) {
            self::$currentLogLevel = $level;
        }
    }

    // Format the log message
    private static function formatLogMessage(string $timestamp, string $level, string $message): string
    {
        return "[$timestamp] [$level]: $message" . PHP_EOL;
    }

    // Determine if the message should be logged based on the current log level
    private static function shouldLog(string $level): bool
    {
        $currentLevelIndex = array_search(self::$currentLogLevel, self::$logLevels);
        $messageLevelIndex = array_search($level, self::$logLevels);
        return $messageLevelIndex >= $currentLevelIndex;
    }

    // Log the message to a database
    public static function logToDatabase(string $message, string $level = "INFO"): void
    {
        // Logic to log the message to a database
    }

    // Log the message to an external service
    public static function logToExternalService(string $message, string $level = "INFO"): void
    {
        // Logic to log the message to an external service
    }

}