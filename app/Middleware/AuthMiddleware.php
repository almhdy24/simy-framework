<?php

namespace Almhdy\Simy\Middleware;

use Almhdy\Simy\Core\Session\SessionManager;

class AuthMiddleware
{
  public function handle()
  {
    $session = new SessionManager();
    if (!$session->getSessionData("user")) {
      header("Location: /login");
      exit();
    }
  }
}
