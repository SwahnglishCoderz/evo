<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Evo\Middleware;

use Evo\Middleware\Exception\MiddlewareInvalidArgumentException;
use Evo\Base\BaseApplication;
use Closure;

class Middleware
{
    private array $middlewares;

    /**
     * Main constructor method which pipes the class property to the
     * constructor argument. We are using the container object to instantiate
     * the middleware classes and defined it with a property. new object instance
     * is then stored as an array and piped to the class middlewares property
     */
    public function __construct(array $middlewares = [])
    {
        $output = [];
        if ($middlewares) {
            foreach ($middlewares as $key => $middleware) {
                if (str_contains($middleware, $key)) {
                    if ($middleware) {
                        $output[] = $this->$key = BaseApplication::diGet($middleware);
                    } else {
                        $output[] = BaseApplication::diGet($middleware);
                    }
                }
            }
        }
        $this->middlewares = $output;
    }

    /**
     * Add middlewares
     */
    public function middlewares(array $middlewares) : self
    {
        if ($middlewares instanceof Middleware) {
            $middlewares = $middlewares->toArray();
        }
        if ($middlewares instanceof MiddlewareInterface) {
            $middlewares = [$middlewares];
        }
        if (!is_array($middlewares)) {
            throw new MiddlewareInvalidArgumentException(get_class($middlewares) . ' is not a valid middleware object.');
        }
        return new static(array_merge($this->middlewares, $middlewares));
    }

    /**
     * Run the middle before and after the called method and pass and Object
     * through.
     */
    public function middleware(Object $object, Closure $func)
    {
        $function = $this->getNextFunc($func);
        /*
         reverse the order of how the middles are called so the first 
         in the array will be executed first
         */
        $middlewares = array_reverse($this->middlewares);
        /** */
        $funcMiddleware = array_reduce($middlewares, function($nextMiddleware, $middleware) {
            return $this->createMiddleware($nextMiddleware, $middleware);
        }, $function);
        /* return the middleware with the object */
        return $funcMiddleware($object);

    }

    /**
     * Returns an array of middlewares
     */
    public function toArray() : array
    {
        return $this->middlewares;
    }

    /**
     * The inner function of the middleware
     */
    private function getNextFunc(Closure $func) : Closure
    {
        return function($object) use ($func) {
            return $func($object);
        };
    }

    /**
     * Get a middleware function. This function will get the object from the previous
     * middleware and pass it inwards
     */
    private function createMiddleware($nextMiddleware, $middleware) : Closure
    {   
        return function($object) use ($nextMiddleware, $middleware) {
            return $middleware->middleware($object, $nextMiddleware);
        };
    }
}