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

namespace Evo\UserManager\Repository;

use Evo\UserManager\Model\UserRoleModel;
//use JetBrains\PhpStorm\ArrayShape;

class UserRoleRepository extends UserRoleModel
{
    public function getRepoSchemaID(): string
    {
        return 'user_id';
    }

    #[ArrayShape(['user_id' => "int"])] public function getRepoUserIDArray(int $userID): array
    {

        return ['user_id' => $userID];
    }

    public function getUserRoleID(object $controller): array
    {
        return $controller->flattenArray($controller->userRole->getRepo()->findBy(['role_id'], ['user_id' => $controller->thisRouteID()]));

    }
}

