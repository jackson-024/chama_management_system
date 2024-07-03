<?php

namespace app\core;

class Render
{

    public function renderView($view, $params = [], $layout = "main")
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutcontent = $this->layoutContent($layout);
        return str_replace('{{content}}', $viewContent, $layoutcontent);
    }

    // function that dispalys layout - main
    protected function layoutContent($layout)
    {
        // starts output cache
        ob_start();

        include_once Application::$ROOT_DIR . "/src/views/layouts/$layout.php";

        // clear buffer
        return ob_get_clean();
    }

    // function that displays the specified view
    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        // starts output cache
        ob_start();

        include_once Application::$ROOT_DIR . "/src/views/$view.php";

        // clear buffer
        return ob_get_clean();
    }
}
