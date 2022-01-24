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

use Evo\UserManager\Rbac\Model\RolePermissionModel;

class Role
{
    protected array $permissions;

    protected function __construct()
    {
        $this->permissions = [];
    }

    /**
     * return a role object with associated permissions
     */
    public static function getRolePermissions($roleID)
    {
        $role = new Role();
        $sql = "SELECT t2.permission_name FROM role_permission as t1 JOIN permissions as t2 ON t1.permission_id = t2.id WHERE t1.role_id = :role_id";
        $row = (new RolePermissionModel())
            ->getRepo()
            ->getEm()
            ->getCrud()
            ->rawQuery($sql, ['role_id' => $roleID], 'fetch_all');
        if ($row) {
            foreach ($row as $r) {
                $role->permissions[$r['permission_name']] = true;
            }
            return $role;
        }
    }

    /**
     * Check if a permission is set
     */
    public function hasPermission($permission): bool
    {
        return isset($this->permissions[$permission]);
    }

}
