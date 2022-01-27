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

namespace Evo\Session;

class SessionConfig
{
    private const DEFAULT_DRIVER = 'native_storage';

    /**
     * Main session configuration default array settings
     */
    public function baseConfiguration(): array
    {
        return [
            'session_name' => '51mp1yG3n1u5',
            'lifetime' => 3600,
            'path' => '/',
            'domain' => 'localhost',
            'secure' => false,
            'httponly' => true,
            'gc_maxlifetime' => '1800',
            'gc_divisor' => '1',
            'gc_probability' => '1000',
            'use_cookies' => '1',
            'globalized' => false,
            'default_driver' => self::DEFAULT_DRIVER,
            'drivers' => [
                'native_storage' => [
                    'class' => '\Evo\Session\Storage\NativeSessionStorage',
                    'default' => true
                ],
                'array_storage' => [
                    'class' => '\Evo\Session\Storage\ArraySessionStorage',
                    'default' => false

                ],
                'pdo_storage' => [
                    'class' => '\Evo\Session\Storage\PdoSessionStorage',
                    'default' => false
                ]
            ]
        ];
    }
}
