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

interface CookieInterface
{

    /**
     * Set a cookie within the domain
     */
    public function set($value) : void;

    /**
     * Checks to see whether the cookie was set or not return true or false
     */
    public function has() : bool;

    /**
     * delete a single cookie from the domain
     */
    public function delete() : void;

    /**
     * Invalid all cookie i.e delete all set cookie within this domain
     */
    public function invalidate() : void;

}