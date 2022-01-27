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
use Evo\View;

class Home extends BaseController
{
    public function index()
    {
        $sections = (new SectionModel())->getRepository()->findAll();
        $menus = (new MenuModel())->getRepository()->findAll();

        View::renderTemplate('home/index.html', [
            'sections' => $sections,
            'menus' => $menus,
        ]);
    }
}
