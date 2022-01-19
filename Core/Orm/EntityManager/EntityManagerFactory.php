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

namespace Evo\Orm\EntityManager;

use Evo\Orm\Exception\DataLayerUnexpectedValueException;
use Evo\Orm\QueryBuilder\QueryBuilderInterface;
use Evo\Orm\DataMapper\DataMapperInterface;

class EntityManagerFactory
{
    protected DataMapperInterface $dataMapper;
    protected QueryBuilderInterface $queryBuilder;

    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Create the entityManager object and inject the dependency which is the crud object
     */
    public function create(string $crudString, string $tableSchema, string $tableSchemaID) : EntityManagerInterface
    {
        $crudObject = new $crudString($this->dataMapper, $this->queryBuilder, $tableSchema, $tableSchemaID);
        if (!$crudObject instanceof CrudInterface) {
            throw new DataLayerUnexpectedValueException($crudString . ' is not a valid crud object.');
//            echo $crudString . ' is not a valid crud object.';
        }
        return new EntityManager($crudObject);
    }

}
