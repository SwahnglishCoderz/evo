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

namespace Evo\Session\Storage;

use Evo\Session\Exception\SessionInvalidArgumentException;

interface SessionStorageInterface
{
    /**
     * session_name wrapper with explicit argument to set a session_name
     */
    public function setSessionName(string $sessionName): void;

    /**
     * session_name wrapper returns the name of the session
     */
    public function getSessionName(): string;

    /**
     * session_id wrapper with explicit argument to set a session_id
     */
    public function setSessionID(string $sessionID): void;

    /**
     * session_id wrapper which returns the current session id
     */
    public function getSessionID(): string;

    /**
     * sets a specific value to a specific key of the session
     */
    public function setSession(string $key, $value): void;

    /**
     * Sets the specific value to a specific array key of the session
     */
    public function setArraySession(string $key, $value): void;

    /**
     * gets/returns the value of a specific key of the session
     */
    public function getSession(string $key, $default = null);

    /**
     * Removes the value for the specified key from the session
     */
    public function deleteSession(string $key): void;

    /**
     * Destroy the session. Along with session cookies
     */
    public function invalidate(): void;

    /**
     * Returns the requested value and remove the key from the session
     */
    public function flush(string $key, $default = null);

    /**
     * Determines whether an item is present in the session.
     */
    public function hasSession(string $key): bool;
}
