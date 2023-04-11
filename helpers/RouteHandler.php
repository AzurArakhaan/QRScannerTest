<?php

class RouteHandler
{
    protected $routeSeparator = '::';

    public function handleRequest($routeData)
    {
        $routeData = explode($this->routeSeparator, $routeData);
        $controllerName = $routeData[0];
        $methodName = $routeData[1];
        $isAPIRequest = !empty($routeData[2]);

        try {
            require_once(ROOT_PATH . "/controllers/{$controllerName}.php");
            $controller = new $controllerName();

            if ($isAPIRequest) {
                header('Content-Type: application/json');
            }

            echo $controller->$methodName();

        } catch (\Exception $e) {
            $this->notFound($e->getMessage());
        }
    }

    public function notFound($message = null)
    {
        http_response_code(404);
        return $message != null ?: 'Not Found';
    }
}