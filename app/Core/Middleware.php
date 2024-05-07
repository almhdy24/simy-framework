<?php

namespace Almhdy\Simy\Core;

abstract class Middleware
{
    abstract public function handle(mixed $request, callable $handler): mixed;
}