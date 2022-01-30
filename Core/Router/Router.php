<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Evo\Router;

use Evo\System\Config;
use Exception;
use Evo\Utility\Stringify;
use Evo\Router\Exception\RouterNoRoutesFound;
use Evo\Router\Exception\NoActionFoundException;
use Evo\Router\Exception\RouterBadFunctionCallException;

class Router implements RouterInterface
{
    /** Associative array of routes (the routing table) */
    protected array $routes = [];
    /** Parameters from the matched route */
    protected array $params = [];
    protected string $controllerSuffix = "Controller";
    private string $actionSuffix = 'Action';
    protected string $namespace = 'App\Controller\\';

    /**
     * Add a route to the routing table
     */
    // see if it's possible to set 'index' as the default method if a URL is passed with just the controller name
    public function add(string $route, array $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case-insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Create the controller object name using the parameters defined within
     * the yaml configuration file. Route parameters are accessible using
     * the $this->params property and can fetch any key defined. ie
     * `controller, action, namespace, id etc...`
     *
     * @return string
     */
    private function createController(): string
    {
        $controllerName = $this->params['controller'] . $this->controllerSuffix;
        $controllerName = Stringify::convertToStudlyCaps($controllerName);
        return $this->getNamespace() . $controllerName;
    }

    /**
     * Create a camel case method name for the controllers
     *
     * @return string
     */
    public function createAction(): string
    {
        $action = $this->params['action'];
        return Stringify::convertToCamelCase($action);
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     */
    public function isRouteInRoutingTable(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture role values
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Get all the routes from the routing table
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get the currently matched parameters
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Check for validity within the url. If invalid we will throw an exception. if valid
     * we will then check the requested controller exists if not then throw another
     * exception. else return the controller as an array
     * @throws RouterNoRoutesFound
     */
    private function dispatchWithException(string $url): array
    {
        $url = $this->removeQueryStringVariables($url);

        if (!$this->isRouteInRoutingTable($url)) {
            http_response_code(404);
            throw new RouterNoRoutesFound("Route " . $url . " does not match any valid route.", 404);
        }
        if (!class_exists($controller = $this->createController())) {
            throw new RouterBadFunctionCallException("Class " . $controller . " does not exists.");
        }
        return [$controller];
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     * @throws Exception
     */
    public function dispatch(string $url)
    {
        list($controller) = $this->dispatchWithException($url);

        $controller_object = new $controller($this->params);

        $action = $this->createAction();

        if (is_callable([$controller_object, $action])) {
            $controller_object->$action();
        } else {
            throw new Exception("Method $action (in controller $controller) not found");
        }
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work, however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     */
    protected function removeQueryStringVariables(string $url): string
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

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     */
    protected function getNamespace(): string
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
