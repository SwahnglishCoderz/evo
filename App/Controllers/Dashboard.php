<?php

namespace App\Controllers;

use Evo\View;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */

class Dashboard extends Authenticated
{

    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     */
//    protected function before()
//    {
//        $this->requireLogin();
//    }

    public function indexAction()
    {
        View::renderTemplate('Dashboard/index.html');
    }

    public function newAction()
    {
        echo "new action";
    }

    public function showAction()
    {
        echo "show action";
    }
}
