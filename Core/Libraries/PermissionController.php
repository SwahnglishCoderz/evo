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

namespace Evo\Libraries;

class PermissionController extends AdminController
{
    /**
     * Extends the base constructor method. Which gives us access to all the base
     * methods implemented within the base controller class.
     * Class dependency can be loaded within the constructor by calling the
     * container method and passing in an associative array of dependency to use within
     * the class
     */
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
        /**
         * Dependencies are defined within a associative array like example below
         * [ PermissionModel => \App\Model\PermissionModel::class ]. Where the key becomes the
         * property for the PermissionModel object like so $this->PermissionModel->getRepository();
         */
        $this->addDefinitions(
            [
//                'repository' => PermissionModel::class,
//                'entity' => PermissionEntity::class,
//                'column' => PermissionColumn::class,
//                'commander' => PermissionCommander::class,
//                'formPermission' => PermissionForm::class,
//                'rolePerm' => RolePermissionModel::class,
            ]
        );

    }

    /**
     * Returns a 404 error page if the data is not present within the database
     * else return the requested object
     */
    public function findOr404()
    {
        return $this->repository->getRepository()
            ->findAndReturn($this->thisRouteID())
            ->or404();
    }
}