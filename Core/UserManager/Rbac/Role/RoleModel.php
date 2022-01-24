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

namespace Evo\UserManager\Rbac\Role;

use App\Relationships\UserRelationship;
use App\Relationships\PermissionRelationship;
use Exception;
use Evo\Base\AbstractBaseModel;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Utility\Yaml;

class RoleModel extends AbstractBaseModel
{

    /** @var string */
    protected const TABLESCHEMA = 'roles';
    /** @var string */
    protected const TABLESCHEMAID = 'id';
     /**/
    public const COLUMN_STATUS = [];
    /** @var array $fillable - an array of fields that should not be null */
    protected array $fillable = [
        'role_name',
        'role_description',
        'created_byid',
    ];

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     *
     * @return void
     * @throws BaseInvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, RoleEntity::class);
    }

    /**
     * Guard these IDs from being deleted etc..
     *
     * @return array
     * @throws Exception
     */
    public function guardedID(): array
    {
        $system = Yaml::file('app')['system'];
        return [
            $system['super_role']['props']['id'],
            $system['default_role']['props']['id']
        ];
    }

    /**
     * Return an array of column values if table supports the column field
     *
     * @return array
     */
    public function getColumnStatus(): array
    {
        return self::COLUMN_STATUS;
    }

    /**
     * Return the name the role name based on the passed in role id argument
     * @param $id
     * @return mixed
     */
    public function getNameForSelectField($id)
    {
        return $this->getSelectedNameField($id, 'role_name');
    }

    public function user()
    {
        return $this->getRelationship(UserRelationship::class);
    }

    public function permission()
    {
        return $this->getRelationship(PermissionRelationship::class);
    }


}
