<?php

namespace App\Controllers;

use Evo\Base\BaseController;
use Evo\Controller;
use Evo\View;
use App\Models\UserModel;
use App\Auth;
use App\Flash;
use Exception;
use Throwable;

class Login extends BaseController
{
    public function new()
    {
        View::renderTemplate('Login/new.html');
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
            Auth::login($user, $remember_me);

            Flash::addMessageToFlashNotifications('Login successful');

            $this->redirect(Auth::getReturnToPage());

        } else {

            Flash::addMessageToFlashNotifications('Login unsuccessful, please try again', Flash::WARNING);

            View::renderTemplate('Login/new.html', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy()
    {
        Auth::logout();

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