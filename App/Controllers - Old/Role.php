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
use App\Models\RoleModel;
use App\Models\SectionModel;
use Evo\View;

class Role extends Authenticated
{
    public function index()
    {
        // retrieve details of all roles from the DB
        $roles = (new RoleModel())->getRepository()->findAll();
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        View::renderTemplate('role/index.html', ['roles' => $roles, 'sections' => $sections, 'menus' => $menus]);
    }

    public function new()
    {
        // display a form to create a new role
        View::renderTemplate('role/create.html');
    }

    public function show()
    {
        // retrieve details of a single role from the DB
        View::renderTemplate('role/show.html');
    }

    public function add()
    {
        // add new role to DB
    }

    public function edit()
    {
        // display a form to update a role
        View::renderTemplate('role/edit.html');
    }

    public function update()
    {
        // updates a role in the DB
    }

    public function delete()
    {
        // deletes a role from the DB
    }
}
