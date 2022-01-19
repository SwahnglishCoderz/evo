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

namespace Evo\Orm\Drivers;

use Evo\Orm\Exception\DataLayerUnexpectedValueException;

class DatabaseDriverFactory
{
    /**
     * Create and return the database driver object. Passing the object environment and
     * default database driver to the database driver constructor method.
     */
    public function create(object $environment, ?string $dbDriverConnection, string $pdoDriver): DatabaseDriverInterface
    {
//        if (is_object($environment)) {
            $dbConnection = ($dbDriverConnection !==null) ? new $dbDriverConnection($environment, $pdoDriver) : new MysqlDatabaseConnection($environment, $pdoDriver);
            if (!$dbConnection instanceof DatabaseDriverInterface) {
                throw new DataLayerUnexpectedValueException();
            }

            return $dbConnection;
//        }
    }


}