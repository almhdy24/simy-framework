<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Log\Log;

final class ErrorHandler
{
  // Determine the environment based on the configuration
  private static function getEnv(): string
  {
    if (isset($_ENV["ENV"]) && $_ENV["ENV"] === "development") {
      return "development";
    } else {
      return "production";
    }
  }

  // Enable error handling by setting error, exception, and shutdown handlers
  public static function enableErrorHandling(): void
  {
    set_error_handler([self::class, "errorHandler"]);
    set_exception_handler([self::class, "exceptionHandler"]);
    register_shutdown_function([self::class, "shutdownHandler"]);
  }

  // Handle PHP errors
  public static function errorHandler(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
  ): bool {
    $env = self::getEnv();
    if ($env === "development" && error_reporting() & $errno) {
      self::handleErrorAndLog($errstr, $errfile, $errline, $env);
      return true;
    } elseif ($env === "production") {
      self::handleErrorAndLog("", "", "");
      return true;
    }
    return false; // Let PHP handle the error
  }

  // Handle exceptions
  public static function exceptionHandler(\Throwable $exception): void
  {
    self::handleErrorAndLog(
      $exception->getMessage(),
      $exception->getFile(),
      $exception->getLine(),
      ""
    );
  }

  // Handle shutdown errors
  public static function shutdownHandler(): void
  {
    $lastError = error_get_last();
    if (!empty($lastError)) {
      self::handleErrorAndLog(
        $lastError["message"],
        $lastError["file"],
        $lastError["line"]
      );
    }
  }

  // Handle error details and log to file
  protected static function handleErrorAndLog(
    string $errstr,
    string $errfile,
    int $errline
  ): void {
    $logPath = dirname(__DIR__) . "/Logs/" . date("Y-m-d") . "_error.log";

    // Log the error message and details to the log file
    Log::log("Error: $errstr in $errfile at line $errline", "ERROR", $logPath);

    // Define the error message and details
    $message = "An error occurred";
    $details = "Error: $errstr in $errfile at line $errline"; // Include specific error details

    // Render error view based on environment and pass message and details
    self::renderErrorView($message, $details);
  }

  // Render error view based on environment
  protected static function renderErrorView(
    string $message,
    string $details
  ): void {

    $statusCode = 500;
    if (!headers_sent()) {
      http_response_code($statusCode);
      if (file_exists("../app/Views/errors/$statusCode.php")) {
        // Pass $message and $details to the error view
        require_once "../app/Views/errors/$statusCode.php";

        exit();
      }
    }
  }
}
