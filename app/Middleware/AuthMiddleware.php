<?php

namespace Almhdy\Simy\Middleware;

use Almhdy\Simy\Core\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public function handle()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
}