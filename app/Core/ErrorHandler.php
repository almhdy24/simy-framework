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
		//$logPath = $_ENV["BASE_DIR"] . "/Logs/" . date("Y-m-d") . "_error.log";
		$logPath = "../Logs/" . date("Y-m-d") . "_error.log";

		// Log the error message and details to the log file
		Log::log("Error: $errstr in $errfile at line $errline", "ERROR", $logPath);

		// Render error view based on environment
		self::renderErrorView();
	}

	// Render error view based on environment
	protected static function renderErrorView(): void
	{
		$env = self::getEnv();
		$statusCode = 500;
		$message =
			$env === "development"
				? "An error occurred"
				: "Something went wrong. Please try again later.";

		http_response_code($statusCode);
		require_once "../app/Views/errors/$statusCode.php";
		exit();
	}
}
