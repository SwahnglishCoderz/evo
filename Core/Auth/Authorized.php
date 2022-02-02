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

namespace Evo\Auth;

use App\Models\UserModel;
use Evo\Auth\RememberedLogin;
use Evo\Base\Exception\BaseUnexpectedValueException;
use Evo\Cookie\CookieFacade;
use Evo\Session\SessionTrait;
use Exception;
use Throwable;

class Authorized
{
    use SessionTrait;

    protected const TOKEN_COOKIE_NAME = "remember_me";
    protected const FIELD_SESSIONS = [
        'id',
        'email',
        'firstname',
        'lastname',
        'password_hash',
        'gravatar',
        'status_id'
    ];

    /**
     * Login the user
     */
    public static function login(object $user, bool $remember_me, int $id = null) // OG
    {
        session_regenerate_id(true);
        SessionTrait::registerUserSession($user->id);

        if ($remember_me) {
            if ($user->rememberLogin()) {
                setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');
            }
        }
    }

    /**
     * Helper function for getting the current user ID from the active session
     */
    protected static function getCurrentSessionID(): int
    {
//        return intval(SessionTrait::sessionFromGlobal()->get('user_id'));
        return isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    }

    /**
     * Register the current logged-in user to the Session so there info can
     * @throws Throwable
     */
    public static function grantedUser()
    {
        $userSessionID = self::getCurrentSessionID();
        if (isset($userSessionID) && $userSessionID !==0) {
            return (new UserModel())->getRepository()->findObjectBy(['id' => $userSessionID], self::FIELD_SESSIONS);
        } else {
            $user = self::loginFromRememberCookie();
            if ($user) {
                return $user;
            }
        }
    }

    /**
     * @throws Exception|Throwable
     */
    public static function logout()
    {
        // Unset all the session variables
        $_SESSION = [];

        // Delete the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Finally, destroy the session
        session_destroy();

        static::forgetLogin();
    }

    /**
     * Remember the originally-requested page in the session
     */
    public static function rememberRequestedPage() // OG
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    /**
     * Get the originally-requested page to return to after requiring login, or default to the homepage
     */
    public static function getReturnToPage() // OG
    {
        return $_SESSION['return_to'] ?? '/';
    }

    /**
     * Get the current logged-in user, from the session or the remember-me cookie
     *
     * returns the user model or null if not logged in
     * @throws Exception
     * @throws Throwable
     */
    public static function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            return (new \App\Models\UserModel)->getNameForSelectField($_SESSION['user_id'], ['firstname', 'lastname', 'email']);
        } else {
            return static::loginFromRememberCookie();
        }
    }

    /**
     * Login the user from a remembered login cookie
     *
     * returns the user model if login cookie found; null otherwise
     * @throws Exception
     * @throws Throwable
     */
    protected static function loginFromRememberCookie() // OG
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = (new RememberedLogin)->findByToken($cookie);

            //if ($remembered_login) {
            if ($remembered_login && ! $remembered_login->hasExpired()) {

                $user = $remembered_login->getUser();

                static::login($user, false);

                return $user;
            }
        }
    }

    /**
     * Forget the remembered login, if present
     * @throws Exception
     * @throws Throwable
     */
    protected static function forgetLogin() // OG
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = (new RememberedLogin)->findByToken($cookie);

            if ($remembered_login) {

                $remembered_login->delete();
            }

            setcookie('remember_me', '', time() - 3600);  // set to expire in the past
        }
    }
}