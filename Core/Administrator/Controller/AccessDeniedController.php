<?php
/*
 * This file is part of the Evo package.
 *
 * (c) John Andrew <simplygenius78@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Evo\Administrator\Controller;

use Evo\Base\Exception\BaseInvalidArgumentException;
use Evo\Administrator\AccessDeniedCommander;

class AccessDeniedController extends \Evo\Administrator\Controller\AdminController
{

    /**
     * Extends the base constructor method. Which gives us access to all the base
     * methods implemented within the base controller class.
     * Class dependency can be loaded within the constructor by calling the
     * container method and passing in an associative array of dependency to use within
     * the class
     */
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
        $this->addDefinitions(
            [
                'commander' => AccessDeniedCommander::class,
            ]
        );

    }

    protected function indexAction()
    {
        $this->render('admin/accessDenied/index.html');
    }


}

