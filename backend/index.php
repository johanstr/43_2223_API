<?php
@include('vendor/autoload.php');

$routes = include('app/Routes/routes.php');

$request_type = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

echo "Request type: $request_type<br />";
echo "Request URI: $request_uri<br />";

$controller = $routes[$request_type][$request_uri][0];
$method = $routes[$request_type][$request_uri][1];

echo '<pre>';
if(class_exists($controller)) {
   $instance = new $controller();
   if(method_exists($instance, $method)) 
      print_r($instance->$method(1));
   else
      echo "<span style='font-size: bold; color: red;'>ERROR:</span> Method <span style='color: red;'>$method</span> in class <span style='color: orange;'>$controller</span> doesn't exist<br />";
} else 
   echo "<span style='font-size: bold; color: red;'>ERROR:</span> class <span style='color: orange;'>$controller</span> doesn't exist<br />";