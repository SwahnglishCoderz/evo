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

namespace App\Controllers;

use Evo\Auth\Authorized;
use Evo\Base\BaseController;
use Evo\Base\BaseView;
use App\Models\UserModel;
use App\Flash;
use Exception;
use Throwable;

class LoginController extends BaseController
{
    /**
     * @throws Exception|Throwable
     */
    public function indexAction()
    {
        BaseView::renderTemplate('login/new.html');
    }

    /**
     * @throws Throwable
     */
    public function create()
    {
        $user = new UserModel($_POST);
        $auth = $user->authenticate($_POST['email'], $_POST['password']);

        if ($auth)
            $user->id = $auth->id;

        $remember_me = isset($_POST['remember_me']);

        if ($user) {
//            Auth::login($user, $remember_me); // OG
            Authorized::login($user, $remember_me);

            Flash::addMessageToFlashNotifications('Login successful');

//            $this->redirect(Auth::getReturnToPage());
            $this->redirect(Authorized::getReturnToPage());

        } else {

            Flash::addMessageToFlashNotifications('Login unsuccessful, please try again', Flash::WARNING);

            BaseView::renderTemplate('login/new.html', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function destroy()
    {
//        Auth::logout();
        Authorized::logout();

        $this->redirect('/login/show-logout-message');
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