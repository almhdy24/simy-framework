<?php
namespace Almhdy\Simy\Core;

final class ErrorHandler
{
	private static function getEnv(): string
	{
		
		if (isset($_ENV["ENV"]) && $_ENV["ENV"] === "development") {
			$env = "development";
		} else {
			$env = "production";
		}
		return $env;
	}

	public static function enableErrorHandling(): void
	{
		set_error_handler([self::class, "errorHandler"]);
		set_exception_handler([self::class, "exceptionHandler"]);
		register_shutdown_function([self::class, "shutdownHandler"]);
	}

	public static function errorHandler(
		int $errno,
		string $errstr,
		string $errfile,
		int $errline
	): bool {
		$env = self::getEnv();
		if ($env === "development" && error_reporting() & $errno) {
			self::handleErrorDetails($errstr, $errfile, $errline, $env);
			return true;
		} elseif ($env === "production") {
			self::handleErrorDetails("", "", "");
			return true;
		}
		return false; // Let PHP handle the error
	}

	public static function exceptionHandler(\Throwable $exception): void
	{
		self::handleErrorDetails(
			$exception->getMessage(),
			$exception->getFile(),
			$exception->getLine(),
			""
		);
	}

	public static function shutdownHandler(): void
	{
		$lastError = error_get_last();
		if (!empty($lastError)) {
			self::handleErrorDetails(
				$lastError["message"],
				$lastError["file"],
				$lastError["line"]
			);
		}
	}

	protected static function handleErrorDetails(
		string $errstr,
		string $errfile,
		int $errline
	): void {
		$env = self::getEnv();
		if ($env === "development") {
			self::renderErrorView(
				500,
				"An error occurred: $errstr",
				"File: $errfile, Line: $errline"
			);
		} else {
			self::renderErrorView(
				500,
				"Something went wrong. Please try again later."
			);
		}
	}

	protected static function renderErrorView(
		int $statusCode,
		string $message,
		string $details = ""
	): void {
		http_response_code($statusCode);
		require_once "../app/Views/errors/$statusCode.php";
		exit();
	}
}
