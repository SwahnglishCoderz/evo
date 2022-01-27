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

namespace Evo\Cookie\Store;

use JetBrains\PhpStorm\Pure;

class NativeCookieStore extends AbstractCookieStore
{
    public function __construct(Object $cookieEnvironment)
    {
        parent::__construct($cookieEnvironment);
    }

    public function hasCookie(): bool
    {
        return isset($_COOKIE[$this->cookieEnvironment->getCookieName()]);
    }

    public function setCookie($value): void
    {
        setcookie($this->cookieEnvironment->getCookieName(), $value, $this->cookieEnvironment->getExpiration(), $this->cookieEnvironment->getPath(), $this->cookieEnvironment->getDomain(), $this->cookieEnvironment->isSecure(), $this->cookieEnvironment->isHttpOnly());
    }

    public function deleteCookie(?string $cookieName = null): void
    {
        setcookie(($cookieName != null) ? $cookieName : $this->cookieEnvironment->getCookieName(), '', (time() - 3600), $this->cookieEnvironment->getPath(), $this->cookieEnvironment->getDomain(), $this->cookieEnvironment->isSecure(), $this->cookieEnvironment->isHttpOnly());
    }
}
