<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';
require_once 'helpers/RouteHandler.php';

$requestURI = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$routeHandler = new RouteHandler();

$routes = [
    'GET' => [
        '/' => 'MainController::index',
        '/main' => 'MainController::mainScreen',

        //API EVENTS
        '/api/getEvents' => 'ApiController::getEvents::api',
    ],
    'POST' => [
        '/api/login' => 'AuthController::login::api',
        '/api/logOut' => 'AuthController::logout::api',
        '/api/acceptAgent' => 'ApiController::acceptAgentByCode::api'
    ]
];

if (isset($routes[$requestMethod][$requestURI])) {
    $routeHandler->handleRequest($routes[$requestMethod][$requestURI]);
} else {
    $routeHandler->notFound();
}