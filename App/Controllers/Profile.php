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

use Evo\Status;
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
//        echo '<pre>';
//        print_r($this->user);
//        echo '</pre>';

        $this->user->is_active_color = self::isUserActive($this->user->is_active)['color'];
        $this->user->is_active_name = self::isUserActive($this->user->is_active)['name'];

//        echo '<pre>';
//        print_r($this->user);
//        echo '</pre>';
//        exit;

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

    private static function isUserActive($is_active): array
    {
        $active_status = [];
        // search for status; return name and color and pass it back - all this goes to Model
//        echo $is_active . '<br />';
        switch ($is_active) {
            case 1:
                $active_status['name'] = 'Active';
                $active_status['color'] = Status::ACTIVE_COLOR;
                return $active_status;
                break;
            case 2:
            default:
                $active_status['name'] = 'Inactive';
                $active_status['color'] = Status::INACTIVE_COLOR;
                return $active_status;
            break;
        }
    }
}
