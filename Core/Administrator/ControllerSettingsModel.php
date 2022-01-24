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

namespace Evo\Administrator;

use Evo\Base\AbstractBaseModel;
use Evo\Administrator\ControllerSettingsEntity;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Throwable;

class ControllerSettingsModel extends AbstractBaseModel
{
    protected const TABLESCHEMA = 'controller_settings';
    protected const TABLESCHEMAID = 'id';
    public const COLUMN_STATUS = [];


    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws Throwable
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, ControllerSettingsEntity::class);
    }

    /**
     * Guard these IDs from being deleted etc...
     */
    public function guardedID(): array
    {
        return [];
    }

}

