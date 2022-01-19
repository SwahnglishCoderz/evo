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

namespace Evo\Orm\EntityManager;

interface CrudInterface
{
    /**
     * Returns the storage schema name as string
     */
    public function getSchema(): string;

    /**
     * Returns the primary key for the storage schema
     */
    public function getSchemaID(): string;

    /**
     * Returns the last inserted ID
     *
     */
    public function lastID(): int;

    /**
     * Create method which inserts data within a storage table
     */
    public function create(array $fields = []): bool;

    /**
     * Returns an array of database rows based on the individual supplied arguments
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array;

    /**
     * Update method which update 1 or more rows of data with in the storage table
     */
    public function update(array $fields, string $primaryKey): bool;

    /**
     * Delete method which will permanently delete a row from the storage table
     */
    public function delete(array $conditions = []): bool;

    /**
     * Search method which returns queried search results
     */
    public function search(array $selectors = [], array $conditions = []): ?array;

    /**
     * Returns a custom query string. The second argument can assign and associate array
     * of conditions for the query string
     */
    public function rawQuery(string $rawQuery, ?array $conditions = [], string $resultType = 'column');

    /**
     * Returns a single table row as an object
     */
    public function get(array $selectors = [], array $conditions = []): ?Object;

    public function aggregate(string $type, ?string $field = 'id', array $conditions = []);

    /**
     * Returns the total number of records based on the method arguments
     */
    public function countRecords(array $conditions = [], ?string $field = 'id'): int;
}
