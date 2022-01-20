<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace App\Models;

use App\Entity\SectionEntity;
use Evo\Base\AbstractBaseModel;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Throwable;

class SectionModel extends AbstractBaseModel
{
    protected const TABLESCHEMA = 'section';
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
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, SectionEntity::class);
    }

    /**
     * Guard these IDs from being deleted etc...
     */
    public function guardedID(): array
    {
        return [];
    }

    /**
     * Return an array of column values if table supports the column field
     */
    public function getColumnStatus(): array
    {
        return self::COLUMN_STATUS;
    }

    public function getNameForSelectField($id)
    {
        $name = $this->getCurrentRepository()->findObjectBy(['id' => $id], ['name']);
        return $name->name;
    }

}