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

namespace Evo\Cache\Storage;

interface CacheStorageInterface
{

    /**
     * Saves data in the cache.
     */
    public function setCache(string $key, string $value, int $ttl = null): void;

    /**
     * Loads data from the cache.
     */
    public function getCache(string $key);

    /**
     * Checks if a cache entry with the specified identifier exists.
     */
    public function hasCache(string $key): bool;

    /**
     * Removes all cache entries matching the specified identifier.
     * Usually this only affects one entry but if - for what reason ever -
     * old entries for the identifier still exist, they are removed as well.
     */
    public function removeCache(string $key): bool;

    /**
     * Removes all cache entries of this cache.
     */
    public function flush(): void;

    /**
     * Does garbage collection
     */
    public function collectGarbage(): void;
}
