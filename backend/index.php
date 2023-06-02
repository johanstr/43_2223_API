<?php
@include('vendor/autoload.php');

$routes = include('app/Routes/routes.php');


$request_type = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

echo "Request type: $request_type<br />";
echo "Request URI: $request_uri<br />";

$controller = $routes[$request_type][$request_uri][0];
$method = $routes[$request_type][$request_uri][1];

echo "Controller: $controller<br />";
echo "Method: $method<br />";

$instance = new $controller();
$instance->$method();