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

//use JetBrains\PhpStorm\ArrayShape;

class CacheConfig
{
    private const DEFAULT_DRIVER = 'native_storage';

    public function baseConfiguration(): array
    {
        return [
            'use_cache' => true,
            'key' => 'auto',
            'cache_path' => '/Storage/Cache/',
            'cache_expires' => 3600,
            'default_storage' => self::DEFAULT_DRIVER,
            'drivers' => [
                'native_storage' => [
                    'class' => '\Evo\Cache\Storage\NativeCacheStorage',
                    'default' => true
                ],
                'array_storage' => [
                    'class' => '\Evo\Cache\Storage\ArrayCacheStorage',
                    'default' => false

                ],
                'pdo_storage' => [
                    'class' => '\Evo\Cache\Storage\PdoCacheStorage',
                    'default' => false

                ]
            ]
        ];
    }
}
