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

namespace Evo\Auth;

use Evo\Auth\Roles\Role;
use Evo\Auth\UserRoleModel;
use Evo\Auth\Authorized;
use Evo\Base\Exception\BaseUnexpectedValueException;
use Throwable;

class PrivilegedUser
{
    protected array $roles = [];

    /**
     * return an array of the current logged-in user data. user id is fetch from the
     * session from the grantedUser() method
     * @throws Throwable
     */
    public static function getUser(int $userID = null)
    {
        $user = Authorized::grantedUser();
        if ($user !==null) {
            $privilegeUser = new PrivilegedUser();
            $privilegeUser->user_id = $user->id;
            $privilegeUser->email = $user->email;
//            $privilegeUser->name = $user->name;
            $privilegeUser->firstname = $user->firstname;
            $privilegeUser->lastname = $user->lastname;
            $privilegeUser->fullname = $user->firstname . ' ' . $user->lastname;
            $privilegeUser->gravatar = $user->gravatar;
            $privilegeUser->status_id = $user->status_id;
//            $privilegeUser->is_active = $user->is_active;
            $privilegeUser->initRoles($userID ?: $user->id);
            return $privilegeUser;
        } else {
            return false;
        }
    }

    /**
     * populate roles with their associated permissions
     * @return void
     */
    public function initRoles(int $userID)
    {
        $this->roles = [];
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1 JOIN roles as t2 ON t1.role_id = t2.id WHERE t1.user_id = :user_id";
        $row = (new UserRoleModel())
            ->getRepository()
            ->getEm()
            ->getCrud()
            ->rawQuery($sql, ['user_id' => $userID], 'fetch_all');
        if ($row) {
            foreach ((array)$row as $r) {
                $this->roles[$r['role_name']] = Role::getRolePermissions($r['role_id']);
            }
            return $this->roles;

        }

    }

    /**
     * Check is a user has a specific privilege
     */
    public function hasPrivilege($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether the current role ID is link to any permission
     */
    public function hasRolePrivilege(int $roleID): bool
    {
        return $this->getPermissionByRoleID($roleID);
    }

    /**
     * Check if a user a specific role
     */
    public function hasRole($role): bool
    {
        return isset($this->roles[$role]);
    }

    /**
     * return the current login user role as a capitalized string
     * @return string|false
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
     * Returns an array of the current logged-in user assigned permissions
     * @return array
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

    public function getRoleByGroupID(int $groupID)
    {
        $roles = Role::getRoleGroups($groupID);
        foreach ((array)$roles as $role) {
            return $role;
        }
    }

}