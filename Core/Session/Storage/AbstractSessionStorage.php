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

use Evo\Session\SessionTrait;

abstract class AbstractSessionStorage implements SessionStorageInterface
{

    use SessionTrait;

    protected Object $sessionEnvironment;

    /**
     * abstract class constructor
     */
    public function __construct(Object $sessionEnvironment)
    {
        if ($sessionEnvironment)
            $this->sessionEnvironment = $sessionEnvironment;

        $this->iniSet();
        // Destroy any existing sessions started with session.auto_start
        if ($this->isSessionStarted()) {
            session_unset();
            session_destroy();
        }
        $this->start();
    }

    /**
     * Set the name of the session
     */
    public function setSessionName(string $sessionName): void
    {
        session_name($sessionName);
    }

    /**
     * Return the current session name
     */
    public function getSessionName(): string
    {
        return session_name();
    }

    /**
     * Set the name of the session ID
     */
    public function setSessionID(string $sessionID): void
    {
        session_id($sessionID);
    }

    /**
     * Return the current session ID
     */
    public function getSessionID(): string
    {
        return session_id();
    }

    /**
     * Override PHP default session runtime configurations
     */
    public function iniSet(): void
    {
        foreach ($this->sessionEnvironment->getSessionRuntimeConfigurations() as $option) {
            if ($option) {
                ini_set($option, $this->sessionEnvironment->getSessionIniValues());
            }
        }
    }

    /**
     * Prevent session within the cli. Even though we can't run sessions within
     * the command line. also we're checking we have a session id and its not empty
     * else return false
     */
    public function isSessionStarted(): bool
    {
        return php_sapi_name() !== 'cli' && $this->getSessionID() !== '';
    }

    /**
     * Start our session if we haven't already have a php session
     */
    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }

    /**
     * Define our session_set_cookie_params method via the $this->options parameters which 
     * will be defined within our core config directory
     */
    public function start(): void
    {
        $this->setSessionName($this->sessionEnvironment->getSessionName());
        session_set_cookie_params($this->sessionEnvironment->getLifetime(), $this->sessionEnvironment->getPath(), $this->sessionEnvironment->getDomain(), $this->sessionEnvironment->isSecure(), $this->sessionEnvironment->isHttpOnly());

        $this->startSession();
        if ($this->validateSession()) {
            if (!$this->preventSessionHijack()) {
                $_SESSION = array();
                $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
            } elseif (rand(1, 100) <= 5) { // Give a 5% chance of the session id changing on any request
                $this->sessionRegeneration();
            }
        } else {
            $_SESSION = array();
            session_destroy();
            $this->startSession(); // restart session
        }
    }
}
