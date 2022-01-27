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

namespace App\Controller;

use App\Auth;
use App\Flash;
use App\Models\MenuModel;
use App\Models\SectionModel;
use App\Models\UserModel;
use Evo\Auth\Authorized;
use Evo\Base\BaseController;
use Evo\View;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Exception;
use Throwable;

class SecurityController extends \Evo\UserManager\Security\SecurityController
{
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
    }

    public function index()
    {
         View::renderTemplate('login/new.html');
    }

    /**
     * @throws Throwable
     */
    public function login()
    {
        $user = new UserModel($_POST);

        $cleanData = $user->cleanSubmittedData();
        $auth = $this->authenticator->authenticate($cleanData['email'], $cleanData['password']);

        echo '<pre>';
//        print_r($auth);
//        exit;

        $remember_me = isset($_POST['remember_me']);

        if ($auth) {
            Auth::login($auth, $remember_me);
//            print_r($_SESSION);
//            exit;
//            Authorized::login($auth, $remember_me);

            Flash::addMessageToFlashNotifications('Login successful');

            $this->redirect(Auth::getReturnToPage());
//            print_r($_SESSION);
//            exit;
//            $this->redirect(Authorized::getReturnToPage());
        } else {
            Flash::addMessageToFlashNotifications('Login unsuccessful, please try again', Flash::WARNING);

            View::renderTemplate('login/new.html', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function logout()
    {
        Auth::logout();
//        Authorized::logout();

        $this->redirect('/security/show-logout-message');
    }

    /**
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destroyAction) the session is destroyed
     * so a new action needs to be called in order to use the session.
     */
    public function showLogoutMessage()
    {
        Flash::addMessageToFlashNotifications('Logout successful');

        $this->redirect('/');
    }
}
