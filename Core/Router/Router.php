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

use App\Config;
use Closure;
use Exception;
use ReflectionException;
use ReflectionMethod;
use Evo\Utility\Yaml;
use Evo\Utility\Stringify;
use Evo\Base\BaseApplication;
use Evo\Router\Exception\RouterNoRoutesFound;
use Evo\Router\Exception\NoActionFoundException;
use Evo\Router\Exception\RouterBadFunctionCallException;

class Router implements RouterInterface
{

    /** returns extended router methods */
    use RouterTrait;

    /** Associative array of routes (the routing table) */
    protected array $routes = [];
    /** Parameters from the matched route */
    protected array $params = [];

    protected string $controllerSuffix = "Controller";
    private string $actionSuffix = 'Action';
    protected string $namespace = 'App\Controller\\';

    public function add(string $route, array $params = [], Closure $cb = null)
    {
        if ($cb != null) {
            return $cb($params);
        }
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Create the controller object name using the parameters defined within
     * the yaml configuration file. Route parameters are accessible using
     * the $this->params property and can fetch any key defined. ie
     * `controller, action, namespace, id etc...`
     */
    private function createController(): string
    {
        $controllerName = $this->params['controller'] . $this->controllerSuffix;
        $controllerName = Stringify::studlyCaps($controllerName);
        return $this->getNamespace() . $controllerName;
    }

    /**
     * Create a camel case method name for the controllers
     */
    public function createAction(): string
    {
        $action = $this->params['action'];
        return Stringify::camelCase($action);
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
        if (!$this->match($url)) {
            http_response_code(404);
            throw new RouterNoRoutesFound("Route " . $url . " does not match any valid route.", 404);
        }
        if (!class_exists($controller = $this->createController())) {
            throw new RouterBadFunctionCallException("Class " . $controller . " does not exists.");
        }
        return [$controller];
    }

    /**
     * Dispatch the request route by calling the controller class matching the controller
     * parameter from the url
     * @throws Exception
     */
    public function dispatch(string $url)
    {
        list($controller) = $this->dispatchWithException($url);
        $controllerObject = new $controller($this->params);
        $action = $this->createAction();
        if (preg_match('/action$/i', $action) == 0) {
            // if (Config::SYSTEM['use_resolvable_action'] === true) {
                if (Config::APP['system']['use_resolvable_action'] === true) {
                $this->resolveControllerActionDependencies($controllerObject, $action);
            } else {
                $controllerObject->$action();
            }
        } else {
            throw new NoActionFoundException("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
        }
    }

    /**
     * Using the reflection api to resolve controller methods. Meaning we can pass multiple arguments to
     * an action method. argument variables which reflects the dependencies within the providers.yml
     * file.
     * @throws ReflectionException
     */
    private function resolveControllerActionDependencies(object $controllerObject, string $newAction)
    {
        $newAction = $newAction . $this->actionSuffix;
        $reflectionMethod = new ReflectionMethod($controllerObject, $newAction);
        $reflectionMethod->setAccessible(true);
        if ($reflectionMethod) {
            $dependencies = [];
            foreach ($reflectionMethod->getParameters() as $param) {
                $newAction = BaseApplication::diGet(Yaml::file('providers')[$param->getName()]);
                if (isset($newAction)) {
                    $dependencies[] = $newAction;
                } else if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                }
            }
            $reflectionMethod->setAccessible(false);
            return $reflectionMethod->invokeArgs(
                $controllerObject,
                $dependencies
            );
        }
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
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

    public function getParams(): array
    {
        return $this->params;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work, however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     */
    protected function removeQueryStringVariables(string $url): string
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

//            if (!str_contains($parts[0], '=')) {
//                $url = $parts[0];
//            } else {
//                $url = '';
//            }

            if (!strpos($parts[0], '=')) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return rtrim($url, '/');
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     */
    protected function getNamespace(): string
    {
        if (array_key_exists('namespace', $this->params)) {
            $this->namespace .= $this->params['namespace'] . '\\';
        }
        return $this->namespace;
    }
}
