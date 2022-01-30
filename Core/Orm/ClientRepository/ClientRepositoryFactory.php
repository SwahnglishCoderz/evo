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

namespace Evo\Orm\ClientRepository;

use Evo\System\Config;;
use Evo\Utility\Yaml;
use Evo\Orm\DataLayerFactory;
use Evo\Orm\DataLayerEnvironment;
use Evo\Orm\DataLayerConfiguration;
use Evo\Orm\Exception\DataLayerUnexpectedValueException;
use Symfony\Component\Dotenv\Dotenv;

class ClientRepositoryFactory
{
    protected string $tableSchema;
    protected string $tableSchemaID;
    protected string $crudIdentifier;

    public function __construct(string $crudIdentifier, string $tableSchema, string $tableSchemaID)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
    }

    /**
     * Create the ClientRepository Object. Which is the middle layer that interacts with
     * the application using this framework. The data repository object will have 
     * the required dependency injected by default. Which is the data layer facade object
     * which is simple passing in the entity manager object which expose the crud methods
     */
    public function create(string $dataRepositoryString, ?array $dataLayerConfiguration = null) : ClientRepositoryInterface
    {
        
        $dataRepositoryObject = new $dataRepositoryString($this->buildEntityManager($dataLayerConfiguration));
        if (!$dataRepositoryObject instanceof ClientRepositoryInterface ) {
            throw new DataLayerUnexpectedValueException($dataRepositoryString . ' is not a valid repository object');
        }
        return $dataRepositoryObject;
    }

    /**
     * Build entity manager which creates the data layer factory and passing in the
     * environment configuration array and symfony dotenv component. Which is used 
     * to set the database environment config.
     */
    public function buildEntityManager(?array $dataLayerConfiguration = null) : Object
    {
        $dataLayerEnvironment = new DataLayerEnvironment(
            new DataLayerConfiguration(
            Dotenv::class,
            ($dataLayerConfiguration !==null) ? $dataLayerConfiguration : NULL,
            ),
//            Yaml::file('app')['database']['default_driver'] /* second argument */
            Config::DATABASE['default_driver'] /* second argument */

        );
        $factory = new DataLayerFactory($dataLayerEnvironment, $this->tableSchema, $this->tableSchemaID);
        if ($factory) {
            return $factory->dataEntityManagerObject();
        }

    }

}
