<?php

namespace Almhdy\Simy\Core\Log;

final class Log
{
  protected $maxFileSize = 1048576; // 1 MB

  // Log the message to the specified log file
  public static function log(
    string $message,
    string $level,
    string $logPath
  ): void {
    self::createLogFileDirectory($logPath);

    $timestamp = date("Y-m-d H:i:s");
    $logMessage = "[$timestamp] [$level]: $message" . PHP_EOL;

    file_put_contents($logPath, $logMessage, FILE_APPEND);
  }

  // Create the log file directory if it doesn't exist
  private static function createLogFileDirectory(string $logPath): void
  {
    $logDir = dirname($logPath);
    if (!is_dir($logDir)) {
      mkdir($logDir, 0755, true);
    }
  }

  private static function rotateLogFile(string $logFile): void
  {
    clearstatcache(true, $logFile);
    if (file_exists($logFile) && filesize($logFile) > $this->maxFileSize) {
      rename($logFile, $logFile . "_" . date("Y-m-d_H-i-s"));
      touch($logFile);
    }
  }

  public function setMaxFileSize(int $maxFileSize)
  {
    $this->maxFileSize = $maxFileSize;
  }

  public function logToDatabase(string $message, string $level = "INFO")
  {
    // Logic to log the message to a database
  }

  public function logToExternalService(string $message, string $level = "INFO")
  {
    // Logic to log the message to an external service
  }

  // Additional methods for customizing log formats, handling log levels, etc.
}
