<?php
// Autoloader
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});

require_once dirname(__DIR__) . '/vendor/autoload.php';

$router = new Core\Router();


// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts', ['controller' => 'Post', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Post', 'action' => 'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{id:\d+}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{name:[a-z-]+}/{action}', ['namespace' => 'Admin']);

// Display the Routing table.
//echo "<pre>";
//print_r($router->getRoutes() );
//echo "</pre>";

// Match the requested route

// Display route params
//if ($router->match($url) ) {
//    echo "<pre>";
//    print_r($router->getParams() );
//    echo "</pre>";
//} else {
//    echo "No route found for URL '$url' ";
//}



$router->dispatch($_SERVER['QUERY_STRING']);