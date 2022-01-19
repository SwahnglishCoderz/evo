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

use ArrayIterator;
use Evo\Collection\CollectionTrait;
use Evo\Collection\CollectionInterface;

class Collection implements CollectionInterface
{

    use CollectionTrait;

    protected array $items = [];


    public function __construct($items = [])
    {
        $this->items = (array)$items;
    }

    /**
     * Returns all the items within the collection
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Checks whether a given key exists within the collection
     */
    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Returns all the keys of the collection items
     */
    public function keys(): array
    {
        return array_keys($this->items);
    }

    /**
     * Run a map over each items
     */
    public function map(callable $callback)
    {
        $items = array_map($callback, $this->items, $this->keys());
        return new static(array_combine($this->keys(), $items));
    }

    public function avg()
    {
        if ($size = $this->size()) {
            $array = array_filter($this->items);
            $avg = array_sum($array) / $size;
            return $avg;
        }
    }

    /**
     * Calculates the sum of values within the specified array
     */
    public function sum()
    {
        return new static(array_sum($this->items));
    }

    public function min()
    {
    }

    public function max()
    {
    }

    /**
     * Create a collection with the specified ranges
     */
    public function  range($from, $to)
    {
        return new static(range($from, $to));
    }

    /**
     * Merge the collection with the given argument
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $items));
    }

    /**
     * Recursively merge the collection with the given argument
     */
    public function mergeRecursive($items)
    {
        return new static(array_merge_recursive($this->items, $items));
    }

    /**
     * Pop an element off the end of the item collection
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Push elements on the end of the collection items
     */
    public function push(...$values): self
    {
        array_push($this->items, $values);
        return $this;
    }

    /**
     * Returns the item collection in reverse order
     */
    public function reverse()
    {
        return new static(array_reverse($this->items, true));
    }

    /**
     * Shift the first element of the collection items
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Extract a slice of the collection items
     */
    public function slice(int $offset, $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

    /**
     * Returns the values of the collection items
     */
    public function values()
    {
        return new static(array_values($this->items));
    }

    /**
     * Count the number of items within the collection items
     */
    public function size(): int
    {
        return count($this->items);
    }

    /**
     * Add an item to the collection
     */
    public function add($item): self
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Remove the item from the collection
     */
    public function remove(string $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * Removes duplicate entry from the collection items
     */
    public function unique()
    {
        return new static(array_unique($this->items));
    }

    /**
     * Returns the items in the collection which is not within the specified index array
     */
    public function diff($items)
    {
        return new static(array_diff($this->items, $items));
    }

    /**
     * Returns the items in the collection which is not within the the specified associative array
     */
    public function diffAssoc($items)
    {
        return new static(array_diff_assoc($this->items, $items));
    }

    /**
     * Returns the items in the collection whose keys and values is not within the 
     * specified associative array, using the callback
     */
    public function diffAssocUsing($items, callable $callback)
    {
        return new static(array_diff_uassoc($this->items, $items, $callback));
    }

    /**
     * Returns the items in the collection whose keys in not within the specified 
     * index array
     */
    public function diffKeys($items)
    {
        return new static(array_diff_key($this->items, $items));
    }

    /**
     * Returns the items in the collection whose keys in not within the specified 
     * index array, using the callback
     */
    public function diffKeysUsing($items, callable $callback)
    {
        return new static(array_diff_ukey($this->items, $items, $callback));
    }

    /**
     * Run a filter over each of the collection item
     */
    public function filter(callable $callback = null)
    {
        if ($callback) {
            return new static($this->where($this->items, $callback));
        }
        return new static(array_filter($this->items));
    }

    /**
     * Get the first item from the collection passing the given truth test.
     */
    public function first(?callable $callback = null, $default = null)
    {
        return $this->first($this->items, $callback, $default);
    }

    /**
     * Get the collection of items as a plain array.
     */
    public function toArray()
    {
        return $this->map(function ($value) {
            return $value;
        })->all();
    }

    public function offsetExists($key)
    {
        return isset($this->items[$key]);
    }

    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Alias of $this->size method
     */
    public function count(): int
    {
        return $this->size();
    }

    public function flat($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flat($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

}
