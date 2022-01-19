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

use PDOException;

interface DatabaseTransactionInterface
{

    /**
     * Begin a transaction, turning off autocommit
     */
    public function start() : bool;

    /**
     * Commits a transaction
     */
    public function commit () : bool;

    /**
     * Rolls back a transaction
     */
    public function revert() : bool;

}