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

namespace App;

use App\Models\UserModel;
use App\Models\RememberedLogin;
use Evo\Base\AbstractBaseModel;
use Evo\Base\BaseModel;
use Evo\Session\SessionFactory;
use Exception;

class Auth
{

    public static function login(object $user, bool $remember_me, int $id = null)
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;

//        $factory = new SessionFactory();
//        $session = $factory->create('session_name', \Evo\Session\Storage\NativeSessionStorage::class, Config::APP['session']);
//        $session->set('name', '3vo');
//        echo $session->get('name');
//        exit;

        if ($remember_me) {

            if ($user->rememberLogin()) {

                setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, '/');

            }
        }
    }

    /**
     * @throws Exception
     */
    public static function logout()
    {
//        print_r($_SESSION);
        // Unset all the session variables
        $_SESSION = [];

//        print_r($_SESSION);
//        exit;

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
    public static function rememberRequestedPage()
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
//        $_SESSION['return_to'] = $_SERVER['QUERY_STRING'];
    }

    /**
     * Get the originally-requested page to return to after requiring login, or default to the homepage
     */
    public static function getReturnToPage()
    {
//        print_r($_SESSION);
//        exit;
        return $_SESSION['return_to'] ?? '/';
    }

    /**
     * Get the current logged-in user, from the session or the remember-me cookie
     *
     * returns the user model or null if not logged in
     * @throws Exception
     */
    public static function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            return (new UserModel)->getNameForSelectField($_SESSION['user_id'], ['name', 'email']);
        } else {
            return static::loginFromRememberCookie();
        }
    }

    /**
     * Login the user from a remembered login cookie
     *
     * returns the user model if login cookie found; null otherwise
     * @throws Exception
     */
    protected static function loginFromRememberCookie()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);

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
     */
    protected static function forgetLogin()
    {
        $cookie = $_COOKIE['remember_me'] ?? false;

        if ($cookie) {

            $remembered_login = RememberedLogin::findByToken($cookie);

            if ($remembered_login) {

                $remembered_login->delete();
            }

            setcookie('remember_me', '', time() - 3600);  // set to expire in the past
        }
    }
}
