<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evo\Cache\Storage;

use Evo\Base\Exception\BaseException;
use Evo\Cache\Exception\CacheException;
use Evo\Utility\Files;

class FiveHundredCacheStorage extends AbstractCacheStorage
{
    use CacheStorageTrait;

    /**
     * Undocumented function
     */
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
        $value = var_export($value, true);
        // HHVM fails at __set_state, so just use object cast for now
        $value = str_replace('stdClass::__set_state', '(object)', $val);
        // Write to temp file first to ensure atomicity
        $tmp = "/tmp/$key" . uniqid('', true) . '.tmp';
        file_put_contents($tmp, '<?php $val = ' . $val . ';', LOCK_EX);
        rename($tmp, "/tmp/$key");
    }

    public function getCache(string $key)
    {
        @include "/tmp/$key";
        return isset($value) ? $value : false;
//        $this->isCacheValidated($key, false);
//        $cacheEntryPathAndFilename = $this->cacheEntryPathAndFilename($key);
//        if (!file_exists($cacheEntryPathAndFilename)) {
//            return false;
//        }
//
//        return $this->readCacheFile($cacheEntryPathAndFilename);
    }

    public function hasCache(string $key): bool
    {
        $this->isCacheValidated($key, false);
        return file_exists($this->cacheEntryPathAndFilename($key));
    }

    public function removeCache(string $key): bool
    {
//        $this->isCacheValidated($key);
//        $cacheEntryPathAndFilename = $this->cacheEntryPathAndFilename($key);
//        for ($i = 0; $i < 3; $i++) {
//            $result = $this->tryRemoveWithLock($cacheEntryPathAndFilename);
//            if ($result === true) {
//                clearstatcache(true, $cacheEntryPathAndFilename);
//                return true;
//            }
//            usleep(rand(10, 500));
//        }
//
//        return false;
    }

    public function flush(): void
    {
        Files::emptyDirectoryRecursively($this->cacheDirectory);
    }

    public function collectGarbage(): void
    {
    }

}