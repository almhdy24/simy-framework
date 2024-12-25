<?php

namespace Almhdy\Simy\Core\Session;

class SessionManager
{
    private bool $useCookies;

    public function __construct(bool $useCookies = false)
    {
        $this->useCookies = $useCookies;
        $this->configureSession();
    }

    /**
     * Configure session settings for security.
     */
    private function configureSession(): void
    {
        // Use only cookies to store session ID
        ini_set('session.use_only_cookies', '1');
        
        // Set secure flag for cookies if using HTTPS
        ini_set('session.cookie_secure', '1');
        
        // Set HTTPOnly flag for cookies to prevent JavaScript access
        ini_set('session.cookie_httponly', '1');
        
        // Use strict mode
        ini_set('session.use_strict_mode', '1');
        
        // Regenerate session ID periodically for security
        ini_set('session.cookie_lifetime', '0'); // Session cookie will expire when the browser is closed
        ini_set('session.gc_maxlifetime', '1440'); // Session data will be available for 24 minutes (1440 seconds)
    }

    /**
     * Start the session.
     */
    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

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
            setcookie($key, serialize($value), 0, "/", "", true, true);
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
            $_SESSION[$key] = unserialize($_COOKIE[$key]);
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

    /**
     * Regenerate the session ID for security.
     */
    public function regenerateSessionID(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}