<?php
// Autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Error and Exception handling
error_reporting(E_ALL);
set_error_handler('Core\Error::errorhandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

// Router
$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts', ['controller' => 'Post', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Post', 'action' => 'new']);
//$router->add('{controller}/{action}');
//$router->add('{controller}/{id:\d+}/{action}');

//$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
//$router->add('admin/{controller}/{id:\d+}/{action}', ['namespace' => 'Admin']);
//$router->add('admin/{controller}/{name:[a-z-]+}/{action}', ['namespace' => 'Admin']);
//$router->add('auth/{controller}/{action}', ['namespace' => 'Auth']);

$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('validate-email', ['controller' => 'Register', 'action' => 'validate-email', 'namespace' => 'Auth']);

$router->add('register/create', ['controller' => 'Register', 'action' => 'create', 'namespace' => 'Auth']);
$router->add('register/store', ['controller' => 'Register', 'action' => 'store', 'namespace' => 'Auth']);
$router->add('register/success', ['controller' => 'Register', 'action' => 'success', 'namespace' => 'Auth']);
$router->add('register/activated', ['controller' => 'Register', 'action' => 'activated', 'namespace' => 'Auth']);
$router->add('register/activate/{token:[\da-f]+}', ['controller' => 'Register', 'action' => 'activate', 'namespace' => 'Auth']);

$router->add('login', ['controller' => 'login', 'action' => 'create', 'namespace' => 'Auth']);
$router->add('login/attempt', ['controller' => 'login', 'action' => 'attempt', 'namespace' => 'Auth']);
$router->add('logout', ['controller' => 'login', 'action' => 'logout', 'namespace' => 'Auth']);
$router->add('logout/show-logout-message', ['controller' => 'login', 'action' => 'show-logout-message', 'namespace' => 'Auth']);

$router->add('password/forgot', ['controller' => 'Password', 'action' => 'forgot']);
$router->add('password/request-reset', ['controller' => 'Password', 'action' => 'request-reset']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('password/reset-password', ['controller' => 'Password', 'action' => 'reset-password']);

$router->add('profile/show', ['controller' => 'Profile', 'action' => 'show']);
$router->add('profile/edit', ['controller' => 'Profile', 'action' => 'edit']);
$router->add('profile/update', ['controller' => 'Profile', 'action' => 'update']);

$router->dispatch($_SERVER['QUERY_STRING']);