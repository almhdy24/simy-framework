<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Request;
use Almhdy\Simy\Core\Response;

class Controller
{
    protected string $viewPath = "../app/Views/";
    protected ?Request $request;
    protected ?Response $response;

    public function __construct(?Request $request = null, ?Response $response = null)
    {
        $this->request = $request ?? new Request();
        $this->response = $response ?? new Response();
    }

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

    protected function model($modelClass)
    {
        require_once "../app/models/$modelClass.php";
        return new $modelClass();
    }

    protected function request(): Request
    {
        if (is_null($this->request)) {
            $this->request = new Request();
        }
        return $this->request;
    }

    protected function response(): Response
    {
        if (is_null($this->response)) {
            $this->response = new Response();
        }
        return $this->response;
    }

    public function env($value): string|false
    {
        return $_ENV[$value] ?? false;
    }
}