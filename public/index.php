<?php

require_once '../Core/Router.php';

$router = new Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Post', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Post', 'action' => 'new']);

// Display the Routing table.
//echo "<pre>";
//print_r($router->getRoutes() );
//echo "</pre>";

// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url) ) {
    echo "<pre>";
    print_r($router->getParams() );
    echo "</pre>";
} else {
    echo "No route found for URL '$url' ";
}
