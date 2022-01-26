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

namespace Evo\Orm\DataMapper;

use Evo\Utility\Yaml;
use App\Config;
use Evo\Orm\DataLayerEnvironment;

class DataMapperFactory
{

    /**
     * Creates the data mapper object and inject the dependency for this object. We are also
     * creating the DatabaseConnection Object and injecting the environment object. Which will
     * expose the environment methods with the database connection class.
     */
    public function create(string $databaseDriverFactory, DataLayerEnvironment $environment): DataMapperInterface
    {
        $params = $this->resolvedDatabaseParameters();
        $dbObject = (new $databaseDriverFactory())->create($environment, $params['class'], $params['driver']);
        return new DataMapper($dbObject);
    }

    /**
     * Return the application parameters as they were defined within the config
     * yaml file
     */
    private function resolvedDatabaseParameters(): array
    {
        $database = Config::APP['database'];
        if (is_array($database) && count($database) > 0) {
            foreach ($database['drivers'] as $driver => $class) {
                if (isset($driver) && $driver === $database['default_driver']) {
                    return array_merge($class, ['driver' => $driver]);
                }
            }
        }
    }
}
