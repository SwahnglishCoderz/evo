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

use Evo\Cache\Exception\CacheInvalidArgumentException;

abstract class AbstractCache implements CacheInterface
{

    /** @var string regular expression - ensure cache name is of correct values */
    const PATTERN_ENTRYIDENTIFIER = '/^[a-zA-Z0-9_\.]{1,64}$/';

    protected ?object $storage;
    protected ?string $cacheIdentifier;
    protected array $options = [];

    /**
     * Main abstract parent class which pipes all the properties to their constructor
     * arguments
     */
    public function __construct(?string $cacheIdentifier = null, ?Object $storage = null, array $options = [])
    {
        $this->$cacheIdentifier = $cacheIdentifier;
        if (!empty($storage) && $storage != null) {
            $this->storage = $storage;
        }
        if ($options)
            $this->options = $options;
    }

    /**
     * Check cache identifier matches the regular expression if not throw an
     * exception. cache name can only contains letter, number, underscore and 
     * should have a minimum or 1 and a maximum of 64 characters. No special 
     * characters are allowed.
     */
    protected function isCacheEntryIdentifiervalid(string $key): bool
    {
        return (preg_match(self::PATTERN_ENTRYIDENTIFIER, $key) === 1);
    }

    protected function ensureCacheEntryIdentifierIsvalid(string $key): void
    {
        if ($this->isCacheEntryIdentifiervalid($key) === false) {
            throw new CacheInvalidArgumentException('"' . $key . '" is not a valid cache key.', 0);
        }
    }
}
