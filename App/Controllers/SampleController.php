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

use Evo\Base\BaseView;

/**
 * Sample controller (example)
 *
 * PHP version 7.0
 */

class SampleController extends Authenticated
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
        BaseView::renderTemplate('sample/index.html');
    }

    /**
     * Add a new sample
     */
    public function newAction()
    {
        echo "new action";
    }

    /**
     * Show a sample
     */
    public function showAction()
    {
        echo "show action";
    }
}
