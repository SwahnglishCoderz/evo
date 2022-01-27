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

use Evo\Cookie\Exception\CookieUnexpectedValueException;
use Evo\Cookie\Store\CookieStoreInterface;

class CookieFactory
{

    /** @return void */
    public function __construct()
    {
    }

    /**
     * Cookie factory which create the cookie object and instantiate the chosen
     * cookie store object which defaults to nativeCookieStore. This store object accepts
     * the cookie environment object as the only argument.
     */
    public function create(?string $cookieStore, CookieEnvironment $cookieEnvironment): CookieInterface
    {
        $cookieStoreObject = new $cookieStore($cookieEnvironment);
        if (!$cookieStoreObject instanceof CookieStoreInterface) {
            throw new CookieUnexpectedValueException($cookieStore . 'is not a valid cookie store object.');
        }

        return new Cookie($cookieStoreObject);
    }
}
