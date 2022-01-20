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

namespace Evo\Orm\ClientRepository;

use Evo\Orm\Exception\DataLayerInvalidArgumentException;

interface ClientRepositoryInterface
{

    /**
     * Find and return an item by its ID
     */
    public function find(int $id) : array;

    /**
     * Find and return all table rows as an array
     */
    public function findAll() : array;

    /**
     * Find and return 1 or more rows by various argument which are optional by default
     */
    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array;

    /**
     * Find and Return 1 row by the method argument
     */
    public function findOneBy(array $conditions) : array;

    /**
     * Returns a single row from the storage table as an object
     */
    public function findObjectBy(array $conditions = [], array $selectors = []) : ?Object;

    /**
     * Returns the search results based on the user search conditions and parameters
     */
    public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array;

    /**
     * Delete bulk item from a database table by simple providing an array of IDs to
     * which you want to delete.
     */
    public function findAndDelete(array $items = []) : bool;

    /**
     * Find and delete a row by its ID from storage device
     */
    public function findByIdAndDelete(array $conditions) : bool;

    /**
     * Update the queried row and return true on success. We can use the second argument
     * to specify which column to update by within the where clause
     */
    public function findByIdAndUpdate(array $fields, int $id) : bool;

    /**
     * Returns the storage data as an array along with formatted paginated results. This method
     * will also return queried search results
     */
    public function findWithSearchAndPaging(Object $request, array $args = [], array $relationship = []) ;

    /**
     * Find and item by its ID and return the object row else return 404 with the or404 chaining method
     */
    public function findAndReturn(int $id, array $selectors = []) : self;

    /**
     * Returns 404 error page if the findAndReturn method or property returns empty or null
     */
    public function or404(): ?object;

}
