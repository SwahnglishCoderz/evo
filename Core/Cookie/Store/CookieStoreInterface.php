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

interface CookieStoreInterface
{
    public function hasCookie(): bool;

    public function setCookie($value): void;

    public function deleteCookie(?string $cookieName = null): void;
}
