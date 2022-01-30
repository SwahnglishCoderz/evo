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


namespace Evo\Base;

use Evo\Auth\PrivilegedUser;
use Throwable;

class BaseProtectedRoutes
{
    /**
     * @throws Throwable
     */
    public function __invoke(): BaseProtectedRoutes
    {
        $privilege = PrivilegedUser::getUser();
        if (!$privilege->hasPrivilege($permission . '_' . $controller->thisRouteController())) {
            $controller->flashMessage('Access Denied!', $controller->flashWarning());
            $controller->redirect('/admin/accessDenied/index');
        }
        return $this;
    }
}