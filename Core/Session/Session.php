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

use Evo\Session\Exception\SessionException;
use Evo\Session\Exception\SessionInvalidArgumentException;
use Evo\Session\Storage\SessionStorageInterface;
use Throwable;

class Session implements SessionInterface
{
    protected ?SessionStorageInterface $storage;

    protected string $sessionIdentifier;

    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    public function __construct(string $sessionIdentifier, SessionStorageInterface $storage = null)
    {
        if ($this->isSessionKeyValid($sessionIdentifier) === false) {
            throw new SessionInvalidArgumentException($sessionIdentifier . ' is not a valid session name');
        }

        $this->sessionIdentifier = $sessionIdentifier;
        $this->storage = $storage;
    }

    /**
     * Return the storage object
     */
    public function getStorage(): ?SessionStorageInterface
    {
        return $this->storage;
    }

    /**
     * @throws SessionException
     */
    public function set(string $key, $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->SetSession($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
        }
    }

    /**
     * @throws SessionException
     */
    public function setArray(string $key, $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setArraySession($key, $value);
        } catch (Throwable|SessionException $throwable) {
            throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
        }
    }

    /**
     * @throws SessionException
     */
    public function get(string $key, $default = null)
    {
        try {
            return $this->storage->getSession($key, $default);
        } catch (Throwable $throwable) {
            throw new SessionException('An exception was thrown in retrieving the key from the session storage. ' . $throwable);
        }
    }

    public function delete(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->deleteSession($key);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
        return true;
    }

    public function invalidate(): void
    {
        $this->storage->invalidate();
    }

    /**
     * @throws Throwable
     */
    public function flush(string $key, $value = null)
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            return $this->storage->flush($key, $value);
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    public function has(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        return $this->storage->hasSession($key);
    }

    /**
     * Checks whether our session key is valid according the defined regular expression
     */
    protected function isSessionKeyValid(string $key): bool
    {
        return (preg_match(self::SESSION_PATTERN, $key) === 1);
    }

    /**
     * Checks whether we have session key
     */
    protected function ensureSessionKeyIsvalid(string $key): void
    {
        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgumentException($key . ' is not a valid session key');
        }
    }
}
