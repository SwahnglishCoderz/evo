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
        View::renderTemplate('items/index.html');
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
