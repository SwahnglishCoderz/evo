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

namespace App\Controller;

use App\Models\MenuModel;
use App\Models\SectionModel;
use Evo\Base\BaseController;
use Evo\View;
use Evo\Base\Exception\BaseInvalidArgumentException;

class HomeController extends BaseController
{
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
    }

    public function index()
    {
//        echo '<pre>';
//        print_r('Home Controller');
        
//         $sections = (new SectionModel())->getRepository()->findAll();
//         $menus = (new MenuModel())->getRepository()->findAll();

//        echo '<pre>';
//        print_r($sections);
//
//        echo '<pre>';
//        print_r($menus);
//        exit;

         View::renderTemplate('home/index.html', [
        //     'sections' => $sections,
        //     'menus' => $menus,
         ]);
    }
}
