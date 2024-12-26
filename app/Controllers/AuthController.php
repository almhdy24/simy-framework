<?php

namespace Almhdy\Simy\Controllers;

use Almhdy\Simy\Models\User;
use Almhdy\Simy\Core\Session\SessionManager;
use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Core\Request;

class AuthController extends Controller
{
  protected  $request; // Remove type hint to match parent class
  private User $userModel;
  private SessionManager $session;

  public function __construct()
  {
    parent::__construct();
    $this->request = new Request();
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
    $password = $this->request->input("password");

    if ($this->userModel->createUser($username, $password)) {
      $this->session->setSessionData("user", $username);
      $this->redirect("/dashboard");
    } else {
      $this->view("auth/register", ["error" => "Username already exists"]);
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
