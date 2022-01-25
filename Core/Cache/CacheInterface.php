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

namespace Evo\Cache;

use Evo\Cache\Exception\CacheRepositoryInvalidArgumentException;

/**
 * Interface CacheInterface
 * @package Core\Cache
 */
interface CacheInterface
{
    /**
     * Fetches a value from the cache.
     */
    public function get(string $key, $default = null);

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     */
    public function set(string $key, $value, ?int $ttl = null): bool;

    /**
     * Delete an item from the cache by its unique key.
     */
    public function delete(string $key): bool;

    /**
     * Wipes clean the entire cache's keys.
     */
    public function clear(): bool;

    /**
     * Obtains multiple cache items by their unique keys.
     */
    public function getMultiple(iterable $keys, $default = null): iterable;

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     */
    public function setMultiple(iterable $values, ?int $ttl = null): bool;

    /**
     * Deletes multiple cache items in a single operation.
     */
    public function deleteMultiple(iterable $keys): bool;

    /**
     * Determines whether an item is present in the cache.
     *
     * NOTE: It is recommended that has() is only to be used for cache warming type purposes
     * and not to be used within your live applications operations for get/set, as this method
     * is subject to a race condition where your has() will return true and immediately after,
     * another script can remove it, making the state of your app out of date.
     */
    public function has(string $key): bool;
}
