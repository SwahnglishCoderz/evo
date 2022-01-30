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
use App\Models\PermissionModel;
use App\Models\SectionModel;
use Evo\Base\BaseView;

class PermissionController extends Authenticated
{
    public function index()
    {
        // retrieve details of all permissions from the DB
        $permissions = (new PermissionModel())->getRepository()->findAll();
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('permission/index.html', ['permissions' => $permissions, 'sections' => $sections, 'menus' => $menus]);
    }

    public function new()
    {
        // display a form to create a new permission
        BaseView::renderTemplate('permission/create.html');
    }

    public function show()
    {
        // retrieve details of a single permission from the DB
        BaseView::renderTemplate('permission/show.html');
    }

    public function add()
    {
        // add new permission to DB
    }

    public function edit()
    {
        // display a form to update a permission
        BaseView::renderTemplate('permission/edit.html');
    }

    public function update()
    {
        // updates a permission in the DB
    }

    public function delete()
    {
        // deletes a permission from the DB
    }
}
