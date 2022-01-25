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

use Evo\Cache\Exception\CacheInvalidArgumentException;
use Evo\Cache\Exception\CacheException;
use DirectoryIterator;

abstract class AbstractCacheStorage implements IterableStorageInterface
{
    use CacheStorageTrait;

    protected Object $envConfigurations;
    protected array $options;


    protected string $cacheDirectory = '';
    protected string $cacheEntryFileExtension = '';
    protected array $cacheEntryIdentifiers = [];

    protected DirectoryIterator $cacheFilesIterator;

    /**
     * Overrides the base directory for this cache,
     * the effective directory will be a subdirectory of this.
     * If not given this will be determined by the EnvironmentConfiguration
     */
    protected string $baseDirectory = '';

    public function __construct(Object $envConfigurations, array $options)
    {
        $this->envConfigurations = $envConfigurations;
        $this->options = $options;
    }

    /**
     * Sets the directory where the cache files are stored
     */
    public function setCacheDirectory(string $cacheDirectory): void
    {
        $this->cacheDirectory = rtrim($cacheDirectory, '/') . '/';
    }

    public function getCacheDirectory(): string
    {
        return $this->cacheDirectory;
    }

    public function getBaseDirectory(): string
    {
        return $this->baseDirectory;
    }

    public function setBaseDirectory(string $baseDirectory): void
    {
        $this->baseDirectory = $baseDirectory;
    }

    /**
     * Returns the cache identifier filename in its current directory path
     */
    protected function cacheEntryPathAndFilename(string $entryIdentifier): string
    {
        return $this->cacheDirectory . $entryIdentifier . $this->cacheEntryFileExtension;
    }

    /**
     * Tries to find the cache entry for the specified Identifier.
     */
    protected function findCacheFilesByIdentifier(string $entryIdentifier)
    {
        $cacheEntryPathAndFilename = $this->cacheEntryPathAndFilename($entryIdentifier);
        return (file_exists($cacheEntryPathAndFilename) ? [$cacheEntryPathAndFilename] : false);
    }

    /**
     * Checks if the given cache entry files are still valid or if their
     * lifetime has exceeded.
     */
    protected function isCacheFileExpired(string $cacheEntryPathAndFilename): bool
    {
        return (file_exists($cacheEntryPathAndFilename) === false);
    }

    protected function isCacheValidated(string $entryIdentifier, bool $all = true): void
    {
        if ($entryIdentifier !== basename($entryIdentifier)) {
            throw new CacheInvalidArgumentException('The specified cache identifier must not contain a path segment.', 1334756960);
        }
        if ($all) {
            if ($entryIdentifier === '') {
                throw new CacheInvalidArgumentException('The specified cache identifier must not be empty.', 1334756961);
            }
        }
    }

    protected function verifyCacheDirectory(): void
    {
        if (!is_dir($this->cacheDirectory) && !is_link($this->cacheDirectory)) {
            throw new CacheException('The cache directory "' . $this->cacheDirectory . '" does not exist.', 1203965199);
        }
        if (!is_writable($this->cacheDirectory)) {
            throw new CacheException('The cache directory "' . $this->cacheDirectory . '" is not writable.', 1203965200);
        }
    }

    /**
     * Returns the data of the current cache entry pointed to by the cache entry
     * iterator.
     */
    public function current()
    {
        if ($this->cacheFilesIterator === null) {
            $this->rewind();
        }

        $pathAndFilename = $this->cacheFilesIterator->getPathname();
        return $this->readCacheFile($pathAndFilename);
    }

    /**
     * Move forward to the next cache entry
     */
    public function next()
    {
        if ($this->cacheFilesIterator === null) {
            $this->rewind();
        }
        $this->cacheFilesIterator->next();
        while ($this->cacheFilesIterator->isDot() && $this->cacheFilesIterator->valid()) {
            $this->cacheFilesIterator->next();
        }
    }

    /**
     * Returns the identifier of the current cache entry pointed to by the cache
     * entry iterator.
     */
    public function key(): string
    {
        if ($this->cacheFilesIterator === null) {
            $this->rewind();
        }
        return $this->cacheFilesIterator->getBasename($this->cacheEntryFileExtension);
    }

    /**
     * Checks if the current position of the cache entry iterator is valid
     */
    public function valid(): bool
    {
        if ($this->cacheFilesIterator === null) {
            $this->rewind();
        }
        return $this->cacheFilesIterator->valid();
    }

    /**
     * Rewinds the cache entry iterator to the first element
     */
    public function rewind()
    {
        if ($this->cacheFilesIterator === null) {
            $this->cacheFilesIterator = new DirectoryIterator($this->cacheDirectory);
        }
        $this->cacheFilesIterator->rewind();
        while (substr($this->cacheFilesIterator->getFilename(), 0, 1) === '.' && $this->cacheFilesIterator->valid()) {
            $this->cacheFilesIterator->next();
        }
    }
}
