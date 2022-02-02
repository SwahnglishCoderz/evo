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
use Evo\Base\BaseController;
use Evo\Base\BaseView;
use Throwable;

//class PermissionController extends Authenticated
class PermissionController extends BaseController
{
    /**
     * @throws Throwable
     */
    public function indexAction()
    {
        // retrieve details of all permissions from the DB
        $permissions = (new PermissionModel())->getRepository()->findAll();
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('permission/index.html', ['permissions' => $permissions, 'sections' => $sections, 'menus' => $menus]);
    }

    /**
     * @throws Throwable
     */
    public function newAction()
    {
        // display a form to create a new permission
        BaseView::renderTemplate('permission/create.html');
    }

    /**
     * @throws Throwable
     */
    public function showAction()
    {
        // retrieve details of a single permission from the DB
        BaseView::renderTemplate('permission/show.html');
    }

    public function addAction()
    {
        // add new permission to DB
    }

    /**
     * @throws Throwable
     */
    public function editAction()
    {
        // display a form to update a permission
        BaseView::renderTemplate('permission/edit.html');
    }

    public function updateAction()
    {
        // updates a permission in the DB
    }

    public function deleteAction()
    {
        // deletes a permission from the DB
    }
}
