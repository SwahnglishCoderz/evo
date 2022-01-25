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

use Evo\Cache\Exception\CacheException;

class CacheFacade
{

    /**
     * Undocumented function
     */
    public function create(
        ?string $cacheIdentifier = null,
        ?string $storage = null,
        array $options = []
    ): CacheInterface
    {
        try {
            return (new CacheFactory())->create($cacheIdentifier, $storage, $options);
        } catch(CacheException $e) {
            throw $e->getMessage();
        }
    }
}
