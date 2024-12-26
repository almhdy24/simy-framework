<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Request;
use Almhdy\Simy\Core\Response;

class Controller
{
    // Define property with type hinting for string
    protected string $viewPath = "../app/Views/";

    // Properties to store request and response objects
    protected $request;
    protected $response;

    public function __construct(Request $request = null, Response $response = null)
    {
        $this->request = $request ?? new Request();
        $this->response = $response ?? new Response();
    }

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

    // Method to load a model class
    protected function model($modelClass)
    {
        require_once "../app/models/$modelClass.php"; // Require the model class file
        return new $modelClass(); // Instantiate the model class and return
    }

    // Method to handle incoming requests
    protected function request() : Request
    {
        // check if request is not null var
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request; // Return the request OBJ
    }

    // Method to handle outgoing responses
    protected function response() : Response
    {
        // check if response is not null var
        if (is_null($this->response)) {
            $this->response = new Response();
        }
        return $this->response; // Return the response OBJ
    }

    // get env var
    public function env($value): string|false
    {
        return $_ENV[$value] ?? false;
    }
}