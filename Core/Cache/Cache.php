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

//use JetBrains\PhpStorm\Pure;
use Evo\Cache\Exception\CacheException;
use Evo\Cache\Storage\CacheStorageInterface;
use Throwable;

class Cache extends AbstractCache
{
    public function __construct(?string $cacheIdentifier, CacheStorageInterface $storage, array $options = [])
    {
        parent::__construct($cacheIdentifier, $storage, $options);
    }

    public function set(string $key, $value, ?int $ttl = null): bool
    {
        $this->ensureCacheEntryIdentifierIsvalid($key);
        try {
            $this->storage->setCache($key, serialize($value), $ttl);
        } catch (Throwable $throwable) {
            throw new CacheException('An exception was thrown in retrieving the key from the cache repository.', 0, $throwable);
        }

        return true;
    }

    public function get(string $key, $default = null)
    {
        $this->ensureCacheEntryIdentifierIsvalid($key);
        try {
            $data = $this->storage->getCache($key);
        } catch (Throwable $throwable) {
            throw new CacheException('An exception was thrown in retrieving the key from the cache backend.', 0, $throwable);
        }
        if ($data === false) {
            return $default;
        }
        return unserialize((string)$data);
    }

    public function delete(string $key): bool
    {
        $this->ensureCacheEntryIdentifierIsvalid($key);
        try {
            $this->storage->removeCache($key);
        } catch (Throwable $throwable) {
            throw new CacheException('An exception was thrown in retrieving the key from the cache backend.', 0, $throwable);
        }
        return true;
    }

    public function clear(): bool
    {
        $this->storage->flush();
        return true;
    }

    public function getMultiple(iterable $keys, $default = null): iterable
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }

        return $result;
    }

    public function setMultiple(iterable $values, ?int $ttl = null): bool
    {
        $all = true;
        foreach ($values as $key => $value) {
            $all = $this->set($key, $value, $ttl) && $all;
        }

        return $all;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function has(string $key): bool
    {
        $this->ensureCacheEntryIdentifierIsvalid($key);
        return $this->storage->hasCache($key);
    }
}
