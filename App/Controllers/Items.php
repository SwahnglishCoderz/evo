<?php

namespace App\Controllers;

use Evo\View;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */

class Items extends Authenticated
{

    /**
     * Require the user to be authenticated before giving access to all methods in the controller
     */
    /*
    protected function before()
    {
        $this->requireLogin();
    }
    */

    /**
     * Items index
     */
    public function indexAction()
    {
        View::renderTemplate('Items/index.html');
    }

    /**
     * Add a new item
     */
    public function newAction()
    {
        echo "new action";
    }

    /**
     * Show an item
     */
    public function showAction()
    {
        echo "show action";
    }
}
