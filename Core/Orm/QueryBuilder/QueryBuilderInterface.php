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

namespace Evo\Orm\QueryBuilder;

use Exception;

interface QueryBuilderInterface
{

    public function insertQuery() : string;
    public function selectQuery() : string;
    public function updateQuery() : string;
    public function deleteQuery() : string;

    public function searchQuery() : string;

    public function rawQuery() : string;

}
