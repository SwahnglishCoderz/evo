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

use Evo\Orm\Drivers\DatabaseDriverInterface;
use PDO;

abstract class AbstractDatabaseDriver implements DatabaseDriverInterface
{
    protected array $params = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    private ?object $dbh;

    public function PdoParams(): array
    {
        return $this->params;
    }

    public function close()
    {
        $this->dbh = null;
    }
}