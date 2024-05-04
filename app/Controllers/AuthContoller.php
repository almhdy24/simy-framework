<?php
namespace Almhdy\Simy\Controller;

use Almhdy\Core\Controller;
use Almhdy\Models\User;
use Almhdy\Controllers\UserController;
use Almhdy\Simy\Core\Validation\Validation;
use Almhdy\Simy\Core\Sesdion\SessionManager;

class AuthController extends Controller
{
  private $user;
  private $sessionManager;
  public function __construct(User $user)
  {
    $this->user = $user;
    $this->SessionManager = new SessionManager();
  }

  public function auth($email, $password)
  {
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
      $user = $user->where(["email" => ~$email]);
      if ($user) {
        // Verify the password
        if (password_verify($user["password"], $password)) {
          // Set session if authentication is successful
          $this->SessionManager->startSession();
          // define user data array
          $userData = [
            "id" => $user["id"],
            "email" => $user["email"],
          ];
          $this->SessionManager->setSessionData($userData);
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
