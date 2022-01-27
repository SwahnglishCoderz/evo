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

namespace Evo\Auth;

use Evo\Base\Exception\BaseUnexpectedValueException;
use Evo\Auth\Model\RememberedLoginModel as RememberedLogin;
use Evo\Auth\Roles\Roles;
use Evo\Session\SessionTrait;
use Evo\Cookie\CookieFacade;
use Evo\UserManager\UserModel;
use Throwable;

/**
 * @todo delete cookie from browser if database cookie token is not vaild or missing
 */
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
        'status'

    ];

    /**
     * Login the user
     */
    public static function login(Object $userModel, $rememberMe)
    {
        /* Set userID Session here */
        session_regenerate_id(true);

        SessionTrait::registerUserSession($userModel->id ?? false);

        if ($rememberMe) {
            $rememberLogin = new RememberedLogin();
            list($token, $timestampExpiry) = $rememberLogin->rememberedLogin($userModel->id);
            if ($token !=null) {
                $cookie = (new CookieFacade(['name' => self::TOKEN_COOKIE_NAME, 'expires' => $timestampExpiry]))->initialize();
                $cookie->set($token);
            }
        }
    }

    /**
     * Helper function for getting the current user ID from the active session
     */
    protected static function getCurrentSessionID(): int
    {
        return intval(SessionTrait::sessionFromGlobal()->get('user_id'));
    }

    /**
     * Register the current logged-in user to the Session so there info can
     * be accessible globally.
     * @throws Throwable
     */
    public static function grantedUser()
    {
        $userSessionID = self::getCurrentSessionID();
        if (isset($userSessionID)) {
            return (new UserModel())->getRepository()->findObjectBy(['id' => $userSessionID], self::FIELD_SESSIONS);
        } else {
            $user = self::loginFromRemembermeCookie();
            if ($user) {
                return $user;
            }
        }

    }

    /**
     * Logout the user and kill the user session and also delete the cookie
     * created for user login
     */
    public static function logout() : void
    {
        if (self::getCurrentSessionID() !=null) {
            SessionTrait::SessionFromGlobal()->invalidate();
            self::forgetLogin();
        }
    }

    /**
     * Remember the originally-requested page in the session
     */
    public static function rememberRequestedPage() : void
    {
        SessionTrait::sessionFromGlobal()->set('return_to', $_SERVER['REQUEST_URI']);
    }

    /**
     * Get the originally-requested page to return to after requiring login,
     * or default to the homepage
     */
    public static function getReturnToPage() : string
    {
        $page = SessionTrait::sessionFromGlobal()->get('return_to');
//        print_r($page);
//        exit;
        return $page ?? '/';
    }

    /**
     * Login the user from a remembered login cookie
     * @throws Throwable
     */
    protected static function loginFromRemembermeCookie() : ?object
    {
        $cookie = $_COOKIE[self::TOKEN_COOKIE_NAME] ?? false;
        if ($cookie) {
            $rememberLogin = new RememberedLogin();
            $cookieToken = $rememberLogin->findByToken($cookie);
            if ($cookieToken && !$rememberLogin->hasExpired($cookieToken->expires_at)) {
                $user = $rememberLogin->getUser($cookieToken->id);
                if ($user) {
                    self::login($user, false);
                    return $user;
                } 
            }
        }
        return null;
    }

    /**
     * Forget the remembered login, if present
     * @throws Throwable
     */
    protected static function forgetLogin() : bool
    {
        $cookie = $_COOKIE[self::TOKEN_COOKIE_NAME] ?? false;
        if ($cookie) {    
            $rememberLogin = new RememberedLogin();
            $rememberCookie = $rememberLogin->findByToken($cookie);
            if ($rememberCookie) {        
                $rememberLogin->destroy($rememberCookie->token_hash);
            }
            /* expire cookie here */
            $cookie = (new CookieFacade(['name' => self::TOKEN_COOKIE_NAME]))->initialize();
            $cookie->delete();
            return true;
        }    
        return false;
    }

}
