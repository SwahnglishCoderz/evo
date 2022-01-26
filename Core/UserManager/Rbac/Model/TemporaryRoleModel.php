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

namespace Evo\UserManager\Rbac\Model;

use Evo\UserManager\Rbac\Entity\TemporaryRoleEntity;
use Evo\Base\AbstractBaseModel;
use Evo\Base\Exception\BaseInvalidArgumentException;

class TemporaryRoleModel extends AbstractBaseModel
{

    /** @var string */
    protected const TABLESCHEMA = 'temporary_role';
    /** @var string */
    protected const TABLESCHEMAID = 'id';

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws BaseInvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, TemporaryRoleEntity::class);
    }

    /**
     * Guard these IDs from being deleted etc..
     */
    public function guardedID(): array
    {
        return [
        ];
    }

}
