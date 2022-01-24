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

use Evo\UserManager\Model\UserRoleModel;
use Evo\Auth\Authorized;
use Evo\Base\Exception\BaseUnexpectedValueException;

trait PrivilegeTrait
{

    /**
     * return the current login user role as a capitalized string
     */
    public function getRole()
    {
        if ($this->roles) {
            foreach (array_keys($this->roles) as $key) {
                return $key;
            }
        }
        return false;
    }

    /**
     * Returns an array of the current log in user assigned permissions
     */
    public function getPermissions(): array
    {
        if ($this->roles) {
            foreach (array_values($this->roles) as $key => $value) {
                $value = (array)$value;
                foreach ($value as $permissionArray) {
                    return $permissionArray;
                }
            }
        }
    }

    public function getPermissionByRoleID(int $roleID)
    {
        $roles = Role::getRolePermissions($roleID);
        foreach ((array)$roles as $role) {
            return $role;
        }
    }


}
