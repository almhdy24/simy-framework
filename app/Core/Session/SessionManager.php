<?php
namespace Almhdy\Simy\Core\Session;

class SessionManager
{
  private bool $useCookies;

  public function __construct(bool $useCookies = false)
  {
    $this->useCookies = $useCookies;
  }

  /**
   * Start the session.
   */
    public function startSession(): void
{
    // Check if a session is not already active
    if (session_status() === PHP_SESSION_NONE) {
        // If cookies are to be used and PHPSESSID is not set
        if ($this->useCookies && !isset($_COOKIE["PHPSESSID"])) {
            session_start(["use_cookies" => 1]);
        } else {
            session_start();
        }
    }
}
  /**

  /**
   * Store data in the session.
   *
   * @param string $key The key under which the data will be stored
   * @param mixed $value The value to store
   */
  public function setSessionData(string $key, mixed $value): void
  {
    $_SESSION[$key] = $value;

    if ($this->useCookies) {
      setcookie($key, $value, 0, "/");
    }
  }

  /**
   * Retrieve data from the session.
   *
   * @param string $key The key under which the data is stored
   * @return mixed|null The retrieved data, or null if not found
   */
  public function getSessionData(string $key): mixed
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } elseif ($this->useCookies && isset($_COOKIE[$key])) {
      $_SESSION[$key] = $_COOKIE[$key];
      return $_COOKIE[$key];
    }
    return null;
  }

  /**
   * Remove data from the session.
   *
   * @param string $key The key of the data to remove
   */
  public function removeSessionData(string $key): void
  {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
    }

    if ($this->useCookies && isset($_COOKIE[$key])) {
      setcookie($key, "", time() - 3600, "/");
    }
  }

  /**
   * Destroy the session.
   */
  public function destroySession(): void
  {
    session_unset();
    session_destroy();
    if ($this->useCookies) {
      foreach ($_COOKIE as $key => $value) {
        setcookie($key, "", time() - 3600, "/");
      }
    }
  }
}