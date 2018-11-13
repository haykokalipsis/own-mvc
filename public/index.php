<?php
// Autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Error and Exception handling
error_reporting(E_ALL);
set_error_handler('Core\Error::errorhandler');
set_exception_handler('Core\Error::exceptionHandler');

// Router
$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts', ['controller' => 'Post', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Post', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{id:\d+}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{name:[a-z-]+}/{action}', ['namespace' => 'Admin']);
$router->add('auth/{controller}/{action}', ['namespace' => 'Auth']);

$router->dispatch($_SERVER['QUERY_STRING']);