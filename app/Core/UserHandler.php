<?php
namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Session\SessionManager;

class UserHandler
{
  protected ?object $userData;
  protected SessionManager $session;

  public function __construct()
  {
    // Initialize a session object
    $this->session = new SessionManager(true);
    $this->session->startSession();

    // Initialize the user data from a session
    $userDataJson = $this->session->getSessionData("user");
    $this->userData = $userDataJson ? json_decode($userDataJson) : null;
  }

  public function getUserData(): ?object
  {
    return $this->userData;
  }

  public function getUserId(): ?int
  {
    return $this->userData->id ?? null;
  }

  public function getUserName(): ?string
  {
    return $this->userData->name ?? null;
  }

  public function logout(): void
  {
    $this->session->destroySession();
    $this->userData = null;
  }

  // Checks if the user is logged in
  public function isLoggedIn(): bool
  {
    return !empty($this->session->getSessionData("is_logged_in")) &&
      json_decode($this->session->getSessionData("is_logged_in")) === true;
  }

  // Updates user data in the session
  public function updateUserData(array $data): void
  {
    $this->userData = (object) array_merge((array) $this->userData, $data);
    $this->session->setSessionData("user", json_encode($this->userData));
  }

  // Checks if the user has a specific role
  public function hasRole(string $role): bool
  {
    return in_array($role, $this->userData->roles ?? []);
  }

  // Retrieve user email
  public function getUserEmail(): ?string
  {
    return $this->userData->email ?? null;
  }

  // Method to set some user preferences
  public function setUserPreference(string $key, $value): void
  {
    if (!isset($this->userData->preferences)) {
      $this->userData->preferences = new \stdClass();
    }
    $this->userData->preferences->$key = $value;
    $this->session->setSessionData("user", json_encode($this->userData));
  }

  // Retrieve user preferences
  public function getUserPreference(string $key)
  {
    return $this->userData->preferences->$key ?? null;
  }
}
