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

namespace Evo\Auth\Roles;

interface RolesInterface
{

    /**
     * This method accepts a permission name and returns true if the user has the
     * permission of false otherwise
     */
    public function hasPrivilege($permissionName) : bool;

    /**
     * HasPermission method accepts a permission name and returns the value based on the 
     * current object
     */
    public function hasPermission($permission) : bool;

    
    /**
     * Check if a user has a specific role
     */
    public function hasRole($roleName) : bool;


}
