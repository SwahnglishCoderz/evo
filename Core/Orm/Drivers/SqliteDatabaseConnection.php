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

use Exception;
use PDO;
use PDOException;
use Evo\Orm\Exception\DataLayerException;
use Evo\Orm\Exception\DataLayerInvalidArgumentException;

class SqliteDatabaseConnection extends AbstractDatabaseDriver
{

    /** @var string $driver */
    protected const PDO_DRIVER = 'sqlite';
    private object $environment;
    private string $pdoDriver;

    /**
     * Class constructor. piping the class properties to the constructor
     * method. The constructor will throw an exception if the database driver
     * doesn't match the class database driver.
     */
    public function __construct(object $environment, string $pdoDriver)
    {
        $this->environment = $environment;
        $this->pdoDriver = $pdoDriver;
        if (self::PDO_DRIVER !== $this->pdoDriver) {
            throw new DataLayerInvalidArgumentException(
                $pdoDriver . ' Invalid database driver pass requires ' . self::PDO_DRIVER . ' driver option to make your connection.'
            );
//            echo $pdoDriver . ' Invalid database driver pass requires ' . self::PDO_DRIVER . ' driver option to make your connection.';
        }
    }

    /**
     * Opens a new Sqlite database connection
     * @throws Exception
     */
    public function open(): PDO
    {
        try {
            return new PDO(
                $this->credential->getDsn($this->driver),
                $this->credential->getDbUsername(),
                $this->credential->getDbPassword(),
                $this->params
            );
        } catch(PDOException $e) {
            throw new DataLayerException($e->getMessage(), (int)$e->getCode());
//            throw new Exception($e->getMessage(), (int)$e->getCode());
        }

    }

}
