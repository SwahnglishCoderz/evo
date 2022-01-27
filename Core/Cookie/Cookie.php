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

use Evo\Cookie\Store\CookieStoreInterface;

class Cookie implements CookieInterface
{
    protected CookieStoreInterface $cookieStore;

    /**
     * Protected class constructor as this class will be a singleton
     */
    public function __construct(CookieStoreInterface $cookieStore)
    {
        $this->cookieStore = $cookieStore;
    }

    public function has(): bool
    {
        return $this->cookieStore->hasCookie();
    }

    public function set($value): void
    {
        $this->cookieStore->setCookie($value);
    }

    public function delete(): void
    {
        if ($this->has()) {
            $this->cookieStore->deleteCookie();
        }
    }

    public function invalidate(): void
    {
        foreach ($_COOKIE as $name => $value) {
            if ($this->has()) {
                $this->cookieStore->deleteCookie($name);
            }
        }
    }
}
