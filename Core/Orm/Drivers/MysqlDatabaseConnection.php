<?php

namespace Evo\Orm\Drivers;

use Evo\Orm\Drivers\AbstractDatabaseDriver;
use Evo\Orm\Exception\DataLayerException;
use Evo\Orm\Exception\DataLayerInvalidArgumentException;
use Exception;
use PDO;
use PDOException;

class MysqlDatabaseConnection extends AbstractDatabaseDriver
{

    protected string $pdoDriver;

    protected const PDO_DRIVER = 'mysql';
    private object $environment;

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
//            echo $pdoDriver . 'Invalid database driver pass requires ' . self::PDO_DRIVER . ' driver option to make your connection.';
        }
    }

    /**
     * Opens a new Mysql database connection
     * @throws Exception
     */
    public function open(): PDO
    {
        try {
            return new PDO(
                $this->environment->getDsn(),
                $this->environment->getDbUsername(),
                $this->environment->getDbPassword(),
                $this->params
            );
        } catch (PDOException $e) {
            throw new DataLayerException($e->getMessage(), (int)$e->getCode());
//            throw new Exception($e->getMessage(), (int)$e->getCode());
//            echo 'Code: ' . (int)$e->getCode() . '<br />Message: ' . $e->getMessage();
        }
    }
}