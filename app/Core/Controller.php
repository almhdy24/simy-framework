<?php
namespace Almhdy\Simy\Core;
class Controller
{
	protected string $viewPath = "../app/Views/";
	protected $request;
	public function view($view, $data = [])
	{
		$viewFile = $this->viewPath . $view . ".php";

		if (file_exists($viewFile)) {
			extract($data);
			require $viewFile;
		} else {
			$this->viewNotFound($view);
		}
	}

	protected function viewNotFound($view)
	{
		return require "../app/Views/errors/viewNotFound.php";
	}
	public function redirect($url)
	{
		header("Location: $url");
		exit();
	}

	public function jsonResponse($data, $statusCode = 200)
	{
		header_remove();
		http_response_code($statusCode);
		header("Content-Type: application/json");
		header("powered-by: Simy Framework");
		echo json_encode($data);
		exit();
	}

	protected function model($modelClass)
	{
		require_once "../app/models/$modelClass.php";
		return new $modelClass();
	}
	protected function request()
	{
		$httpMethod = $_SERVER["REQUEST_METHOD"];
		if ($httpMethod == "GET") {
			$this->request = $_GET;
		} elseif ($httpMethod == "POST") {
			$this->request = $_POST;
		}
		return $this->request;
	}
}
