<?php

namespace app\controllers;

use app\core\Application;
use app\middlewares\Middleware;

class Controller
{
    public array $middlewares = [];

    public function render($view, $params = [], $layout)
    {
        return Application::$app->render->renderView($view, $params, $layout);
    }

    public function registerMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
