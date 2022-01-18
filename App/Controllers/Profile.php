<?php
/*
 * This file is part of the Nnaire package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace App\Controllers;

use Evo\View;
use \App\Auth;
use \App\Flash;

class Profile extends Authenticated
{

    /**
     * Before filter - called before each action method
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    /**
     * Show the profile
     */
    public function showAction()
    {
        View::renderTemplate('Profile/show.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Show the form for editing the profile
     */
    public function editAction()
    {
        View::renderTemplate('Profile/edit.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Update the profile
     */
    public function updateAction()
    {
        if ($this->user->updateProfile($_POST)) {

            Flash::addMessageToFlashNotifications('Changes saved');

            $this->redirect('/profile/show');

        } else {

            View::renderTemplate('Profile/edit.html', [
                'user' => $this->user
            ]);

        }
    }
}
