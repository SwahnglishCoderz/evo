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

use Evo\Controller;
use Evo\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

class Login extends Controller
{

    /**
     * Show the login page
     */
    public function new()
    {
        View::renderTemplate('Login/new.html');
    }

    /**
     * Log in a user
     */
    public function create()
    {
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
//        exit;
        $user = User::authenticate($_POST['email'], $_POST['password']);

//        echo '<pre>';
//        print_r($user);
//        echo '</pre>';
//        exit;
        
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
     * Log out a user
     */
    public function destroy()
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }

    /**
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destroy) the session is destroyed
     * so a new  needs to be called in order to use the session.
     *
     * @return void
     */
    public function showLogoutMessage()
    {
        Flash::addMessageToFlashNotifications('Logout successful');

        $this->redirect('/');
    }
}
