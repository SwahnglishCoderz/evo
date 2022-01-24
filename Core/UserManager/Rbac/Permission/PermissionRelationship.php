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

namespace Evo\UserManager\Rbac\Permission;

use Evo\UserManager\UserModel;
use Evo\UserManager\Model\UserRoleModel;
use Evo\UserManager\Rbac\Permission\PermissionModel;
use Evo\UserManager\Rbac\Model\RolePermissionModel;
use Evo\Orm\DataRelationship\Relationships\ManyToMany;
use Evo\Orm\DataRelationship\Relationships\OneToMany;
use Evo\Base\Contracts\BaseRelationshipInterface;

class PermissionRelationship extends UserModel implements BaseRelationshipInterface
{
    /**
     * self::class refers to this current class UserModel::class. Create the connection
     * between the different associated models and their pivoting table. In order to
     * establish a relationship. First we need to pass the type of possible 3 relationships
     * ManyToMany, OneToMany or OneToOne with the addRelationship method. Then add both
     * reference table within the table method then the pivot table to the pivot method.
     * Once we complete this we will have access to the methods within the type of relationships
     * we wish to use methods from.
     *
     * @return object
     */
    public function united(): object
    {
        return $this->setRelationship(ManyToMany::class)
            ->belongsToMany(RoleModel::class)->pivot(RolePermissionModel::class);
    }

}

