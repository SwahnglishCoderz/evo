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

namespace Evo\Cookie;

//use JetBrains\PhpStorm\ArrayShape;

class CookieConfig
{

    /** @return void */
    public function __construct()
    {
    }

    /**
     * Main cookie configuration default array settings
     */
    public function baseConfig(): array
    {
        return [

            'name' => '__evo_cookie__',
            'expires' => 3600,
            'path' => '/',
            'domain' => 'localhost',
            'secure' => false,
            'httponly' => true

        ];
    }
}
