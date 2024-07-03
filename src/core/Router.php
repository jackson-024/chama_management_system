<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;
    public Render $render;

    public function __construct(Request $request, Response $response, Render $render)
    {

        $this->request = $request;
        $this->response = $response;
        $this->render = $render;
    }

    public function get($path, $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // Handle 404 Not Found
            $this->response->setStatusCode(404);
            return $this->render->renderView("404NotFound", [], "main");
        }

        // this renders views
        if (is_string($callback)) {
            return $this->render->renderView($callback);
        }

        // this renders controllers
        if (is_array($callback)) {
            Application::$app->setController(new $callback[0]()); // instance of controller to app
            $callback[0] = new $callback[0]();
        }

        // Echo the response
        echo call_user_func($callback, $this->request);
    }
}
