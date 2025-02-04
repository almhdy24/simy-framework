<?php

namespace Almhdy\Simy\Controllers;

use Almhdy\Simy\Models\User;
use Almhdy\Simy\Core\Session\SessionManager;
use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Core\Request;
use Almhdy\Simy\Core\Response;

class AuthController extends Controller
{
  protected ?Request $request;
  protected ?Response $response;
  private User $userModel;
  private SessionManager $session;

  public function __construct(
    ?Request $request = null,
    ?Response $response = null
  ) {
    parent::__construct($request, $response);
    $this->userModel = new User();
    $this->session = new SessionManager();
  }

  public function showRegisterForm()
  {
    $this->view("auth/register");
  }

  public function register()
{
    $username = $this->request->input("username");
    $email = $this->request->input("email");
    $password = $this->request->input("password");
    $passwordConfirmation = $this->request->input("password_confirmation");

    // Initialize the Validator
    $validator = new \Almhdy\Simy\Core\Validation\Validator("ar");

    // Define validation rules
    $rules = [
        'username' => 'required|alpha_num|min:3|max:20',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'password_confirmation' => 'required|same:password'
    ];

    // Validate the input
    $data = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'password_confirmation' => $passwordConfirmation
    ];

    if ($validator->validate($data, $rules)) {
        // Hash the password
        $hashedPassword = \Almhdy\Simy\Core\Password::hash($password);

        // If validation passes, create the user
        if ($this->userModel->createUser($username, $email, $hashedPassword)) {
            $this->session->setSessionData("user", $username);
            $this->redirect("/dashboard");
        } else {
            $this->view("auth/register", ["error" => "Username already exists"]);
        }
    } else {
        // If validation fails, redirect back with errors
        $this->view("auth/register", ["errors" => $validator->getErrors()]);
    }
}

  public function showLoginForm()
  {
    $this->view("auth/login");
  }

  public function login()
  {
    $username = $this->request->input("username");
    $password = $this->request->input("password");
    $user = $this->userModel->getUserByUsername($username);
    var_dump($this->userModel->where(["id" => 1]));
    die();
    if ($user && password_verify($password, $user["password"])) {
      $this->session->setSessionData("user", $username);
      $this->redirect("/dashboard");
    } else {
      $this->view("auth/login", ["error" => "Invalid credentials"]);
    }
  }

  public function logout()
  {
    $this->session->destroySession();
    $this->redirect("/login");
  }
}
