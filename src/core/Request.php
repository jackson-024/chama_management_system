<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $position = strpos($path, "?");

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    public function getMethod()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        return strtolower($method);
    }

    public function getHeader($header)
    {
        $headers = [];
        $requestHeaders = getallheaders();

        foreach ($requestHeaders as $name => $value) {
            $headers[strtolower($name)] = $value;
        }

        if (isset($headers[strtolower($header)])) {
            return $headers[strtolower($header)];
        }

        return null;
    }

    public function getBody()
    {
        $body = [];

        // Get the raw request body
        $rawBody = file_get_contents('php://input');

        // Check if the request body is JSON
        $contentType = $this->getHeader('Content-Type');

        // searches for application/json in conent type
        if (strpos($contentType, 'application/json') !== false) {
            // Decode the JSON data
            $body = json_decode($rawBody, true);
        } else {
            // Handle URL-encoded form data
            // FILTER_SANITIZE_SPECIAL_CHARS filters out
            if ($this->getMethod() === "get") {
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

            if ($this->getMethod() === "post") {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }

        return $body;
    }
}
