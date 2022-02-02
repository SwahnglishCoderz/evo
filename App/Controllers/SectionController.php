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

use Evo\Base\BaseController;
use Evo\Flash\Flash;
use App\Models\MenuModel;
use App\Models\SectionModel;
use Evo\Auth\Authorized;
use Evo\Base\BaseView;
use Evo\Middleware\Before\LoginRequired;
use Throwable;

//class SectionController extends Authenticated
class SectionController extends BaseController
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
        // retrieve details of all sections from the DB
        $sections = (new SectionModel)->getRepository()->findAll();
        $menus = (new MenuModel)->getRepository()->findAll();

        BaseView::renderTemplate('section/index.html', [
            'sections' => $sections,
            'menus' => $menus,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function createAction()
    {
        // display a form to create a new section
        BaseView::renderTemplate('section/create.html');
    }

    /**
     * @throws Throwable
     */
    public function showAction()
    {
        // retrieve details of a single section from the DB
        BaseView::renderTemplate('section/show.html');
    }

    /**
     * @throws Throwable
     */
    public function addAction()
    {
        $clean_data = (new SectionModel)->cleanData($_POST)->save();

        if ($clean_data) {
            Flash::addMessageToFlashNotifications('Section added successfully');
            $this->redirect(Authorized::getReturnToPage());
        } else {
            Flash::addMessageToFlashNotifications('Failed to add the section', Flash::WARNING);
        }
    }

    /**
     * @throws Throwable
     */
    public function editAction()
    {
        // display a form to update a section
        BaseView::renderTemplate('section/edit.html');
    }

    public function updateAction()
    {
        // updates a section in the DB
    }

    public function deleteAction()
    {
        // deletes a section from the DB
    }
}
