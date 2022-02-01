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

namespace Evo\Base\Middlewares;

use Closure;
use Evo\Middleware\BeforeMiddleware;

class Error404 extends BeforeMiddleware
{
    /**
     * Prevent unauthorized access to the administration panel. Only users with specific
     * privileges can access the admin area.
     */
    public function middleware(object $middleware, Closure $next)
    {
    }
}

