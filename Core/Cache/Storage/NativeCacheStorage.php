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

use Exception;
use JetBrains\PhpStorm\Pure;
use Evo\Cache\Exception\CacheException;
use Evo\Utility\Files;

class NativeCacheStorage extends AbstractCacheStorage
{

    use CacheStorageTrait;

    public function __construct(Object $envConfigurations, array $options = [])
    {
        parent::__construct($envConfigurations, $options);
    }

    /**
     * Saves data in a cache file.
     */
    public function setCache(string $key, string $value, int $ttl = null): void
    {
        $this->isCacheValidated($key);
        $cacheEntryPathAndFilename = $this->cacheEntryPathAndFilename($key);
        $result = $this->writeCacheFile($cacheEntryPathAndFilename, $value);
        if ($result !== false) {
            return;
        }
        throw new CacheException('The cache file "' . $cacheEntryPathAndFilename . '" could not be written.', 0);
    }

    public function getCache(string $key)
    {
        $this->isCacheValidated($key, false);
        $cacheEntryPathAndFilename = $this->cacheEntryPathAndFilename($key);
        if (!file_exists($cacheEntryPathAndFilename)) {
            return false;
        }

        return $this->readCacheFile($cacheEntryPathAndFilename);
    }

    public function hasCache(string $key): bool
    {
        $this->isCacheValidated($key, false);
        return file_exists($this->cacheEntryPathAndFilename($key));
    }

    public function removeCache(string $key): bool
    {
        $this->isCacheValidated($key);
        $cacheEntryPathAndFilename = $this->cacheEntryPathAndFilename($key);
        for ($i = 0; $i < 3; $i++) {
            $result = $this->tryRemoveWithLock($cacheEntryPathAndFilename);
            if ($result === true) {
                clearstatcache(true, $cacheEntryPathAndFilename);
                return true;
            }
            usleep(rand(10, 500));
        }

        return false;
    }

    public function flush(): void
    {
        Files::emptyDirectoryRecursively($this->cacheDirectory);
    }

    public function collectGarbage(): void
    {}

}
