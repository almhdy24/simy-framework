<?php
namespace Almhdy\Simy\Core;

class Controller
{
	// Define property with type hinting for string
	protected string $viewPath = "../app/Views/";

	// Property to store request data
	protected $request;

	// Method to load a view file
	public function view($view, $data = [])
	{
		$viewFile = $this->viewPath . $view . ".php";

		// Check if view file exists
		if (file_exists($viewFile)) {
			extract($data); // Extract data array into variables
			require $viewFile; // Require the view file
		} else {
			$this->viewNotFound($view); // Call method to handle view not found
		}
	}

	// Method to handle view not found error
	protected function viewNotFound($view)
	{
		return require "../app/Views/errors/viewNotFound.php"; // Include view not found error file
	}

	// Method to redirect to a different URL
	public function redirect($url)
	{
		header("Location: $url"); // Redirect to the specified URL
		exit(); // Exit to stop further execution
	}

	// Method to send JSON response
	public function jsonResponse($data, $statusCode = 200)
	{
		header_remove(); // Remove previously set headers
		http_response_code($statusCode); // Set HTTP response code
		header("Content-Type: application/json"); // Set content type to JSON
		header("powered-by: Simy Framework V1"); // Set custom header
		echo json_encode($data); // Encode data array to JSON and output
		exit(); // Exit to stop further execution
	}

	// Method to load a model class
	protected function model($modelClass)
	{
		require_once "../app/models/$modelClass.php"; // Require the model class file
		return new $modelClass(); // Instantiate the model class and return
	}

	// Method to handle incoming requests
	protected function request()
	{
		$httpMethod = $_SERVER["REQUEST_METHOD"]; // Get the HTTP request method

		// Determine request data based on HTTP method
		if ($httpMethod == "GET") {
			$this->request = $_GET; // Store GET request data
		} elseif ($httpMethod == "POST") {
			$this->request = $_POST; // Store POST request data
		}

		return $this->request; // Return the request data
	}
}