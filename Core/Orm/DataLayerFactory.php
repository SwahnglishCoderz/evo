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

namespace Evo\Orm;

use Evo\Orm\DataMapper\DataMapperFactory;
use Evo\Orm\Drivers\DatabaseDriverFactory;
use Evo\Orm\EntityManager\EntityManagerFactory;
use Evo\Orm\QueryBuilder\QueryBuilderFactory;
use Evo\Orm\QueryBuilder\QueryBuilder;
use Evo\Orm\EntityManager\Crud;

class DataLayerFactory
{
    protected string $tableSchema;
    protected string $tableSchemaID;
    protected DataLayerEnvironment $environment;

    public function __construct(DataLayerEnvironment $environment, string $tableSchema, string $tableSchemaID)
    {
        $this->environment = $environment;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
    }

    /**
     * build method which glues all the components together and inject the necessary
     * dependency within the respective object
     */
    public function dataEntityManagerObject() : Object
    {
        /* build the data mapper factory object */
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseDriverFactory::class, $this->environment);
        if ($dataMapper) {
            /* build the query builder factory object */
            $queryBuilderFactory = new QueryBuilderFactory();
            /* todo we will need to have a QueryBuilderDriverFactory::class which loads the relevant query based on the database driver selected */
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
            if ($queryBuilder) {
                /* build the entity manager factory object */
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchemaID);
            }
        }
    }

}
