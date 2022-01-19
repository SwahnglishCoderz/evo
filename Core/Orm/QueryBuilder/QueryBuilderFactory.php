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

use Evo\Orm\Exception\DataLayerUnexpectedValueException;

class QueryBuilderFactory
{
    public function __construct()
    { }

    public function __create(string $queryBuilderString) : QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();
        if (!$queryBuilderString instanceof QueryBuilderInterface) {
            throw new DataLayerUnexpectedValueException($queryBuilderString . ' is not a valid Query builder object.');
//            echo $queryBuilderString . ' is not a valid Query builder object.';
        }
        return $queryBuilderObject;
    }

    /**
     * Create the QueryBuilder object
     */
    public function create(string $queryBuilderString) : QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();
        if (!$queryBuilderObject instanceof QueryBuilderInterface) {
            throw new DataLayerUnexpectedValueException($queryBuilderString . ' is not a valid Query builder object.');
//            echo $queryBuilderString . ' is not a valid Query builder object.';
        }
        return $queryBuilderObject;
    }


}
