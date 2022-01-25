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

use Closure;

interface RouterInterface
{

    /**
     * Add a route to the routing table
     *
     */
    public function add(string $route, array $params = [], Closure $cb = null);

    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     */
    public function dispatch(string $url);

    /**
     * Get the currently matched parameters
     *
     */
    public function getParams() : array;

    /**
     * Get all the routes from the routing table
     *
     */
    public function getRoutes() : array;


}