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
use Evo\Auth\Roles;
use Evo\Auth\Roles\PrivilegedUser;
use Evo\Middleware\BeforeMiddleware;

class AdminAuthentication extends BeforeMiddleware
{
    /**
     * Prevent unauthorized access to the administration panel. Only users with specific
     * privileges can access the admin area.
     */
    public function middleware(object $middleware, Closure $next)
    {
        $user = PrivilegedUser::getUser();
        if (!$user->hasPrivilege('have_admin_access')) {
            $middleware->flashMessage("<strong class=\"uk-text-danger\">Access Denied </strong>Sorry you need the correct privilege to access this area.", $middleware->flashInfo());
            $middleware->redirect(Authorized::getReturnToPage());
        }

        return $next($middleware);
    }
}
