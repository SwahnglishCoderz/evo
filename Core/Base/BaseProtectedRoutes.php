<?php

declare(strict_types = 1);

namespace Evo\Base;

use Evo\Auth\Roles\PrivilegedUser;

class BaseProtectedRoutes
{

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