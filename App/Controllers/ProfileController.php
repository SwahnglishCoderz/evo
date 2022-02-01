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
use Evo\Auth\Authorized;
use Evo\System\Status;
use Evo\Base\BaseView;
use App\Flash;
use Exception;
use Throwable;

class ProfileController extends Authenticated
{
    /**
     * Show the profile
     * @throws Exception|Throwable
     */
    public function show()
    {
//        $this->user = Auth::getUser();
        $this->user = Authorized::getUser();
//        print_r($this->user);
//        exit;

//        $this->user->is_active_color = self::isUserActive($this->user->is_active)['color'];
//        $this->user->is_active_name = self::isUserActive($this->user->is_active)['name'];

        BaseView::renderTemplate('profile/show.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Show the form for editing the profile
     * @throws Exception
     * @throws Throwable
     */
    public function edit()
    {
//        $this->user = Auth::getUser();
        $this->user = Authorized::getUser();

        BaseView::renderTemplate('profile/edit.html', [
            'user' => $this->user
        ]);
    }

    /**
     * Update the profile
     * @throws Exception
     */
    public function update()
    {
//        $this->user = Auth::getUser();
//        print_r($_SESSION['user_id']);
//        exit;


        if ((new \App\Models\UserModel)->updateProfile($_POST, $_SESSION['user_id'])) {
            Flash::addMessageToFlashNotifications('Changes saved');
//
            $this->redirect('/profile/show');
//
        } else {
            BaseView::renderTemplate('profile/edit.html', [
                'user' => $this->user
            ]);

        }
    }

    protected static function isUserActive($is_active): array
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
