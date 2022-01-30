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
use Evo\Base\BaseView;

class MenuController extends Authenticated
{
    public function index()
    {
        // retrieve details of all menus from the DB
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('menu/index.html', ['sections' => $sections, 'menus' => $menus]);
    }

    public function new()
    {
        // display a form to create a new menu
        BaseView::renderTemplate('menu/create.html');
    }

    public function show()
    {
        // retrieve details of a single menu from the DB
        BaseView::renderTemplate('menu/show.html');
    }

    public function add()
    {
        // add new menu to DB
    }

    public function edit()
    {
        // display a form to update a menu
        BaseView::renderTemplate('menu/edit.html');
    }

    public function update()
    {
        // updates a menu in the DB
    }

    public function delete()
    {
        // deletes a menu from the DB
    }
}
