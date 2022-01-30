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

class AuthorizedIsNull extends BeforeMiddleware
{

    /**
     * Redirect to /login if authorized object is null. As if you're not
     * authorized then access cannot be granted.
     * @throws Throwable
     */
    public function middleware(object $middleware, Closure $next)
    {
        $authorized = Authorized::grantedUser();
        if (is_null($authorized)) {
            $middleware->redirect('/login');
        }
        return $next($middleware);
    }

}