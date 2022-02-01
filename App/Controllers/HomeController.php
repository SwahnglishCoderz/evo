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
use Evo\Base\BaseController;
use Evo\Base\BaseView;
use Exception;
use Throwable;

class HomeController extends BaseController
{
    /**
     * @throws Exception
     * @throws Throwable
     */
    public function index()
    {
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        BaseView::renderTemplate('home/index.html', [
            'sections' => $sections,
            'menus' => $menus,
        ]);
    }
}
