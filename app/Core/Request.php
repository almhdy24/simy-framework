<?php
namespace Almhdy\Simy\Core;

class Request
{
	public function getUri(): string
	{
		if (!empty($_SERVER["REQUEST_URI"])) {
			return trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
		}
	}
	public function request(): array
	{
		$data = [];

		return [];
	}
	public function all(): array
	{
		$data = [];
		if (isset($_GET)) {
			array_push($_GET);
		}
		if (isset($_POST)) {
			array_push($_POST);
		}
		return $data;
	}
}
