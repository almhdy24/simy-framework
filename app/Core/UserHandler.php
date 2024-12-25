<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Session\SessionManager;

class UserHandler
{
    protected $userData;
    protected SessionManager $session;

    public function __construct()
    {
        $this->session = new SessionManager();
        $this->userData = json_decode($this->session->getSessionData("user"));
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
        return !empty($this->userData);
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