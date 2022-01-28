<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Evo\Session\Storage;

class PdoSessionStorage extends AbstractSessionStorage
{
    public function __construct(Object $sessionEnvironment)
    {
        parent::__construct($sessionEnvironment);
    }

    public function setSession(string $key, $value): void
    {
        // TODO: Implement setSession() method.
    }

    public function setArraySession(string $key, $value): void
    {
        // TODO: Implement setArraySession() method.
    }

    public function getSession(string $key, $default = null)
    {
        // TODO: Implement getSession() method.
    }

    public function deleteSession(string $key): void
    {
        // TODO: Implement deleteSession() method.
    }

    public function invalidate(): void
    {
        // TODO: Implement invalidate() method.
    }

    public function flush(string $key, $default = null)
    {
        // TODO: Implement flush() method.
    }

    public function hasSession(string $key): bool
    {
        // TODO: Implement hasSession() method.
    }
}