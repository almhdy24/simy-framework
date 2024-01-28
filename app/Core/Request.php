<?php
namespace Almhdy\Simy\Core;

class Request
{
	public function getUri()
	{
		if (!empty($_SERVER["REQUEST_URI"])) {
			return trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
		}
	}
}
