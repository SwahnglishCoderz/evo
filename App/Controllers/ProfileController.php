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
use Evo\Base\BaseController;
use Evo\Middleware\Before\LoginRequired;
use Evo\System\Status;
use Evo\Base\BaseView;
use Evo\Flash\Flash;
use Exception;
use Throwable;

//class ProfileController extends Authenticated
class ProfileController extends BaseController
{
    protected function callBeforeMiddlewares(): array
    {
        return [
            'LoginRequired' => LoginRequired::class
        ];
    }

    /**
     * @throws Exception|Throwable
     */
    public function showAction()
    {
        $this->user = Authorized::getUser();

        BaseView::renderTemplate('profile/show.html', [
            'user' => $this->user
        ]);
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function editAction()
    {
        $this->user = Authorized::getUser();

        BaseView::renderTemplate('profile/edit.html', [
            'user' => $this->user
        ]);
    }

    /**
     * @throws Exception|Throwable
     */
    public function updateAction()
    {
        if ((new UserModel)->updateProfile($_POST, $_SESSION['user_id'])) {
            Flash::addMessageToFlashNotifications('Changes saved');
            $this->redirect('/profile/show');
        } else {
            BaseView::renderTemplate('profile/edit.html', [
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
