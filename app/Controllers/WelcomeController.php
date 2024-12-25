<?php

namespace Almhdy\Simy\Controllers;

use Almhdy\Simy\Core\Translation\Translation;

class WelcomeController
{
    public function index()
    {
        $name = 'John Doe';
        echo Translation::get('welcome', ['name' => $name]);
    }
}