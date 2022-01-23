<?php

namespace Evo\UserManager;

use Evo\Base\Administrator\AdminController;
use Evo\Orm\DataLayerTrait;

class UserManager extends AdminController
{
    use DataLayerTrait;

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
    }

    /**
     * Entry method which is hit on request. This method should be implemented within
     * all sub controller class as a default landing point when a request is
     * made.
     */
    protected function indexAction()
    {
        $inactiveUsers = $this->repository->getRepo()->count(['status' => 0]);
    }

}