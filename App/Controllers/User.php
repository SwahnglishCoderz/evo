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
use App\Models\UserModel;
use Evo\Base\BaseView;

class User extends Authenticated
{
    public function index()
    {
        // retrieve details of all users from the DB
        $users = (new UserModel())->getRepository()->findAll();
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('user/index.html', ['users' => $users, 'sections' => $sections, 'menus' => $menus]);
    }

    public function new()
    {
        // display a form to create a new user
        BaseView::renderTemplate('user/create.html');
    }

    public function show()
    {
        // retrieve details of a single user from the DB
        BaseView::renderTemplate('user/show.html');
    }

    public function add()
    {
        // add new user to DB
    }

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
}
