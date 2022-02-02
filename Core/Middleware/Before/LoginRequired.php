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

namespace Evo\Middleware\Before;

use Closure;
use Evo\Auth\Authorized;
use Evo\Middleware\BeforeMiddleware;
use Throwable;

class LoginRequired extends BeforeMiddleware
{

    protected const MESSAGE = "Action Required: Please login for access.";

    /**
     * Requires basic login when entering protected routes
     * @throws Throwable
     */
    public function middleware(object $middleware, Closure $next)
    {
        if (!Authorized::grantedUser()) {
            $middleware->flashMessage(self::MESSAGE, $middleware->flashInfo());
            /* Hold the requested page so when the user logs in we can redirect them back */
            Authorized::rememberRequestedPage();
            $middleware->redirect('/login');
        }

        return $next($middleware);
    }
}
