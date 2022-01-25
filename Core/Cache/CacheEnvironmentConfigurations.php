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

class CacheEnvironmentConfigurations
{
    protected ?string $cacheIdentifier;
    protected ?string $fileCacheBasePath;
    protected int $maximumPathLength;

    public function __construct(
        ?string $cacheIdentifier,
        ?string $fileCacheBasePath,
        int $maximumPathLength = PHP_MAXPATHLEN
    ) {
        $this->cacheIdentifier = $cacheIdentifier;
        $this->fileCacheBasePath = $fileCacheBasePath;
        $this->maximumPathLength = $maximumPathLength;
    }

    /**
     * The maximum length of filenames (including path) supported by this build 
     * of PHP. Available since PHP
     */
    public function getMaximumPathLength(): int
    {
        return $this->maximumPathLength;
    }

    public function getFileCacheBasePath(): string
    {
        return $this->fileCacheBasePath;
    }

    public function getCacheIdentifier(): string
    {
        return $this->cacheIdentifier;
    }
}
