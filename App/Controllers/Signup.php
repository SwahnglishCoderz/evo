<?php

namespace App\Controllers;

use Evo\Controller;
use Evo\View;
use \App\Models\User;
use Exception;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends Controller
{

    /**
     * Show the signup page
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    /**
     * Sign up a new user
     */
    public function createAction()
    {
        $user = new User($_POST);

        if ($user->save()) {

            $user->sendActivationEmail();

            $this->redirect('/signup/success');

        } else {

            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Show the signup success page
     */
    public function successAction()
    {
        View::renderTemplate('Signup/success.html');
    }

    /**
     * Activate a new account
     * @throws Exception
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/signup/activated');
    }

    /**
     * Show the activation success page
     */
    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');
    }
}
