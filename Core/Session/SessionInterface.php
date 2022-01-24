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

use Evo\Session\Exception\SessionInvalidArgumentException;

interface SessionInterface
{

    /**
     * sets a specific value to a specific key of the session
     */
    public function set(string $key, $value): void;

    /**
     * Sets the specific value to a specific array key of the session
     */
    public function setArray(string $key, $value): void;

    /**
     * gets/returns the value of a specific key of the session
     */
    public function get(string $key, $default = null);

    /**
     * Removes the value for the specified key from the session
     */
    public function delete(string $key): bool;

    /**
     * Destroy the session. Along with session cookies
     */
    public function invalidate(): void;

    /**
     * Returns the requested value and remove it from the session
     */
    public function flush(string $key, $value = null);

    /**
     * Determines whether an item is present in the session.
     */
    public function has(string $key): bool;
}
