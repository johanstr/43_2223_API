<?php
@include('vendor/autoload.php');

$routes = include('app/Routes/routes.php');

$request_type     = $_SERVER['REQUEST_METHOD'];
$request_resource = isset($_GET['resource']) ? $_GET['resource'] : '/';
$request_id       = isset($_GET['id']) ? intval($_GET['id']) : null;

$controller = $routes[$request_type][$request_resource][0];
$method     = $routes[$request_type][$request_resource][1];

echo '<pre>';
if(class_exists($controller)) {
   $instance = new $controller();
   if(method_exists($instance, $method)) 
      if(! is_null($request_id))
         print_r($instance->$method($request_id));
      else
         print_r($instance->$method());
   else
      echo "<span style='font-size: bold; color: red;'>ERROR:</span> Method <span style='color: red;'>$method</span> in class <span style='color: orange;'>$controller</span> doesn't exist<br />";
} else 
   echo "<span style='font-size: bold; color: red;'>ERROR:</span> class <span style='color: orange;'>$controller</span> doesn't exist<br />";