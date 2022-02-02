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
use Evo\Base\BaseController;
use Evo\Base\BaseView;
use Evo\Middleware\Before\LoginRequired;
use Throwable;

//class RoleController extends Authenticated
class RoleController extends BaseController
{
    protected function callBeforeMiddlewares(): array
    {
        return [
            'LoginRequired' => LoginRequired::class
        ];
    }

    /**
     * @throws Throwable
     */
    public function indexAction()
    {
        // retrieve details of all roles from the DB
        $roles = (new RoleModel())->getRepository()->findAll();
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('role/index.html', ['roles' => $roles, 'sections' => $sections, 'menus' => $menus]);
    }

    /**
     * @throws Throwable
     */
    public function newAction()
    {
        // display a form to create a new role
        BaseView::renderTemplate('role/create.html');
    }

    /**
     * @throws Throwable
     */
    public function showAction()
    {
        // retrieve details of a single role from the DB
        BaseView::renderTemplate('role/show.html');
    }

    public function addAction()
    {
        // add new role to DB
    }

    /**
     * @throws Throwable
     */
    public function editAction()
    {
        // display a form to update a role
        BaseView::renderTemplate('role/edit.html');
    }

    public function updateAction()
    {
        // updates a role in the DB
    }

    public function deleteAction()
    {
        // deletes a role from the DB
    }
}
