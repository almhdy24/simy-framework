<?php

namespace Almhdy\Simy\Core;


class UserHandler
{
  private $userData; // Placeholder for user data, can be set when the user logs in

    public function isLoggedIn(): bool
    {
        // Implement your user logged in check here
        return true; // Placeholder for demo, return true if user is logged in
    }

    public function getUserData(): array
    {
        // Placeholder for fetching user data from database or session
        return $this->userData ?: [];
    }

    public function getUserId(): ?int
    {
        $userData = $this->getUserData();
        return $userData['id'] ?? null;
    }

    public function getUsername(): ?string
    {
        $userData = $this->getUserData();
        return $userData['username'] ?? null;
    }

    public function getEmail(): ?string
    {
        $userData = $this->getUserData();
        return $userData['email'] ?? null;
    }

    // You can add more user-related methods here as needed

}
