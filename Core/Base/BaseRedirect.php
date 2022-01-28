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

namespace Evo\Base;

use Evo\Base\Exception\BaseInvalidArgumentException;

class BaseRedirect
{
    protected string $url;

    /**
     * Optional. Indicates whether the header should replace a previous similar header or add a new  *
     * header of the same type. Default is TRUE (will replace). FALSE allows multiple headers of the *
     * same type
     */
    protected bool $replace = true;

    protected int $responseCode = 303;
    protected array $routeParams = [];

    protected const ROUTE_PARAMS = ['namespace', 'controller', 'action', 'id', 'token'];

    public function __construct(string $url, array $routeParams, bool $replace, int $responseCode)
    {
        if (empty($url)) {
            throw new BaseInvalidArgumentException('Invalid header. This argument is required.');
        }
        $this->url = $url;
        $this->replace = $replace;
        $this->responseCode = $responseCode;
        $this->routeParams = $routeParams;
    }

    public function validateRouteUrl() : bool
    {   
        $parts = explode('/', $this->url);
        if (count($parts) > 0) {
            foreach (self::ROUTE_PARAMS as $route) {
                if (isset($this->routeParams[$route]) && $this->routeParams[$route] !='') {
                    if (!in_array(strtolower($this->routeParams[$route]), array_filter($parts))) {
                        throw new BaseInvalidArgumentException('The controller redirect method is returning an invalid url');
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function redirect() : void
    {
        //$this->validateRouteUrl();
        if (!headers_sent()) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $this->url, $this->replace, $this->responseCode);
            exit;
        }
    }

    /**
     * Determine the entire route string when using this method. In order to
     * simply the process return a string path which when pass to the redirect
     * method will attempt to redirect to the given string path
     */
    public function _onSelf() : string
    {
        $controller = $this->routeParams['controller'];
        $namespace = $this->routeParams['namespace'];
        $action = $this->routeParams['action'];
        $id = $this->routeParams['id'];
        $sep = '/';
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }
        /*if (isset($controller) && is_string($controller) && $controller !=null) {
            if (isset($action) && is_string($action)) {
                switch ($action) {
                    default :
                        if ($this->id !==null || $this->id !==0) {
                            $path = "/{$namespace}/{$controller}/{$id}/{$action}";
                        } else {
                            $path = "/{$namespace}/{$controller}/{$action}";
                        }
                        if (isset($path) && $path !='') {
                            return $path;
                        }
                        break;
                }
            }
        }*/
    
    }
}
