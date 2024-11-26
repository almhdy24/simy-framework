<?php
class UserHandler
{
    // This property would typically hold user data
    protected $userData;

    public function __construct()
    {
        // Initialize the user data, possibly from a session or database
        $this->userData = $_SESSION['user'] ?? null; // Assuming user info is stored in session
    }

    public function getUserData()
    {
        return $this->userData;
    }

    public function getUserId()
    {
        return $this->userData['id'] ?? null;
    }

    public function getUserName()
    {
        return $this->userData['name'] ?? null;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $this->userData = null;
    }
}