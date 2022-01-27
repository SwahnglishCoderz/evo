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

use LogicException;
use Evo\Session\Exception\SessionException;
use Evo\Session\GlobalManager\GlobalManager;
use Evo\Session\GlobalManager\GlobalManagerException;

trait SessionTrait
{

    /**
     * method which should prevent our session being hijacked. This will return
     * false on new sessions or when a session is loaded by a host with a different
     * IP address or browser
     */
    public function preventSessionHijack(): bool
    {
        if (!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])) {
            return false;
        }
        if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']) {
            return  false;
        }
        if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    /**
     * Validate the session by checking for the obsolete flag and to see if the
     * session has expires
     */
    protected function validateSession(): bool
    {
        if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES'])) {
            return false;
        }
        if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()) {
            return false;
        }
        return true;
    }

    /**
     * Regenerate the session ID. We can also optionally delete the old session ID
     */
    public function sessionRegeneration(int $sessionExpiration = 10, bool $deleteOldSession = false)
    {
        if (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true) {
            return '';
        }
        // Set current session to expire in 10 seconds
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + $sessionExpiration;

        // Create new session without destroying the old one argument set to false to default
        session_regenerate_id($deleteOldSession);
        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSessionID = $this->getSessionID();
        session_write_close();
        $this->setSessionID($newSessionID); // Set new session ID
        $this->startSession(); // then restart session again
        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }

    /**
     * The session global is automatically set from the session facade class We
     * can fetch the global variable and use this trait method in any class
     * which reference this trait
     * @throws SessionException|GlobalManagerException
     */
    public static function sessionFromGlobal(): object
    {
        /* Get the stored session Object */
        $storedSessionObject = GlobalManager::get('session_global');
        if (!$storedSessionObject) {
            throw new SessionException("No session object found within the global manager");
        }
        return $storedSessionObject;
    }

    /**
     * Store session data upon successful login
     */
    public static function registerUserSession($userID)
    {
        $_SESSION['user_id'] = $userID;
        $_SESSION['last_login'] = time();
        $_SESSION['is_login'] = true;
//        print_r($_SESSION);
    }
}
