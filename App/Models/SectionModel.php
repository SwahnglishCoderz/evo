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
use App\Token;
use Evo\Base\AbstractBaseModel;
use Evo\Base\Exception\BaseException;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\View;
use Throwable;

class SectionModel extends AbstractBaseModel
{
    protected const TABLESCHEMA = 'section';
    protected const TABLESCHEMAID = 'id';
    protected array $dirtyData = [];
    protected array $sanitizedData = [];

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws Throwable
     */
    public function __construct(array $dirtyData)
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, SectionEntity::class);
//        print_r($this->entity);
        $this->dirtyData = $dirtyData;
    }

    /**
     * Guard these IDs from being deleted etc...
     */
    public function guardedID(): array
    {
        return [];
    }

    /**
     * @throws BaseException
     */
    private function cleanData(){
        print_r($this->entity->wash($this->dirtyData)->rinse()->dry());
        exit;
    }

    public function getSanitizedData()
    {
        $data = $this->sanitizedData;
    }

    public function save(): bool
    {
        echo '<pre>Saving the data';
        print_r($this->sanitizedData);

    }
}