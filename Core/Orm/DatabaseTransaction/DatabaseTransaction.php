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

namespace Evo\Orm\DatabaseTransaction;

use Exception;
use PDOException;
use LogicException;
use Evo\Orm\Exception\DataLayerException;
use Evo\Orm\Drivers\DatabaseDriverInterface;

class DatabaseTransaction implements DatabaseTransactionInterface
{

    private DatabaseDriverInterface $db;
    private int $transactionCounter = 0;

    /**
     * Main class constructor method which accepts the database connection object
     * which is then pipe to the class property (db)
     */
    public function __construct(DatabaseDriverInterface $db)
    {
        $this->db = $db;
        if (!$this->db) {
            throw new LogicException('No Database connection was detected.');
        }
    }

    /**
     * @throws Exception
     */
    public function start(): bool
    {
        try {
            if ($this->db) {
                if (!$this->transactionCounter++) {
                    return $this->db->open()->beginTransaction();
                }
                return $this->db->open()->beginTransaction();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function commit(): bool
    {
        try {
            if ($this->db) {
                if (!$this->transactionCounter) {
                    return $this->db->open()->commit();
                }
                return $this->transactionCounter >= 0;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function revert(): bool
    {
        try {
            if ($this->db) {
                if ($this->transactionCounter >= 0) {
                    $this->transactionCounter = 0;
                    return $this->db->open()->rollBack();
                }
                $this->transactionCounter = 0;
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
