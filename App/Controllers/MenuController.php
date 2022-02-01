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
use Exception;
use Throwable;

class MenuController extends Authenticated
{
    /**
     * @throws Exception|Throwable
     */
    public function indexAction()
    {
        // retrieve details of all menus from the DB
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('menu/index.html', ['sections' => $sections, 'menus' => $menus]);
    }

    /**
     * @throws Exception|Throwable
     */
    public function newAction()
    {
        // display a form to create a new menu
        BaseView::renderTemplate('menu/create.html');
    }

    /**
     * @throws Exception|Throwable
     */
    public function showAction()
    {
        // retrieve details of a single menu from the DB
        BaseView::renderTemplate('menu/show.html');
    }

    public function addAction()
    {
        // add new menu to DB
    }

    /**
     * @throws Exception|Throwable
     */
    public function editAction()
    {
        // display a form to update a menu
        BaseView::renderTemplate('menu/edit.html');
    }

    public function updateAction()
    {
        // updates a menu in the DB
    }

    public function deleteAction()
    {
        // deletes a menu from the DB
    }
}
