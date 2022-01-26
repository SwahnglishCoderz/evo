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
use Evo\Base\BaseController;
use Evo\View;
use Evo\Base\Exception\BaseInvalidArgumentException;
use Exception;
use Throwable;

class RegistrationController extends \Evo\UserManager\Security\SecurityController
{
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
    }

    public function index()
    {
       View::renderTemplate('signup/new.html');
    }

    /**
     * @throws Throwable
     */
    public function signup()
    {
        $user = new UserModel($_POST);

        if ($user->save()) {

            $user->sendActivationEmail();

            $this->redirect('/registration/success');

        } else {

            View::renderTemplate('signup/new.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Show the signup success page
     */
    public function success()
    {
        View::renderTemplate('signup/success.html');
    }

    /**
     * Activate a new account
     * @throws Exception
     */
    public function activate()
    {
        UserModel::activateAccount($this->route_params['token']);

        $this->redirect('/registration/activated');
    }

    /**
     * Show the activation success page
     */
    public function activated()
    {
        View::renderTemplate('signup/activated.html');
    }
}
