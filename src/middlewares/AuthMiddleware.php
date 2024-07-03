<?php

use app\core\Application;
use app\middlewares\Middleware;

class AuthMiddleware extends Middleware
{
    public function execute()
    {
        if (Application::$app->isGuest()) {
            # code...
        }
    }
}
