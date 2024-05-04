<?php
namespace Almhdy\Simy\Controllers;

use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Controllers\UserController;
use Almhdy\Simy\Core\Validation\Validation;
use Almhdy\Simy\Core\Session\SessionManager;
use Almhdy\Simy\Models\User;

class AuthController extends Controller
{
  private $user = null;
  private $sessionManager = null;
  public function __construct(User $user = null)
  {
    $this->user = null;
    $this->sessionManager = new SessionManager();
  }

  public function login()
  {
    $this->view("templates/header");
    $this->view("auth/login");
  }
  public function auth()
  {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Validate the input
    $validator = new Validation();
    $data = ["email" => $email, "password" => $password];
    $rules = [
      "email" => "required|email",
      "password" => "required",
    ];

    $customMessages = [
      "email.required" => "The email field is required.",
      "password.required" => "The password field is required.",
    ];

    $isValid = $validator->validate($data, $rules, $customMessages);

    if ($isValid) {
      // Check if user exists with the provided email
      $user = new User();
      //var_dump($user->all());
      $dd = $user->customQuery("SELECT * FROM users  where email = $email");
var_dump($dd);
      die();
      $user = $user->where(["email" => $email]);
      if ($user) {
        // Verify the password
        if (password_verify($user["password"], $password)) {
          // Set session if authentication is successful
          $this->sessionManager->startSession();
          // define user data array
          $userData = [
            "id" => $user["id"],
            "email" => $user["email"],
          ];
          $this->sessionManager->setSessionData($userData);
          $this->redirect("/home");
        }
        $errors = "incoorect data ";
        $this->view("Auth/login", $errors);
      }
      return false;
    } else {
      $errors = $validator->getErrors();
      $this->view("Auth/login", $errors);
    }
  }

  public function register($userData)
  {
    // Validate the input data
    // Create a new user record
  }

  public function forgotPassword($email)
  {
    // Generate a unique reset token
    // Send a password reset link to the user's email
    // Handle the reset password process
  }
}
