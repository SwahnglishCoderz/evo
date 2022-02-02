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

use App\Models\UserModel;
use Evo\Base\BaseController;
use Evo\Base\BaseView;
use Exception;
use Throwable;

class SignupController extends BaseController
{
    /**
     * @throws Throwable
     */
    public function indexAction()
    {
        BaseView::renderTemplate('signup/new.html');
    }

    /**
     * @throws Throwable
     */
    public function createAction()
    {
        $user = new UserModel();

        if ($user->save($_POST)) {
            $user->sendActivationEmail();
            $this->redirect('/signup/success');
        } else {
            BaseView::renderTemplate('signup/new.html', [
                'user' => $user
            ]);
        }
    }

    /**
     * Show the signup success page
     * @throws Exception|Throwable
     */
    public function successAction()
    {
        BaseView::renderTemplate('signup/success.html');
    }

    /**
     * Activate a new account
     * @throws Exception
     */
    public function activateAction()
    {
        UserModel::activateAccount($this->routeParams['token']);
        $this->redirect('/signup/activated');
    }

    /**
     * Show the activation success page
     * @throws Exception|Throwable
     */
    public function activatedAction()
    {
        BaseView::renderTemplate('signup/activated.html');
    }
}
