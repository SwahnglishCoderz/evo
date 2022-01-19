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

use Evo\Controller;
use Evo\Orm\DataLayerConfiguration;
use Evo\Orm\DataLayerEnvironment;
use Evo\Orm\DataLayerFactory;
use Evo\Orm\DataRepository\DataRepository;
use Evo\Orm\DataRepository\DataRepositoryFactory;
use Evo\Orm\Drivers\MysqlDatabaseConnection;
use Evo\View;
use \App\Auth;
use Symfony\Component\Dotenv\Dotenv;

class Home extends Controller
{
    /**
     * Show the index page
     */
    public function indexAction()
    {
//        $factory = new DataRepositoryFactory('application_data_access', 'sections', 'id');
//        $repository = $factory->create(DataRepository::class);
////        return $repository;
//        echo '<pre>';
//        print_r($repository);
//        echo '</pre>';
//        exit;
        View::renderTemplate('Home/index.html');
    }
}
