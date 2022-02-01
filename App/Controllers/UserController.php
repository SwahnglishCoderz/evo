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

use App\Models\MenuModel;
use App\Models\SectionModel;
use App\Models\StatusModel;
use App\Models\UserModel;
use Evo\Base\BaseController;
use Evo\Base\BaseView;
use Evo\System\Status;
use Exception;
use Throwable;

class UserController extends Authenticated
//class UserController extends BaseController
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public function index()
    {
//        echo '<pre>';
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        $users = (new UserModel())->getRepository()->findAll();

//        print_r($this->getStats());
//        exit;

        BaseView::renderTemplate('user/index.html', ['users' => $users, 'sections' => $sections, 'menus' => $menus, 'stats' => $this->getStats()]);
    }

    /**
     * @throws Exception|Throwable
     */
    public function new()
    {
        // display a form to create a new user
        BaseView::renderTemplate('user/create.html');
    }

    /**
     * @throws Exception|Throwable
     */
    public function show()
    {
        // retrieve details of a single user from the DB
        BaseView::renderTemplate('user/show.html');
    }

    public function add()
    {
        // add new user to DB
    }

    /**
     * @throws Exception|Throwable
     */
    public function edit()
    {
        // display a form to update a user
        BaseView::renderTemplate('user/edit.html');
    }

    public function update()
    {
        // updates a user in the DB
    }

    public function delete()
    {
        // deletes a user from the DB
    }

    private function getStats()
    {
        $stats = (new StatusModel())->getRepository()->findAll();
//        print_r($stats);
//        exit;
        if ($stats) {
            $data = [];

            foreach ($stats as $stat) {
//            print_r($stat);
//                $data[$stat['id']] = [
                $data = [
                    'id' => $stat['id'],
                    'name' => $stat['name'],
                    'color' => $stat['color'],
                ];
//                print_r($data);
//                exit;
            }

            return $data;
        }
    }
}
