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

namespace Evo\Orm;

use Evo\Orm\ClientRepository\ClientRepository;
use Evo\Orm\ClientRepository\ClientRepositoryFactory;

class DataLayerClientFacade
{

    protected string $clientIdentifier;
    protected string $tableSchema;
    protected string $tableSchemaID;

    /**
     * Final class which ties the entire data layer together. The data layer factory
     * is responsible for creating an object of all the component factories and injecting
     * the relevant parameters/arguments. ie the query builder factory, entity manager
     * factory and the data mapper factory.
     */
    public function __construct(string $clientIdentifier, string $tableSchema, string $tableSchemaID)
    {
        $this->clientIdentifier = $clientIdentifier;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
    }

    /**
     * Returns the client repository object which allows external and internal 
     * component to use the methods within.
     */
    public function getClientRepository(): Object
    {
        $factory = new ClientRepositoryFactory($this->clientIdentifier, $this->tableSchema, $this->tableSchemaID);
        if ($factory) {
            $client = $factory->create(ClientRepository::class);
            if ($client) {
                return $client;
            }
        }
    }
}
