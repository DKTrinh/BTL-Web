<?php

class AppRouter
{
    public function run()
    {
        $url = $_GET['url'] ?? '';

        $url = trim($url, '/');
        $parts = explode('/', $url);

        $controllerName = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
        $method = $parts[1] ?? 'index';

        // Load controller
        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("Controller not found: " . $controllerName);
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            die("Class not found: " . $controllerName);
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            die("Method not found: " . $method);
        }

        // Call method
        call_user_func([$controller, $method]);
    }
}