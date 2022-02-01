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

//use Evo\Orm\Exception\DataLayerException;
use Evo\Orm\Drivers\DatabaseDriverInterface;
//use Evo\Orm\Exception\DataLayerNoValueException;
use Evo\Orm\DatabaseTransaction\DatabaseTransaction;
//use Evo\Orm\Exception\DataLayerInvalidArgumentException;
//use Evo\Base\Exception\BaseInvalidArgumentException;
use Exception;
use PDOStatement;
use PDO;

class DataMapper extends DatabaseTransaction implements DataMapperInterface
{
    private DatabaseDriverInterface $dbh;
    private PDOStatement $statement;

    public function __construct(DatabaseDriverInterface $dbh)
    {
        $this->dbh = $dbh;
        parent::__construct($this->dbh); /* Pass to DatabaseTransaction class */
    }

    /**
     * Check the incoming $value isn't empty else throw an exception
     */
    private function isEmpty($value, string $errorMessage = null)
    {
        if (empty($value)) {
//            throw new DataLayerNoValueException($errorMessage);
            echo "Error: $errorMessage";
        }
    }

    /**
     * Check the incoming argument $value is an array else throw an exception
     */
    private function isArray(array $value)
    {
        if (!is_array($value)) {
//            throw new DataLayerInvalidArgumentException('Your argument needs to be an array');
            echo 'Your argument needs to be an array';
        }
    }

    public function getConnection(): DatabaseDriverInterface
    {
        return $this->dbh;
    }

    public function prepare(string $sqlQuery): self
    {
        $this->isEmpty($sqlQuery, 'Invalid or empty query string passed.');
        $this->statement = $this->dbh->open()->prepare($sqlQuery);
        return $this;
    }

    public function bind($value): int
    {
//        return match ($value) {
//            is_bool($value) => PDO::PARAM_BOOL,
//            intval($value) => PDO::PARAM_INT,
//            is_null($value) => PDO::PARAM_NULL,
//            default => PDO::PARAM_STR,
//        };

        switch ($value) {
            case is_bool($value):
                return PDO::PARAM_BOOL;
                break;
            case intval($value):
                return PDO::PARAM_INT;
                break;
            case is_null($value):
                return PDO::PARAM_NULL;
                break;
            default:
                return PDO::PARAM_STR;
                break;
        }
    }

    public function bindParameters(array $fields, bool $isSearch = false): self
    {
        $this->isArray($fields);
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
            if ($type) {
                return $this;
            }
        }
    }

    /**
     * Binds a value to a corresponding name or question mark placeholder in the SQL
     * statement that was used to prepare the statement
     */
    protected function bindValues(array $fields): PDOStatement
    {
        $this->isArray($fields); // don't need
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, $value, $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * Binds a value to a corresponding name or question mark placeholder
     * in the SQL statement that was used to prepare the statement. Similar to
     * above but optimised for search queries
     */
    protected function bindSearchValues(array $fields): PDOStatement
    {
        $this->isArray($fields); // don't need
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key,  '%' . $value . '%', $this->bind($value));
        }
        return $this->statement;
    }

    public function execute(): bool
    {
        if ($this->statement)
            return $this->statement->execute();
    }

    public function numRows(): int
    {
        if ($this->statement)
            return $this->statement->rowCount();
    }

    public function result(): Object
    {
        if ($this->statement)
            return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    public function results(): array
    {
        if ($this->statement)
            return $this->statement->fetchAll();
    }

    public function column()
    {
        if ($this->statement)
            return $this->statement->fetchColumn();
    }

    public function columns(): array
    {
        if ($this->statement)
            return $this->statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getLastId(): int
    {
        if ($this->dbh->open()) {
            $lastID = $this->dbh->open()->lastInsertId();
            if (!empty($lastID)) {
                return intval($lastID);
            }
        }
    }

    /**
     * Returns the query condition merged with the query parameters
     */
    public function buildQueryParameters(array $conditions = [], array $parameters = []): array
    {
        return (!empty($parameters) || (!empty($conditions)) ? array_merge($conditions, $parameters) : $parameters);
    }

    /**
     * Persist queries to database
     * @throws Exception
     */
    public function persist(string $sqlQuery, array $parameters): void
    {
        //$this->start();
        try {
            $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
            //$this->commit();
        } catch (Exception $e) {
            //$this->revert();
//            throw new DataLayerException($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Quickly execute commands through command line.
     * @throws Exception
     */
    public function exec(string $statement): void
    {
        $this->start();
        try {
            $this->dbh->open()->exec($statement);
            $this->commit();
        } catch (Exception $e) {
            $this->revert();
//            throw new DataLayerException($e->getMessage());
            throw new Exception($e->getMessage());
        }

    }

}
