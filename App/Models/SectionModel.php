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
use Evo\Collection\CollectionInterface;
use Evo\Base\BaseView;
use Throwable;

class SectionModel extends AbstractBaseModel
{
    protected const TABLESCHEMA = 'section';
    protected const TABLESCHEMAID = 'id';
    protected array $dirtyData = [];
    protected CollectionInterface $sanitizedData;

    /**
     * Main constructor class which passes the relevant information to the
     * base model parent constructor. This allows the repository to fetch the
     * correct information from the database based on the model/entity
     * @throws Throwable
     */
    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID, SectionEntity::class);
//        print_r($this->entity);
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
    public function cleanData($dirtyData): self
    {
        $this->sanitizedData = $this->entity->wash($dirtyData)->rinse()->dry();
        return $this;
    }

    public function getSanitizedData(): array
    {
        $data = $this->sanitizedData;
        $assoc_array = [];

        foreach($this->sanitizedData as $key => $value)
        {
//            print_r($key);
//            echo '    ';
//            print_r($value);
//            echo '<br />';
            $assoc_array[$key] = $value;
        }
        return $assoc_array;
    }

    public function save()
    {
        $data_array = $this->getSanitizedData();
//        echo '<pre>Saving the data';
//        print_r($data_array);
        return $this->repository->getEm()->getCrud()->create($data_array);

    }
}