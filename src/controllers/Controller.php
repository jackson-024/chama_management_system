<?php

namespace app\controllers;

use app\core\Application;

class Controller
{
    public function render($view, $params = [], $layout)
    {
        return Application::$app->render->renderView($view, $params, $layout);
    }
}
