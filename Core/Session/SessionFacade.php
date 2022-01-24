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
use Evo\Session\GlobalManager\GlobalManager;

final class SessionFacade
{

    /** @var ?string - a string which identifies the current session */
    protected ?string $sessionIdentifier;

    /** @var ?string - the namespace reference to the session storage type */
    protected ?string $storage;

    /** @var Object - the session environment object */
    protected Object $sessionEnvironment;

    /**
     * Main session facade class which pipes the properties to the method arguments.
     */
    public function __construct(
        array $sessionEnvironment = null,
        ?string $sessionIdentifier = null,
        ?string $storage = null
    ) {
        /** Defaults are set from the BaseApplication class */
        $this->sessionEnvironment = new SessionEnvironment($sessionEnvironment);
        $this->sessionIdentifier = $sessionIdentifier;
        $this->storage = $storage;
    }

    /**
     * Initialize the session component and return the session object. Also stored the
     * session object within the global manager. So session can be fetched throughout
     * the application by using the GlobalManager::get('session_global') to get
     * the session object
     */
    public function setSession(): Object
    {
        try {
            return (new SessionFactory())->create($this->sessionIdentifier, $this->storage, $this->sessionEnvironment);
        } catch(SessionException $e) {
            //throw new SessionException($e->getMessage());
        }
    }
}
