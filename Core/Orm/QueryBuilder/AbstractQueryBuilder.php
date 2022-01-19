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

abstract class AbstractQueryBuilder implements QueryBuilderInterface
{
    protected array $key = [];
    protected string $sqlQuery = '';

    protected const SQL_DEFAULT = [
        'conditions' => [],
        'selectors' => [],
        'replace' => false,
        'distinct' => false,
        'from' => [],
        'where' => null,
        'and' => [],
        'or' => [],
        'orderby' => [],
        'fields' => [],
        'primary_key' => '',
        'table' => '',
        'type' => '',
        'raw' => '',

        'join_to' => '',
        'join_to_selectors' => [],
        'join_type' => '',
    ];

    protected const QUERY_TYPES = ['insert', 'select', 'update', 'delete', 'raw', 'search', 'join'];

    public function __construct()
    {}

    protected function orderByQuery()
    {
        // Append the orderby statement if set
        if (isset($this->key["extras"]["orderby"]) && $this->key["extras"]["orderby"] != "") {
            $this->sqlQuery .= " ORDER BY " . $this->key["extras"]["orderby"] . " ";
        }
    }

    protected function queryOffset()
    {
        // Append the limit and offset statement for adding pagination to the query
        if (isset($this->key["params"]["limit"]) && $this->key["params"]["offset"] != -1) {
            $this->sqlQuery .= " LIMIT :offset, :limit";
        }

    }

    protected function isQueryTypeValid(string $type) : bool
    {
        if (in_array($type, self::QUERY_TYPES)) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether a key is set. returns true or false if not set
     */
    protected function has(string $key): bool
    {
        return isset($this->key[$key]);
    }

    public function getSqlDefaults(): array
    {
        return self::SQL_DEFAULT;
    }

    public function getQueryTypes(): array
    {
        return self::QUERY_TYPES;
    }

    public function aliasSelectors(string $parent, array $selectors, $default = ['*']): array
    {
        $filter = array_map(
            fn ($selector): string => $parent . '.' . $selector,
            $selectors
        );
        return (empty($filter)) ? $default : $filter;
    }


}
