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

namespace Evo\Collection;

use Countable;
use ArrayAccess;
use IteratorAggregate;

interface CollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{

    /**
     * Returns all the items within the collection
     */
    public function all(): array;

    /**
     * Checks whether a given key exists within the collection
     */
    public function has(string $key): bool;

    /**
     * Returns all the keys of the collection items
     */
    public function keys(): array;

    /**
     * Run a map over each items
     */
    public function map(callable $callback);

    public function avg();

    /**
     * Calculates the sum of values within the specified array
     */
    public function sum();

    public function min();

    public function max();

    /**
     * Create a collection with the specified ranges
     */
    public function  range($from, $to);

    /**
     * Merge the collection with the given argument
     */
    public function merge($items);

    /**
     * Recursively merge the collection with the given argument
     */
    public function mergeRecursive($items);

    /**
     * Pop an element off the end of the item collection
     */
    public function pop();

    /**
     * Push elements on the end of the collection items
     */
    public function push(...$values): self;

    /**
     * Returns the item collection in reverse order
     */
    public function reverse();

    /**
     * Shift the first element of the collection items
     */
    public function shift();

    /**
     * Extract a slice of the collection items
     */
    public function slice(int $offset, $length = null);

    /**
     * Returns the values of the collection items
     */
    public function values();

    /**
     * Count the number of items within the collection items
     */
    public function size(): int;

    /**
     * Add an item to the collection
     */
    public function add($item): self;

    /**
     * Remove the item from the collection
     */
    public function remove(string $key): void;

    /**
     * Removes duplicate entry from the collection items
     */
    public function unique();

    /**
     * Returns the items in the collection which is not within the specified index array
     */
    public function diff($items);

    /**
     * Returns the items in the collection which is not within the specified associative array
     */
    public function diffAssoc($items);

    /**
     * Returns the items in the collection whose keys and values is not within the 
     * specified associative array, using the callback
     */
    public function diffAssocUsing($items, callable $callback);

    /**
     * Returns the items in the collection whose keys in not within the specified 
     * index array
     */
    public function diffKeys($items);

    /**
     * Returns the items in the collection whose keys in not within the specified 
     * index array, using the callback
     */
    public function diffKeysUsing($items, callable $callback);

    public function filter(callable $callback = null);

    public function offsetExists($key);

    public function offsetGet($key);

    public function offsetSet($key, $value);

    public function offsetUnset($key);

    public function getIterator();

    /**
     * Alias of $this->size method
     */
    public function count(): int;
}
