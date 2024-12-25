<?php

namespace Almhdy\Simy\Core;

use Almhdy\Simy\Core\Session\SessionManager;

abstract class BaseMiddleware
{
    protected SessionManager $session;

    public function __construct()
    {
        $this->session = new SessionManager();
    }

    /**
     * Method to handle the middleware logic.
     * Every middleware extending this base class must implement this method.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Redirects to a specific URI.
     *
     * @param string $uri
     * @return void
     */
    protected function redirect(string $uri)
    {
        header("Location: $uri");
        exit();
    }

    /**
     * Check if the user is authenticated.
     *
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        return $this->session->getSessionData('user') !== null;
    }

    /**
     * Get the authenticated user.
     *
     * @return mixed
     */
    protected function getAuthenticatedUser()
    {
        return $this->session->getSessionData('user');
    }

    /**
     * Destroy the session.
     *
     * @return void
     */
    protected function logout()
    {
        $this->session->destroySession();
    }
}