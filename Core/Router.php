<?php
/**
 * Created by PhpStorm.
 * User: Haykokalipsis
 * Date: 11.11.2018
 * Time: 18:10
 */
namespace Core;

class Router
{

    protected $routes = [];
    protected $params = [];

    // Creating a regular expression pattern from a route  and saving it in routes property
    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes.
        // So route-pattern like {controller}/{action} becomes {controller}\/{action}
        // Or route-pattern like admin/{controller}/{id:\d+}/{action} becomes admin\/{controller}\/{id:\d+}\/{action}
        $route = preg_replace('~\/~', '\\/', $route);

        // Convert variables e.g. {controller} or {action} or {id} into named capture groups
        // So {controller}\/{action} becomes (?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)
        // Or admin\/{controller}\/{id:\d+}\/{action} becomes admin(?P<controller>[a-z-]+)\/{id:\d+}\/(?P<action>[a-z-]+)
        $route = preg_replace('~\{([a-z]+)\}~', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+} into (?P<id>\d+), or {name:\[a-z]+} into {?P<name>[a-z]+}
        // So admin(?P<controller>[a-z-]+)\/{id:\d+}\/(?P<action>[a-z-]+) becomes admin(?P<controller>[a-z-]+)\/(?P<id>\d+)\/(?P<action>[a-z-]+)
        $route = preg_replace('~\{([a-z]+):([^\}]+)\}~', '(?P<\1>\2)', $route);

        /*
         * Add start and end delimiters, and case insensitive flag.
         * So (?P<controller>[a-z-]+)\/(?P<action>[a-z-]+) becomes ~^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$~i
         * Or admin\/(?P<controller>[a-z-]+)\/(?P<id>\d+)\/(?P<action>[a-z-]+) becomes ~^admin\/(?P<controller>[a-z-]+)\/(?P<id>\d+)\/(?P<action>[a-z-]+)$~i
        */
        $route = '~^' . $route . '$~i';

        $this->routes[$route] = $params;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     *
     * @param string $url The route URL
     *
     * @return boolean  true if a match found, false otherwise
     */
    public function match($url)
    {

        // Now We are matching the url (for example admin/posts/44/edit) with all route patterns we have in our routes property
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches) ) {
                // Get named capture group values
                // for example we get $matches = ['controller' => 'posts', 'action' => 'new']
                // or $matches = 'home' if the matched route was /home
                foreach ($matches as $key => $match) {
                    // if no static parameters are set on route (for example /, ['controller' => 'post', 'action' => 'new'])
                    if (is_string($key) ) {
                        $params[$key] = $match;
                        //So $params[controller] = posts
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if($this->match($url) ) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
//            $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if(class_exists($controller) ) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if(is_callable([$controller_object, $action]) ) {
                    $controller_object->$action();
                } else {
                    echo "Method {$action} (in controller {$controller}) not found";
                }
            } else {
                echo "Controller class {$controller}) not found";
            }
        } else {
            echo "No route matched";
        }
    }

    // Convert string with hyphens to StudlyCaps
    public function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string) ) );
    }

    public function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string) );
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    public function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if(array_key_exists('namespace', $this->params) ) {
            $namespace .=$this->params['namespace'] . '\\';
        }

        return $namespace;
    }

}