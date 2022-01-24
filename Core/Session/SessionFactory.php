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

use Evo\Session\Exception\SessionUnexpectedValueException;
use Evo\Session\Storage\SessionStorageInterface;

class SessionFactory
{
    public function __construct()
    {
    }

    /**
     * Session factory which create the session object and instantiate the chosen
     * session storage which defaults to nativeSessionStorage. This storage object accepts
     * the session environment object as the only argument.
     */
    public function create(
        string $sessionIdentifier,
        string $storage,
        SessionEnvironment $sessionEnvironment
    ): SessionInterface {
        $storageObject = new $storage($sessionEnvironment);
        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionUnexpectedValueException(
                $storage . ' is not a valid session storage object.'
            );
        }

        return new Session($sessionIdentifier, $storageObject);
    }
}
