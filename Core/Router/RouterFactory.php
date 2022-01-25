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

use Evo\Http\Request;
use Evo\Router\RouterInterface;
use Evo\Base\Exception\BaseInvalidArgumentException;

class RouterFactory
{
    protected Object $routerObject;
    protected $url;
    protected ?object $request = null;

    public function __construct(?string $url = null)
    {
        $this->url = $_SERVER['QUERY_STRING'];
    }

    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Undocumented function
     */
    public function create(?string $routerString = null) : RouterInterface
    {
        $this->routerObject = ($routerString !=null) ? new $routerString() : new Router();
        if (!$this->routerObject instanceof RouterInterface) {
            throw new BaseInvalidArgumentException('Invalid router object');
        }

        return $this->routerObject;
    }

    /**
     * Undocumented function
     */
    public function buildRoutes(array $definedRoutes = [])
    {
        if (empty($definedRoutes)) {
            throw new BaseInvalidArgumentException('No routes defined');
        }
        $params = [];
        if (count($definedRoutes) > 0) {
            foreach ($definedRoutes as $route => $param) {
                if (isset($param['namespace']) && $param['namespace'] !='') {
                    $params = ['namespace' => $param['namespace']];
                } elseif (isset($param['controller']) && $param['controller'] !='') {
                    $params = ['controller' => $param['controller'], 'action' => $param['action']];
                }
                if (isset($route)) {
                    $this->routerObject->add($route, $params);
                }

            }    
        }
        /* Add dynamic routes based on regular expression */
        $this->routerObject->add('{controller}/{action}');
        /* Dispatch the routes */
        $this->routerObject->dispatch($this->url);

    }

    public function resolveParamNamePrefix($param): array
    {
        if (isset($param['name_prefix']) && $param['name_prefix'] != '') {
            $appendNamespace = array_key_exists('namespace', $param) ? '/' . $param['namespace'] : '/';
            $prefix = $param['name_prefix'];
            if (is_string($prefix)) {
//                if (str_contains($prefix, '.')) {
//                    $parts = explode('.', $prefix);
//                    if (isset($parts) && count($parts) > 0) {
//                        $elController = array_shift($parts);
//                        $elAction = array_pop($parts);
//                        $newArray = Array($prefix => $appendNamespace . $elController . '/' . $elAction);
//                        if ($newArray) {
//                            return $newArray;
//                        }
//
//                    }
//                }

                if (strpos($prefix, '.')) {
                    $parts = explode('.', $prefix);
                    if (isset($parts) && count($parts) > 0) {
                        $elController = array_shift($parts);
                        $elAction = array_pop($parts);
                        $newArray = array($prefix => $appendNamespace . $elController . '/' . $elAction);
                        if ($newArray) {
                            return $newArray;
                        }

                    }
                }
            }

            return [];
        }
    }
}